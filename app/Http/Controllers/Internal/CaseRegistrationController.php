<?php

namespace App\Http\Controllers\Internal;

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
        $date = now()->toDateString();

        // Get the highest case_reg_no for the current year (excluding current case)
        $lastNumber = CaseFile::where('case_reg_year', $year)
            ->where('filing_number', '!=', $request->filing_number)
            ->max('case_reg_no');

        $caseNumber = $lastNumber ? $lastNumber + 1 : 1;

        // Get the case that is Forwarded from scrutiny
        $case = CaseFile::where('filing_number', $request->filing_number)
            ->whereHas('latestScrutiny', function ($query) {
                $query->where('scrutiny_status', 'Forwarded');
            })
            ->first();

        // Handle case not found
        if (!$case) {
            return redirect()->route('admin.registration.index')
                ->with('error', 'No eligible case found or scrutiny not forwarded.');
        }

        // Register the case if not already registered
        if (is_null($case->case_reg_no)) {
            $case->update([
                'case_reg_no' => $caseNumber,
                'case_reg_year' => $year,
                'date_of_registration' => $date,
                'case_status' => 'registered', // optional but logical
            ]);
        }

        return redirect()->route('admin.registration.index')
            ->with('success', 'Case registered with number: ' . $case->case_type . '/' . $caseNumber . '/' . $year);
    }

}
