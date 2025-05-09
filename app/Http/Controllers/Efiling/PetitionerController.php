<?php

namespace App\Http\Controllers\Efiling;

use App\Http\Controllers\Controller;
use App\Models\Efiling\Petitioner;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PetitionerController extends Controller
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
        return view('user.efiling.original-application.petitioner-info');
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
    public function show(Petitioner $petitioner): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Petitioner $petitioner): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Petitioner $petitioner): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Petitioner $petitioner): void
    {
        //
    }
}
