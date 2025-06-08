<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
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
        $request->validate([
            'case_file_id' => 'required|exists:case_files,id',
            'filing_number' => 'required|unique:scrutiny,filing_number',
            'objection_status' => 'required|in:defect,defect_free',
            'scrutiny_status' => 'required|in:Pending,Forwarded,Rejected,Completed',
            'scrutiny_date' => 'required|date',
        ]);

        $scrutiny = Scrutiny::create($request->all());

        // Update case status based on objection_status
        $case = CaseFile::find($request->case_file_id);
        if ($request->objection_status === 'defect_free') {
            $case->case_status = 'pending'; // Eligible for registration
        } else {
            $case->case_status = 'defect'; // Needs correction
        }
        $case->save();

        return redirect()->route('scrutiny.index')->with('success', 'Scrutiny record added successfully');
    }

    // public function show($caseFileId)
    // {
    //     $case = CaseFile::findOrFail($caseFileId);

    //     // eager-load anything else you need, e.g. ->with('documents')
    //     return view('scrutiny.view_case', compact('case'));
    // }
}
