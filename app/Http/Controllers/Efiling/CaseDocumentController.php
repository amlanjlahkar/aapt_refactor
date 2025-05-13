<?php

namespace App\Http\Controllers\Efiling;

use App\Http\Controllers\Controller;
use App\Models\Efiling\CaseDocument;
use App\Models\Efiling\CaseFile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CaseDocumentController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(): void {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  mixed  $step
     * @param  mixed  $case_file_id
     */
    public function create($step, $case_file_id): View {
        return view('user.efiling.original-application.case-document', compact('step', 'case_file_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  mixed  $_unused
     * @param  int  $case_file_id
     */
    public function store(Request $request, $_unused, $case_file_id): RedirectResponse {
        $form_data = $request->except('document_path');

        $document = null;

        if ($request->has('document_path')) {
            $document = $request->file('document_path');
            $form_data['document_path'] = $document;
            $form_data['document_type'] = $document->getClientMimeType();
            $form_data['original_name'] = $document->getClientOriginalName();
        }

        $form_data['case_file_id'] = $case_file_id;

        $validated = Validator::make($form_data, [
            'case_file_id' => 'required|exists:case_files,id',
            'document_path' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'document_type' => 'nullable|string',
            'original_name' => 'nullable|string',
        ])->validate();

        if ($document && $document->isValid()) {
            $validated['document_path'] ??= $document->store('docs', 'public');
        }

        CaseDocument::create($validated);

        $case_file = CaseFile::findOrFail($case_file_id);
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
    public function show(string $id): void {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $case_file_id
     */
    public function edit(CaseDocument $caseDocument, $case_file_id): JsonResponse {
        $current_case_file = CaseFile::findOrFail($case_file_id);

        return response()->json($current_case_file->documents->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void {
        //
    }
}
