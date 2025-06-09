<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\Scrutiny;
use App\Models\Efiling\CaseFile;
use Illuminate\Http\Request;

class ScrutinyController extends Controller
{
    public function index()
    {
        $cases = CaseFile::where('case_status', 'pending')->get();
        return view('scrutiny.list-pending-cases', compact('cases'));
    }

    public function create($caseFileId)
    {
        $case = CaseFile::findOrFail($caseFileId);

        $checklists = [
            [1, 'IS THE APPLICATION IN THE PROPER FORM? (THREE COMPLETE PAPERS BOOKS IN FORM-I IN TWO COMPILATIONS)', 'YES'],
            [2, 'WHETHER NAME, DESCRIPTION AND ADDRESS OF ALL THE PARTIES BEEN FURNISHED IN THE CAUSE TITLE?', 'YES'],
            [3.1, 'HAS THE APPLICATION BEEN DULY SIGNED AND VERIFIED?', 'YES'],
            [3.2, 'HAVE THE COPIES BEEN DULY SIGNED?', 'YES'],
            [3.3, 'HAVE SUFFICIENT NUMBER OF COPIES OF THE APPLICATION BEEN FILED?', 'YES'],
            [4, 'WHETHER ALL THE NECESSARY PARTIES ARE IMPLEADED?', 'YES'],
            [5, 'WHETHER ENGLISH TRANSLATION OF DOCUMENTES IN A LANGUAGE OTHER THAN ENGLISH OR HINDI BEEN FILED?', 'NA'],
            [6, 'IS THE APPLICATION IN TIME? (SEE SECTION 21)', 'YES'],
            [7, 'HAS THE VAKALATNAMA/MEMO OF APPEARANCE/AUTHORISATION BEEN FILED?', 'YES'],
            [8, 'IS THE APPLICATION MAINTAINABLE? (U/S 2, 14, 18 OR U.R. 8 ETC.)', 'YES'],
            [9, 'IS THE APPLICATION ACCOMPANIED BY IPO/DD FOR RS. 50?', 'YES'],
            [10, 'HAS THE IMPUGNED ORDERS ORIGINAL/DULY ATTESTED LEGIBLE COPY BEEN FILED?', 'YES'],
            [11, 'HAVE LEGIBLE COPIES OF THE ANNEXURES DULY ATTESTED BEEN FILED?', 'YES'],
            [12, 'HAS THE INDEX OF DOCUMENTS BEEN FILED AND PAGINATION DOES PROPERLY?', 'YES'],
            [13, 'HAS THE APPLICATION EXHAUSTED ALL AVAILABLE REMEDIES?', 'YES'],
            [14, 'HAS THE DECLARATION AS REQUIRED BY ITEM 7 OF FORM I BEEN MADE?', 'YES'],
            [15, 'HAVE REQUIRED NUMBER OF ENVELOPES (FILE SIZE) BEARING FULL ADDRESS OF THE RESPONDENTS BEEN FILED?', 'NO'],
            [16.1, 'WHETHER THE RELIEFS SOUGHT FOR, ARISE OUT OF SINGLE CAUSE OF ACTION?', 'YES'],
            [16.2, 'WHETHER ANY INTERIM RELIEF IS PRAYED FOR?', 'YES'],
            [17, 'IN CASE AN M.A. FOR CONDONATION OF DELAY IS FILED, IS IT SUPPORTED BY AN AFFIDAVIT OF THE APPLICANT?', 'NA'],
            [18, 'WHETHER THIS CASE CAN BE HEARD BY SINGLE BENCH?', 'SB'],
            [19, 'ANY OTHER POINT?', 'NA'],
            [20, 'RESULT OF THE SCRUTINY WITH INITIAL OF THE SCRUTINY CLERK.', 'YES'],
            [20.1, 'MA FOR JOINING TOGETHER U/R 4(5) (a), 4(5)(b)', 'NA'],
            [20.2, 'MA U/R 6 OF C.A.T. PROCEDURE RULES 1987', 'NA'],
            [20.3, 'PT U/S 25 OF AT ACT, 1985', 'NA'],
            [20.4, 'MA FOR CONDONATION OF DELAY', 'NA'],
            [20.5, 'LIST OF EVENT WITH DATES/SYNOPSIS', ''],
        ];

        return view('scrutiny.scrutinize-case-form', compact('case', 'checklists'));
    }



    
    public function store(Request $request)
    {
        $user = auth()->user(); // Add this line before validation

        $request->validate([
            'case_file_id' => 'required|exists:case_files,id',
            'filing_number' => ['required',
                                    Rule::unique('scrutiny')->where(function ($query) use ($request) {
                                        return $query->where('case_file_id', $request->case_file_id)
                                                    ->where('level', $request->level);
                                    }),
                                ],
            'objection_status' => 'required|in:defect,defect_free',
            'scrutiny_status' => 'required|in:Pending,Forwarded,Rejected,Completed',
            'scrutiny_date' => 'required|date',
            'remarks' => 'nullable|string|max:500',
            'responses' => 'nullable|array',             // Add validation for checklist responses
            'remarks_checklist' => 'nullable|array',     // Remarks per checklist item
        ]);

        $user = auth()->user();
        $case = CaseFile::findOrFail($request->case_file_id);

        $scrutiny = new Scrutiny($request->all());
        $scrutiny->user_id = $user->id;
        $scrutiny->level = $user->scrutiny_level ?? 1;

        $scrutiny->scrutiny_status = match (true) {
            $scrutiny->level < 3 && $request->objection_status === 'defect_free' => 'Forwarded',
            $scrutiny->level == 3 && $request->objection_status === 'defect_free' => 'Completed',
            default => 'Rejected',
        };

        // Assign other_objection explicitly if present
        $scrutiny->other_objection = $request->input('other_objection');

        // Store remarks in appropriate field depending on level
        if ($scrutiny->level == 1) {
            $scrutiny->remarks_registry = $request->remarks;
        } elseif ($scrutiny->level == 2) {
            $scrutiny->remarks_section_officer = $request->remarks;
        } elseif ($scrutiny->level == 3) {
            $scrutiny->remarks_dept_head = $request->remarks;
        }

        $scrutiny->save();

        // Update case status based on objection_status and level
        if ($request->objection_status === 'defect') {
            $case->case_status = 'defect';
        } elseif ($request->objection_status === 'defect_free' && $scrutiny->level === 3) {
            $case->case_status = 'defect_free';
        }
        $case->save();

        // Handle objections if objection_status is 'defect' and responses present
        if ($request->objection_status === 'defect' && is_array($request->responses)) {
            $responses = $request->input('responses');
            $remarksChecklist = $request->input('remarks_checklist', []);

            foreach ($responses as $defectNo => $response) {
                if (strtoupper($response) === 'NO') {
                    // Create or update objection for this defect code
                    Objection::updateOrCreate(
                        [
                            'case_file_id' => $request->case_file_id,
                            'filing_number' => $request->filing_number,
                            'objection_code' => $defectNo,
                        ],
                        [
                            'status' => 'Pending',
                            'remarks' => $remarksChecklist[$defectNo] ?? null,
                            'user_id' => $user->id,
                        ]
                    );
                } else {
                    // Delete objection if defect resolved or not applicable
                    Objection::where('case_file_id', $request->case_file_id)
                        ->where('filing_number', $request->filing_number)
                        ->where('objection_code', $defectNo)
                        ->delete();
                }
            }
        } elseif ($request->objection_status === 'defect_free') {
            // If defect_free, delete all objections for this case & filing_number
            Objection::where('case_file_id', $request->case_file_id)
                ->where('filing_number', $request->filing_number)
                ->delete();
        }

        return redirect()->route('scrutiny.index')->with('success', 'Scrutiny submitted successfully.');
    }

    // public function show($caseFileId)
    // {
    //     $case = CaseFile::findOrFail($caseFileId);

    //     // eager-load anything else you need, e.g. ->with('documents')
    //     return view('scrutiny.view_case', compact('case'));
    // }
}
