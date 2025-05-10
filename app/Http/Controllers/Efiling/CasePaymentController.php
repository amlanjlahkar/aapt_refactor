<?php

namespace App\Http\Controllers\Efiling;

use App\Http\Controllers\Controller;
use App\Models\Efiling\CasePayment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CasePaymentController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(): void {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View {
        return view('user.efiling.original-application.case-payment');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CasePayment $casePayment): void {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CasePayment $casePayment): void {
        //
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
