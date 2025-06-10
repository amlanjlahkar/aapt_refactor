<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\Scrutiny;
use App\Models\Efiling\CaseFile;
use Illuminate\Http\Request;
use App\Models\Objection;
use Illuminate\Support\Facades\Auth;

class ScrutinyController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        // Get the role (assumes each admin has only one role)
        $role = $admin->roles->pluck('name')->first();

       $levelMap = [
                        'scrutiny-admin' => 1,         
                        'registry-reviewer' => 1,
                        'section-officer' => 2,
                        'department-head' => 3,
                    ];


        // Filter admin's roles to only scrutiny roles
        $role = $admin->roles->pluck('name')->intersect(array_keys($levelMap))->first();

        $currentLevel = $levelMap[$role] ?? null;


        if (!$currentLevel) {
            abort(403, 'Unauthorized role');
        }

        $cases = CaseFile::where('case_status', 'pending')
            ->with(['scrutinies' => function ($q) {
                $q->latest('created_at');
            }])
            ->get()
            ->filter(function ($case) use ($currentLevel) {
                $latest = $case->scrutinies->first();

                // Level 1: show if no scrutiny or scrutiny level is 1 and not forwarded
                if ($currentLevel == 1) {
                    return !$latest || $latest->level == 1;
                }

                // Level 2: show if latest scrutiny is level 1 and forwarded
                if ($currentLevel == 2) {
                    return $latest && $latest->level == 1 && $latest->status == 'forwarded';
                }

                // Level 3: show if latest scrutiny is level 2 and forwarded
                if ($currentLevel == 3) {
                    return $latest && $latest->level == 2 && $latest->status == 'forwarded';
                }

                return false;
            })
            ->map(function ($case) {
                $latestScrutiny = $case->scrutinies->first();
                $case->scrutiny_status = $latestScrutiny ? ucfirst($latestScrutiny->status) : 'Not Started';
                $case->scrutiny_level = $latestScrutiny ? $latestScrutiny->level : null;
                return $case;
            });

        return view('scrutiny.scrutiny-case-list', compact('cases'));
    }


    public function create($caseFileId)
    {
        $case = CaseFile::with(['scrutinies' => function ($q) {
            $q->latest('created_at');
        }])->findOrFail($caseFileId);

        $latestScrutiny = $case->scrutinies->first();
        $nextLevel = $latestScrutiny ? $latestScrutiny->level + 1 : 1;

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

        return view('scrutiny.scrutinize-case-form', compact('case', 'checklists', 'nextLevel'));
    }



    
    public function store(Request $request)
    {
        $user = auth()->user(); // Get the current user

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
            'responses' => 'nullable|array',
            'remarks_checklist' => 'nullable|array',
        ]);

        $case = CaseFile::findOrFail($request->case_file_id);

        $scrutiny = new Scrutiny($request->all());
        $scrutiny->user_id = $user->id;
        $scrutiny->level = $user->scrutiny_level ?? 1;

        $scrutiny->scrutiny_status = match (true) {
            $scrutiny->level < 3 && $request->objection_status === 'defect_free' => 'Forwarded',
            $scrutiny->level == 3 && $request->objection_status === 'defect_free' => 'Completed',
            default => 'Rejected',
        };

        // Assign other_objection if present
        $scrutiny->other_objection = $request->input('other_objection');

        // Store remarks based on scrutiny level
        if ($scrutiny->level == 1) {
            $scrutiny->remarks_registry = $request->input('remarks_registry');
        } elseif ($scrutiny->level == 2) {
            $scrutiny->remarks_section_officer = $request->input('remarks_section_officer');
        } elseif ($scrutiny->level == 3) {
            $scrutiny->remarks_dept_head = $request->input('remarks_dept_head');
        }

        $scrutiny->save();

        // Update case status
        if ($request->objection_status === 'defect') {
            $case->case_status = 'defect';
        } elseif ($request->objection_status === 'defect_free' && $scrutiny->level === 3) {
            $case->case_status = 'defect_free';
        }

        // Update scrutiny_level to progress to next level if defect_free
        if ($request->objection_status === 'defect_free') {
            if ($scrutiny->level < 3) {
                $case->scrutiny_level = $scrutiny->level + 1;
            } else {
                $case->scrutiny_level = 3; // Keep at final level
            }
        } elseif ($request->objection_status === 'defect') {
            $case->scrutiny_level = $scrutiny->level; // Stay at current level
        }

        $case->save();

        // Handle objections
        if ($request->objection_status === 'defect' && is_array($request->responses)) {
            $responses = $request->input('responses');
            $remarksChecklist = $request->input('remarks_checklist', []);

            foreach ($responses as $defectNo => $response) {
                if (strtoupper($response) === 'NO') {
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
                    Objection::where('case_file_id', $request->case_file_id)
                        ->where('filing_number', $request->filing_number)
                        ->where('objection_code', $defectNo)
                        ->delete();
                }
            }
        } elseif ($request->objection_status === 'defect_free') {
            // Delete all objections if scrutiny is defect-free
            Objection::where('case_file_id', $request->case_file_id)
                ->where('filing_number', $request->filing_number)
                ->delete();
        }

        return redirect()->route('scrutiny.index')->with('success', 'Scrutiny submitted successfully.');
    }

    public function show(CaseFile $case): View
    {
        return view('admin.scrutiny.show', compact('case'));
    }


}
