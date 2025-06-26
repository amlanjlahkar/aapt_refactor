<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Models\BenchComposition;
use App\Models\CaseAllocation;
use App\Models\Efiling\caseFile;
use App\Models\CaseProceeding;
use App\Models\Efiling\Petitioner;
use App\Models\Efiling\Respondent;
use App\Models\Internal\Purpose\PurposeMaster;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CaseProceedingController extends Controller
{
    public function index()
    {
        // Fetch benches with judge names
        $benches = BenchComposition::with('judge')->get();
        
        // Fetch published case allocations with related data
        $publishedAllocations = CaseAllocation::where('status', 'Published')
            ->with(['caseFile', 'purpose', 'bench'])
            ->get();
        
        // Get case files with computed party names and purpose
        $caseFiles = $this->getCaseFilesWithDetails($publishedAllocations);

        // Fetch action types for today's action dropdown
        $actionTypes = DB::table('action_types')->orderBy('name')->get();

        // Fetch next purposes for the next purpose dropdown
        $nextPurposes = PurposeMaster::orderBy('purpose_name')->get();

        return view('admin.internal.proceedings.case_proceeding_search', compact('benches', 'caseFiles', 'actionTypes', 'nextPurposes'));

    }

   public function search(Request $request)
    {
        // Validate the search request
        $request->validate([
            'bench_id' => 'nullable|exists:bench_compositions,id',
            'case_type' => 'nullable|string',
            'case_reg_no' => 'nullable|string',
            'case_reg_year' => 'nullable|integer',
        ]);

        // Get benches and case files for the view (needed for the search form)
        $benches = BenchComposition::with('judge')->get();
        $publishedAllocations = CaseAllocation::where('status', 'Published')
            ->with(['caseFile', 'purpose', 'bench'])
            ->get();
        $caseFiles = $this->getCaseFilesWithDetails($publishedAllocations);

        $case = null;
        $previousProceedings = collect();

        // Search for the case if search parameters are provided
        if ($request->filled(['case_reg_no', 'case_reg_year'])) {
            $query = CaseAllocation::where('status', 'Published')
                ->with(['caseFile', 'purpose', 'bench']);

            // IMPORTANT: Filter by bench_id if provided
            if ($request->filled('bench_id')) {
                $query->where('bench_id', $request->bench_id);
            }

            // Apply search filters through the related caseFile
            $query->whereHas('caseFile', function($q) use ($request) {
                if ($request->filled('case_reg_no')) {
                    $q->where('case_reg_no', $request->case_reg_no);
                }

                if ($request->filled('case_reg_year')) {
                    $q->where('case_reg_year', $request->case_reg_year);
                }

                if ($request->filled('case_type')) {
                    $q->where('case_type', $request->case_type);
                }
            });

            // Get the case allocation
            $caseAllocation = $query->first();

            // If case allocation is found, get the case details and previous proceedings
            if ($caseAllocation && $caseAllocation->caseFile) {
                $case = $caseAllocation->caseFile;
                
                // Get party names
                $case->party_name = $this->getPartyName($case->id);
                
                // Get purpose from allocation
                $case->purpose = $caseAllocation->purpose 
                    ? $caseAllocation->purpose->purpose_name 
                    : 'N/A';
                
                // Get court_no from bench through case allocation
                $case->court_no = $caseAllocation->bench 
                    ? $caseAllocation->bench->court_no 
                    : 'N/A';

                // Get previous proceedings
                $previousProceedings = CaseProceeding::where('case_file_id', $case->id)
                    ->orderBy('listing_date', 'desc')
                    ->get();
            }
        }

        $actionTypes = DB::table('action_types')->orderBy('name')->get();

        $nextPurposes = PurposeMaster::orderBy('purpose_name')->get();

        return view('admin.internal.proceedings.case_proceeding_search', compact(
            'benches', 
            'caseFiles', 
            'case', 
            'previousProceedings',
            'actionTypes',
            'nextPurposes'
        ));
    }

    public function store(Request $request)
{
    // Validate the proceeding data (removed disposal_date from validation)
    $validated = $request->validate([
        'case_file_id' => 'required|exists:case_files,id',
        'todays_status' => 'required|string',
        'todays_action' => 'required|string',
        'next_purpose' => 'nullable|string',
        'next_criteria' => 'nullable|string',
        'next_date' => 'nullable|date',
        'remarks' => 'nullable|string|max:1000',
        // court_no removed from validation
    ]);

    try {
        $case = CaseFile::findOrFail($validated['case_file_id']);
        
        // Get court_no from allocation if needed elsewhere
        $caseAllocation = CaseAllocation::where('case_file_id', $case->id)
            ->with('bench')
            ->first();
            
        $courtNo = $caseAllocation->bench->court_no ?? null;

        $proceeding = CaseProceeding::create([
            'case_file_id' => $validated['case_file_id'],
            'listing_date' => Carbon::now()->format('Y-m-d'),
            'purpose' => $validated['todays_action'],
            'todays_status' => $validated['todays_status'],
            'todays_action' => $validated['todays_action'],
            'next_date' => $validated['next_date'],
            'next_purpose' => $validated['next_purpose'],
            'next_criteria' => $validated['next_criteria'],
            'remarks' => $validated['remarks'],
            'created_by' => auth()->id(),
        ]);

        // Update case file dates
        if ($validated['next_date']) {
            $case->next_hearing_date = $validated['next_date'];
            $case->last_hearing_date = Carbon::now()->format('Y-m-d');
        }

        // If case is disposed, set the disposal date in case_files
        if ($validated['todays_status'] === 'Disposed' && $request->filled('disposal_date')) {
            $case->date_of_disposal = $request->disposal_date;
        }

        $case->save();

        return redirect()->back()->with('success', 'Case proceeding has been recorded successfully.');

    } catch (\Exception $e) {
        \Log::error('Case Proceeding Error: '.$e->getMessage());
        return redirect()->back()
            ->with('error', 'Failed to record case proceeding. Error: '.$e->getMessage())
            ->withInput();
    }
}


    public function show($id)
    {
        // Get specific proceeding details
        $proceeding = CaseProceeding::with('case')->findOrFail($id);
        
        return view('admin.internal.proceedings.proceeding_details', compact('proceeding'));
    }

    public function history($caseId)
    {
        // Get all proceedings for a specific case
        $case = caseFile::findOrFail($caseId);
        $proceedings = CaseProceeding::where('case_file_id', $caseId)
            ->orderBy('listing_date', 'desc')
            ->paginate(20);

        return view('admin.internal.proceedings.proceeding_history', compact('case', 'proceedings'));
    }

    public function edit($id)
    {
        // Edit proceeding (if needed)
        $proceeding = CaseProceeding::findOrFail($id);
        
        return view('admin.internal.proceedings.edit_proceeding', compact('proceeding'));
    }

    public function update(Request $request, $id)
    {
        // Update proceeding
        $proceeding = CaseProceeding::findOrFail($id);
        
        $validated = $request->validate([
            'todays_status' => 'required|string',
            'todays_action' => 'required|string',
            'next_purpose' => 'nullable|string',
            'next_criteria' => 'nullable|string',
            'next_date' => 'nullable|date',
            'court_no' => 'nullable|string',
            'remarks' => 'nullable|string|max:1000',
        ]);

        try {
            $proceeding->update($validated);

            return redirect()->route('admin.case.proceeding.history', $proceeding->case_file_id)
                ->with('success', 'Proceeding updated successfully.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update proceeding. Please try again.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        // Delete proceeding (if needed)
        try {
            $proceeding = CaseProceeding::findOrFail($id);
            $caseId = $proceeding->case_file_id;
            $proceeding->delete();
            
            return redirect()->route('admin.case.proceeding.history', $caseId)
                ->with('success', 'Proceeding deleted successfully.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete proceeding. Please try again.');
        }
    }

    /**
     * Get case files with computed party names and purpose
     */
    private function getCaseFilesWithDetails($publishedAllocations)
    {
        $caseFiles = collect();

        foreach ($publishedAllocations as $allocation) {
            if ($allocation->caseFile) {
                $case = $allocation->caseFile;
                
                // Add computed fields to each case file
                $case->party_name = $this->getPartyName($case->id);
                
                // Get purpose from allocation
                $case->purpose = $allocation->purpose 
                    ? $allocation->purpose->purpose_name 
                    : 'N/A';
                
                // Get court_no from bench through allocation
                $case->court_no = $allocation->bench 
                    ? $allocation->bench->court_no 
                    : 'N/A';
                
                $caseFiles->push($case);
            }
        }

        return $caseFiles->unique('id');
    }

    /**
     * Get formatted party name for a case
     */
    private function getPartyName($caseFileId)
    {
        // Get petitioner name
        $petitioner = Petitioner::where('case_file_id', $caseFileId)->first();
        $petName = $petitioner ? $petitioner->pet_name : 'Unknown Petitioner';

        // Get respondent name
        $respondent = Respondent::where('case_file_id', $caseFileId)->first();
        $resName = $respondent ? $respondent->res_name : 'Unknown Respondent';

        return $petName . ' vs ' . $resName;
    }
}