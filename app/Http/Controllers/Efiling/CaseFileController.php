<?php

namespace App\Http\Controllers\Efiling;

use App\Http\Controllers\Controller;
use App\Models\Efiling\CaseFile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class CaseFileController extends Controller {
    private function generateFilingNumber(): string {
        do {
            $filingNo = 'AAPT' . strtoupper(\Str::random(11));
        } while (CaseFile::where('filing_no', $filingNo)->exists());

        return $filingNo;
    }
    /**
     * @param mixed $case_file_id
     */
    public function generatePdf($case_file_id) {
        $case_file = CaseFile::with(['petitioners', 'respondents', 'documents', 'payment'])->findOrFail($case_file_id);
        $pdf = Pdf::loadView('user.efiling.original-application.summary-view', compact('case_file'));
        return $pdf->download('test.pdf');
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
        return view('user.efiling.original-application.case-filing', compact('step'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse {
        $form_data = $request->all();
        $form_data['filing_no'] = $this->generateFilingNumber();
        $form_data['filing_date'] = now();
        $form_data['filing_number'] = 'Auto-' . now()->year;

        $validated = Validator::make($form_data, [
            'filing_no' => 'required|string|max:15|unique:case_files',
            'filing_date' => 'required|date',
            'filing_number' => 'required|string',
            'case_type' => 'nullable|string',
            'bench' => 'nullable|string',
            'subject' => 'nullable|string',
            'legal_aid' => 'nullable|boolean',
            'step' => 'nullable|integer',
            'filed_by' => 'nullable|string',
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
    public function show(Request $request) {
        $case_file_id = $request->case_file_id;
        $case_file = CaseFile::with(['petitioners', 'respondents', 'documents', 'payment'])->findOrFail($case_file_id);

        return view('user.efiling.original-application.review', compact('case_file'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param mixed $_unused
     * @param int $case_file_id
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
