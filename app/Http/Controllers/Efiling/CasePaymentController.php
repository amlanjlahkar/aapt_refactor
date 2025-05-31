<?php

namespace App\Http\Controllers\Efiling;

use App\Http\Controllers\Controller;
use App\Models\Efiling\CaseFile;
use App\Models\Efiling\CasePayment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CasePaymentController extends Controller {
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
     * @param  int  $case_file_id
     */
    public function create($step, $case_file_id): View {
        return view('user.efiling.original-application.case-payment', compact('step', 'case_file_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  mixed  $_unused
     * @param  int  $case_file_id
     */
    public function store(Request $request, $_unused, $case_file_id): RedirectResponse {
        $form_data = $request->except('payment_receipt');

        $document = $request->file('payment_receipt');

        $form_data['case_file_id'] = $case_file_id;
        $form_data['payment_receipt'] = $document;

        $validated = Validator::make($form_data, [
            'case_file_id' => 'required|exists:case_files,id',
            'payment_mode' => 'required|in:Demand Draft,Indian Post,Bharat Kosh',
            'amount' => 'nullable|numeric',
            'ref_no' => 'nullable|string',
            'ref_date' => 'nullable|date',
            'transaction_id' => 'nullable|string',
            'payment_receipt' => 'required|file|mimes:pdf|max:5120',
        ])->validate();

        if ($document->isValid()) {
            $validated['payment_receipt'] = $document->store('efiling/payment_receipts', 'public');
        }

        CasePayment::create($validated);

        return to_route('user.efiling.register.review', compact('case_file_id'));
        // return to_route('user.efiling.register.review', ['case_file_id' => 3]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CasePayment $casePayment): void {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $case_file_id
     */
    public function edit(CasePayment $casePayment, $case_file_id): JsonResponse {
        $current_case_file = CaseFile::findOrFail($case_file_id);

        return response()->json($current_case_file->payment->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CasePayment $casePayment): void {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CasePayment $casePayment): void {
        //
    }
}
