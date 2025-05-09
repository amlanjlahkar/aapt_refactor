<?php

namespace App\Http\Controllers\Efiling;

use App\Http\Controllers\Controller;
use App\Models\Efiling\Respondent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RespondentController extends Controller
{
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
        return view('user.efiling.original-application.respondent-info');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Respondent $respondent): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Respondent $respondent): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Respondent $respondent): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Respondent $respondent): void
    {
        //
    }
}
