<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Efiling\CaseFile;
use App\Models\Scrutiny;
use App\Models\Objection;

class ScrutinyController extends Controller
{
    public function index()
    {
       $cases = CaseFile::whereRaw('LOWER("status") = ?', ['pending'])
            ->with('latestScrutiny')
            ->get();

        return view('scrutiny.scrutiny-case-list', compact('cases'));
    }




public function create($caseFileId)
{
    // Fetch case with completed scrutiny relationship
    $case = CaseFile::with('completedScrutiny')->findOrFail($caseFileId);

    // Check if the case has already been marked as scrutinized (Completed)
    if ($case->completedScrutiny) {
        return redirect()->route('scrutiny.index')->with('error', 'This case has already been scrutinized.');
    }

    // Predefined checklist items
    $checklists = [
        [1, 'IS THE APPLICATION IN THE PROPER FORM?', 'YES'],
        [2, 'ARE NAMES AND ADDRESSES COMPLETE IN THE CAUSE TITLE?', 'YES'],
        [3, 'HAS THE APPLICATION BEEN SIGNED AND VERIFIED?', 'YES'],
        [4, 'ARE SUFFICIENT COPIES FILED?', 'YES'],
        [5, 'IS THE APPLICATION MAINTAINABLE?', 'YES'],
        [6, 'IS IPO/DD FOR RS. 50 ATTACHED?', 'YES'],
        [7, 'ARE COPIES OF ANNEXURES LEGIBLE AND ATTESTED?', 'YES'],
        [8, 'IS INDEX AND PAGINATION CORRECT?', 'YES'],
        [9, 'ANY OTHER POINT?', 'NA'],
    ];

    // Return scrutiny form view
    return view('scrutiny.scrutinize-case-form', compact('case', 'checklists'));
}
 


    public function store(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $request->validate([
            'case_file_id' => 'required|exists:case_files,id',
            'filing_number' => [
                'required',
                Rule::unique('scrutiny')->where(fn($q) =>
                    $q->where('case_file_id', $request->case_file_id)
                ),
            ],
            'objection_status' => 'required|in:defect,defect_free',
            'scrutiny_status' => 'required|in:Pending,Forwarded,Rejected,Completed',
            'scrutiny_date' => 'required|date',
            'responses' => 'nullable|array',
            'remarks_checklist' => 'nullable|array',
        ]);

        $case = CaseFile::findOrFail($request->case_file_id);

        // Create scrutiny entry
        $scrutiny = new Scrutiny();
        $scrutiny->fill($request->only([
            'case_file_id',
            'filing_number',
            'objection_status',
            'scrutiny_status',
            'scrutiny_date',
        ]));
        $scrutiny->user_id = $user->id;
        $scrutiny->level = 1;
        $scrutiny->other_objection = $request->input('other_objection');
        $scrutiny->remarks_registry = $request->input('remarks_registry');
        $scrutiny->save();

        // ✅ Don't update case_status here anymore
        // if ($request->scrutiny_status === 'Rejected') {
        //     $case->case_status = 'Rejected';
        //     $case->save();
        // } elseif ($request->scrutiny_status === 'Forwarded' && $request->objection_status === 'defect_free') {
        //     $case->case_status = 'Completed';
        //     $case->save();
        // }

        // ✅ Only save if you made other changes (optional now)
        // $case->save();

        // Handle objections
        if ($request->objection_status === 'defect' && is_array($request->responses)) {
            foreach ($request->responses as $code => $response) {
                if (strtoupper($response) === 'NO') {
                    Objection::updateOrCreate(
                        [
                            'case_file_id' => $case->id,
                            'filing_number' => $request->filing_number,
                            'objection_code' => $code,
                        ],
                        [
                            'status' => 'Pending',
                            'remarks' => $request->remarks_checklist[$code] ?? null,
                            'user_id' => $user->id,
                        ]
                    );
                } else {
                    Objection::where([
                        ['case_file_id', $case->id],
                        ['filing_number', $request->filing_number],
                        ['objection_code', $code]
                    ])->delete();
                }
            }
        } else {
            Objection::where('case_file_id', $case->id)
                ->where('filing_number', $request->filing_number)
                ->delete();
        }

        return redirect()->route('scrutiny.index')->with('success', 'Scrutiny submitted successfully.');
    }


    public function show($caseFileId)
    {
        $case = CaseFile::with(['scrutinies' => function ($q) {
            $q->latest('created_at');
        }])->findOrFail($caseFileId);

        return view('scrutiny.show-case', compact('case'));
    }

}
