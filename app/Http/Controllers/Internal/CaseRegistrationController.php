<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Efiling\CaseFile;

class CaseRegistrationController extends Controller
{
    public function index()
    {
        // Show only scrutinized cases where scrutiny_status is Forwarded
        $cases = CaseFile::whereHas('latestScrutiny', function ($query) {
            $query->where('scrutiny_status', 'Forwarded');
        })->get();

        return view('caseregistration.case-list-registration', compact('cases'));
    }

    public function generateCaseNo(Request $request)
    {
        $year = now()->year;
        $date = date('Y-m-d');

        $lastNumber = CaseFile::where('case_reg_year', $year)
            ->where('filing_no', '!=', $request->filing_number)
            ->max('case_reg_no');

        $caseNumber = $lastNumber ? $lastNumber + 1 : 1;

        $case = CaseFile::where('filing_no', $request->filing_number)
            ->whereHas('latestScrutiny', function ($query) {
                $query->where('scrutiny_status', 'Forwarded');
            })
            ->first();

        if ($case && is_null($case->case_reg_no)) {
            $case->update([
                'case_reg_no' => $caseNumber,
                'case_reg_year' => $year,
                'date_of_registration' => $date,
            ]);
        }

        return redirect()->route('admin.registration.index')
            ->with('success', 'Case registered with number: ' . $case->case_type . '/' . $caseNumber . '/' . $year);
    }
}
