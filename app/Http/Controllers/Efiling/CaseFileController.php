<?php

namespace App\Http\Controllers\Efiling;

use App\Http\Controllers\Controller;
use App\Models\Efiling\CaseFile;
use App\Models\Internal\Subject\SubjectMaster;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;
use App\Models\BenchComposition;
use Carbon\Carbon;
use App\Models\CaseAllocation;
use App\Models\Internal\Purpose\PurposeMaster;


class CaseFileController extends Controller {
    private function generateRefNumber(): string {
        do {
            $refNo = 'AAPT' . strtoupper(\Str::random(11));
        } while (CaseFile::where('ref_number', $refNo)->exists());

        return $refNo;
    }

    /**
     * Generate e-filing receipt
     *
     * @param  int  $case_file_id
     */
    public function generatePdf($case_file_id = 1): PdfBuilder {
        $case_file = CaseFile::with(['petitioners', 'respondents', 'documents', 'payment'])->findOrFail($case_file_id);
        $pdf = Pdf::view('user.efiling.original-application.summary-view', compact('case_file'))
            ->withBrowsershot(function (Browsershot $b) {
                $b->timeout(300)
                    // must be removed/adjusted once in prod
                    ->setNodeBinary('/Users/amlan/.local/state/fnm_multishells/42270_1747302996728/bin/node')
                    ->setNpmBinary('/Users/amlan/.local/state/fnm_multishells/42591_1747303042315/bin/npm');
            });

        // use a more detailed name including date and time
        return $pdf->name('generated_case_file');
    }

    /**
     * @param  int  $case_file_id
     */
    public function showSubmitNotice($case_file_id): View {
        CaseFile::where('id', $case_file_id)->update(['status' => 'Pending']);

        return view('user.efiling.submit-notice', compact('case_file_id'));
    }

    /**
     * Display a listing of the resource(for case Allocation).
     */
    
    public function index(Request $request): View
    {
        $cases = collect(); // default empty collection
        
        // Set default values for sequential search
        $defaultCaseType = 'Original Application';
        $defaultCaseNo = session('next_case_no', 1);
        $defaultYear = session('next_case_year', date('Y'));
        
        // Use defaults if not provided
        $caseType = $request->input('case_type', $defaultCaseType);
        $caseNo = $request->input('case_no', $defaultCaseNo);
        $year = $request->input('year', $defaultYear);
        
        // Always search for the specific case (no user input allowed)
        if ($request->filled('bench_id') && $request->filled('date')) {
            $query = CaseFile::query();
            
            // Fixed search criteria - USE case_reg_year instead of whereYear('created_at')
            $query->where('case_type', $caseType)
                ->where('case_reg_no', $caseNo)
                ->where('case_reg_year', $year)  // Changed this line
                ->where('case_status', 'registered');
            
            // Get the results with related petitioners and respondents
            $cases = $query->with(['petitioners', 'respondents'])->latest()->get();
            
            // Filter out cases that are already allocated to this bench on the selected date
            $benchId = $request->input('bench_id');
            $selectedDate = $request->input('date');
            
            $cases = $cases->filter(function ($case) use ($benchId, $selectedDate) {
                $existingAllocation = CaseAllocation::where([
                    'case_file_id' => $case->id,
                    'bench_id' => $benchId,
                    'causelist_date' => $selectedDate,
                ])->exists();
                
                return !$existingAllocation; // Only include cases that are NOT already allocated
            });
            
            // Store current search parameters in session for next search
            session([
                'current_case_no' => $caseNo,
                'current_case_year' => $year
            ]);
            
            // Debug: Add this temporarily to see what's being searched
            \Log::info('Search Parameters:', [
                'case_type' => $caseType,
                'case_reg_no' => $caseNo,
                'case_reg_year' => $year,
                'case_status' => 'registered',
                'results_count' => $cases->count()
            ]);
        }
        
        // Use current date if no date provided
        $selectedDate = $request->input('date') ? Carbon::parse($request->input('date')) : now();
        
        $benches = BenchComposition::with(['court', 'judge', 'benchType'])
            ->where('display', true)
            ->whereDate('from_date', '<=', $selectedDate)
            ->orderBy('court_no')
            ->orderBy('bench_type')
            ->get();

        
        
        $purposes = PurposeMaster::orderBy('purpose_name')->get();

        return view('admin.efiling.case_files.list_case', [
            'cases' => $cases,
            'benches' => $benches,
            'purposes' => $purposes, // Add this line
            'selectedDate' => $selectedDate,
            'filters' => [
                'date' => $request->input('date'),
                'bench_id' => $request->input('bench_id'),
                'case_type' => $caseType,
                'case_no' => $caseNo,
                'year' => $year
            ],
        ]);
    }




    /**
     * Store a newly created allocation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAllocation(Request $request)
    {
        $validated = $request->validate([
            'case_id' => 'required|exists:case_files,id',
            'bench_id' => 'required|exists:bench_compositions,id',
            'causelist_date' => 'required|date',
            'purpose' => 'required|exists:purpose_master,id', // Changed validation
            'current_case_no' => 'required|integer',
            'current_year' => 'required|integer',
        ]);

        // Check for duplicate allocation
        $existing = CaseAllocation::where([
            'case_file_id' => $validated['case_id'],
            'bench_id' => $validated['bench_id'],
            'causelist_date' => $validated['causelist_date'],
        ])->first();

        if ($existing) {
            return back()->with('error', 'This case is already allocated to the selected bench on this date.');
        }

        // Get the next serial number for this causelist date and bench
        $nextSerialNo = CaseAllocation::where('causelist_date', $validated['causelist_date'])
            ->where('bench_id', $validated['bench_id'])
            ->max('serial_no') + 1;

        // Create the allocation
        CaseAllocation::create([
            'case_file_id' => $validated['case_id'],
            'bench_id' => $validated['bench_id'],
            'causelist_date' => $validated['causelist_date'],
            'purpose_id' => $validated['purpose'], // using  purpose_id directly
            'serial_no' => $nextSerialNo,
            'status' => 'Draft',
            'entry_date' => now(),
            'user_id' => auth('admin')->id(),
            'priority' => 0,
        ]);

        // Calculate next case number and year for sequential search
        $nextCaseNo = $validated['current_case_no'] + 1;
        $nextYear = $validated['current_year'];
        
        // Check if we need to move to next year
        $maxCaseNoForYear = CaseFile::where('case_type', 'Original Application')
            ->where('case_reg_year', $nextYear) // Use case_reg_year instead of whereYear('created_at')
            ->max('case_reg_no');
        
        // If next case number exceeds max for current year, move to next year and reset to 1
        if ($maxCaseNoForYear && $nextCaseNo > $maxCaseNoForYear + 10) { // +10 buffer for new cases
            $nextYear = $nextYear + 1;
            $nextCaseNo = 1;
        }
        
        // Store next case details in session
        session([
            'next_case_no' => $nextCaseNo,
            'next_case_year' => $nextYear
        ]);

        // Redirect back to search for next case automatically
        return redirect()->route('admin.efiling.case_files.index', [
            'date' => $validated['causelist_date'],
            'bench_id' => $validated['bench_id'],
            'case_type' => 'Original Application',
            'case_no' => $nextCaseNo,
            'year' => $nextYear
        ])->with('success', 'Case allocated successfully to the selected bench. Searching for next case...');
    }

    /**
     * Get the next available case number for the current year.
     *
     * @param  int  $year
     * @return int
     */
    private function getNextAvailableCaseNumber($year)
    {
        $lastCase = CaseFile::where('case_type', 'Original Application')
            ->whereYear('created_at', $year)
            ->orderBy('case_reg_no', 'desc')
            ->first();
        
        return $lastCase ? $lastCase->case_reg_no + 1 : 1;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $step
     */
    public function create($step): View {
        $subjects = SubjectMaster::pluck('subject_name');

        return view('user.efiling.original-application.case-filing', compact('step', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse {
        $form_data = $request->all();
        $form_data['ref_number'] = $this->generateRefNumber();
        $form_data['filing_number'] = 'Auto-' . now()->year;
        $form_data['filing_date'] = now();

        $validated = Validator::make($form_data, [
            'ref_number' => 'required|string|max:15|unique:case_files',
            'filing_number' => 'required|string',
            'filing_date' => 'required|date',
            'case_type' => 'nullable|string',
            'bench' => 'required|string',
            'subject' => 'required|string',
            'legal_aid' => 'required|boolean',
            'filed_by' => 'required|in:Advocate,Applicant in Person,Intervener',
            'step' => 'nullable|integer',
            'status' => 'nullable|string',
        ])->validate();

        $case_file = CaseFile::create($validated);
        $case_file->increment('step');
        $case_file->refresh();

        return to_route('user.efiling.register.step' . $case_file->step . '.create',
            [
                'step' => $case_file->step,
                'case_file_id' => $case_file->id,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): View {
        $case_file_id = $request->case_file_id;
        $case_file = CaseFile::with(['petitioners', 'respondents', 'documents', 'payment'])->findOrFail($case_file_id);

        return view('user.efiling.original-application.review', compact('case_file'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  mixed  $_unused
     * @param  int  $case_file_id
     */
    public function edit(CaseFile $caseFile, $case_file_id): JsonResponse {
        $current_case_file = $caseFile->findOrFail($case_file_id);

        return response()->json($current_case_file->getAttributes());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CaseFile $caseFile): void {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CaseFile $caseFile): void {
        //
    }

    public function viewFiledCase($case_file_id): View
    {
        $case_file = CaseFile::with(['petitioners', 'respondents', 'documents', 'payment'])->findOrFail($case_file_id);

        // Adjust this view as needed
        return view('internal.scrutiny.show-case', compact('case_file'));
    }

}
