<?php

namespace App\Http\Controllers\Efiling;

use App\Http\Controllers\Controller;
use App\Models\Efiling\CaseFile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CaseFileController extends Controller
{
    private function generateFilingNumber(): string
    {
        do {
            $filingNo = 'AAPT'.strtoupper(\Str::random(11));
        } while (CaseFile::where('filing_no', $filingNo)->exists());

        return $filingNo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('user.efiling.original-application.case-filing');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $formData = $request->all();
        $formData['filing_no'] = $this->generateFilingNumber();
        $formData['filing_date'] = now();
        $formData['filing_number'] = 'Auto-'.now()->year;

        $validated = Validator::make($formData, [
            'filing_no' => 'required|string|max:15|unique:case_files',
            'filing_date' => 'required|date',
            'filing_number' => 'required|string',
            'case_type' => 'sometimes|string',
            'bench' => 'sometimes|string',
            'subject' => 'nullable|string',
            'legal_aid' => 'nullable|boolean',
            'step' => 'sometimes|integer',
            'filed_by' => 'nullable|string',
            'status' => 'sometimes|string',
        ])->validate();

        $caseFile = CaseFile::create($validated);
        $caseFile->refresh();

        $step = $caseFile->step + 1;

        return to_route('user.efiling.register.step'.$step)->with('step', $step);
    }

    /**
     * Display the specified resource.
     */
    public function show(CaseFile $caseFile): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CaseFile $caseFile): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CaseFile $caseFile): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CaseFile $caseFile): void
    {
        //
    }
}
