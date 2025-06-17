<?php

namespace App\Http\Controllers\Efiling;

use App\Http\Controllers\Controller;
use App\Models\Efiling\CaseFile;
use App\Models\Internal\Subject\SubjectMaster;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

class CaseFileController extends Controller {
    private function generateFilingNumber(): string {
        do {
            $filingNum = 'AAPT' . strtoupper(\Str::random(11));
        } while (CaseFile::where('filing_number', $filingNum)->exists());

        return $filingNum;
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
        return $pdf->name('aapt_filled_form_' . $case_file->filing_number);
    }

    /**
     * @param  int  $case_file_id
     */
    public function showSubmitNotice($case_file_id): View {
        CaseFile::where('id', $case_file_id)->update(['status' => 'Pending']);

        return view('user.efiling.submit-notice', compact('case_file_id'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): void {
        //
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
        $form_data['filing_number'] = $this->generateFilingNumber();
        $form_data['filing_date'] = now();
        $form_data['user_id'] = Auth::id();

        $validated = Validator::make($form_data, [
            'filing_number' => 'required|string|max:15|unique:case_files',
            'filing_date' => 'required|date',
            'case_type' => 'required|string',
            'bench' => 'required|string',
            'subject' => 'required|string',
            'legal_aid' => 'required|boolean',
            'filed_by' => 'required|in:Advocate,Applicant in Person,Intervener',
            'step' => 'nullable|integer',
            'status' => 'nullable|string',
            'user_id' => 'required|integer',
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
}
