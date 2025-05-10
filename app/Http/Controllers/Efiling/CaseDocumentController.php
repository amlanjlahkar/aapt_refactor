<?php

namespace App\Http\Controllers\Efiling;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CaseDocumentController extends Controller {
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
        return view('user.efiling.original-application.case-document');
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
    public function show(string $id): void {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): void {
        //
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
