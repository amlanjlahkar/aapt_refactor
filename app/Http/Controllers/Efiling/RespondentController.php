<?php

namespace App\Http\Controllers\Efiling;

use App\Http\Controllers\Controller;
use App\Models\Efiling\CaseFile;
use App\Models\Efiling\Respondent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RespondentController extends Controller {
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
     * @param  mixed  $step
     */
    public function create($step, $case_file_id): View {
        return view('user.efiling.original-application.respondent-info', compact('step', 'case_file_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  mixed  $_unused
     * @param  int  $case_file_id
     */
    public function store(Request $request, $_unused, $case_file_id): RedirectResponse {
        $form_data = $request->all();
        $form_data['case_file_id'] = $case_file_id;

        $validated = Validator::make($form_data, [
            'case_file_id' => 'required|exists:case_files,id',
            'res_type' => 'required|in:Individual,Organization',
            'res_email' => 'required|string|email|max:50|unique:respondents,res_email',
            'res_phone' => 'required|string|size:10|regex:/^[0-9]{10}$/|unique:respondents,res_phone',
            'res_address' => 'required|string|max:250',

            // Validate individual fields
            'res_name' => 'required_if:res_type,Individual|string',
            'res_age' => 'required_if:res_type,Individual|integer',
            'res_state' => 'required_if:res_type,Individual|string',
            'res_district' => 'required_if:res_type,Individual|string',

            // Validate organizational fields
            'res_ministry' => 'required_if:res_type,Organization|string',
            'res_department' => 'required_if:res_type,Organization|string',
            'res_contact_person' => 'required_if:res_type,Organization|string',
            'res_designation' => 'required_if:res_type,Organization|string',

        ])->validate();

        Respondent::create($validated);

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
    public function show(Respondent $respondent): void {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $case_file_id
     */
    public function edit(Respondent $respondent, $case_file_id): JsonResponse {
        $current_case_file = CaseFile::findOrFail($case_file_id);

        return response()->json($current_case_file->respondents->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Respondent $respondent): void {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Respondent $respondent): void {
        //
    }
}
