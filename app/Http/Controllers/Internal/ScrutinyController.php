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
        return view('scrutiny.scrutinize-case-form', compact('case'));
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
}
