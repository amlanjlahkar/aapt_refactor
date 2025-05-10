<?php

namespace App\Http\Controllers\Efiling;

use App\Http\Controllers\Controller;
use App\Models\Efiling\CaseFile;
use App\Models\Efiling\Petitioner;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PetitionerController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(): void {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $case_file_id
     * @param  int  $step
     */
    public function create($step, $case_file_id): View {
        return view('user.efiling.original-application.petitioner-info', compact('step', 'case_file_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $case_file_id
     */
    public function store(Request $request, $case_file_id): RedirectResponse {
        $form_data = $request->all();
        $form_data['case_file_id'] = $case_file_id;
        $validated = Validator::make($form_data, [
            'case_file_id' => 'required|exists:case_files,id',
            'pet_type' => 'required|in:individual,organization',
            'pet_email' => 'required|string|email|max:50|unique:petitioners,pet_email',
            'pet_mobile' => 'required|string|size:10|regex:/^[0-9]{10}$/|unique:petitioners,pet_mobile',
            'pet_address' => 'required|string|max:250',
        ])->validate();

        $petitioner = Petitioner::create($validated);

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
    public function show(Petitioner $petitioner): void {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Petitioner $petitioner): void {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Petitioner $petitioner): void {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Petitioner $petitioner): void {
        //
    }
}
