<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Models\CaseAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CauseListController extends Controller
{
    public function index()
    {
        try {
            $causeListGroups = $this->getCauseListGroups();
            return view('admin.internal.causelist.manage_cause_lists', compact('causeListGroups'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load causelists: ' . $e->getMessage());
        }
    }

    public function prepare($id)
    {
        try {
            DB::beginTransaction();
            
            $representative = CaseAllocation::findOrFail($id);
            $caseAllocations = $this->getCaseAllocationsByGroup($id);
            
            if ($caseAllocations->isEmpty()) {
                return back()->with('error', 'No cases found for this causelist.');
            }

            // Check if status is draft
            if ($representative->status !== CaseAllocation::STATUS_DRAFT) {
                return back()->with('error', 'Only draft causelists can be prepared.');
            }

            // Update status to prepared
            CaseAllocation::whereIn('id', $caseAllocations->pluck('id'))
                ->update([
                    'status' => CaseAllocation::STATUS_PREPARED,
                    'updated_at' => now()
                ]);

            // Generate PDF
            $pdf = $this->generateCauseListPDF($representative);
            $filename = $this->generateCauseListFilename(
                Carbon::parse($representative->causelist_date),
                $representative->bench_id
            );
            Storage::put('public/causelists/'.$filename, $pdf->output());

            DB::commit();
            
            return back()->with('success', 'Causelist prepared successfully. PDF generated.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to prepare causelist: ' . $e->getMessage());
        }
    }

    public function publish($id)
    {
        try {
            DB::beginTransaction();
            
            $representative = CaseAllocation::findOrFail($id);
            $caseAllocations = $this->getCaseAllocationsByGroup($id);
            
            if ($caseAllocations->isEmpty()) {
                return back()->with('error', 'No cases found for this causelist.');
            }

            if ($representative->status !== CaseAllocation::STATUS_PREPARED) {
                return back()->with('error', 'Causelist must be prepared before publishing.');
            }

            // Update status to published
            CaseAllocation::whereIn('id', $caseAllocations->pluck('id'))
                ->update([
                    'status' => CaseAllocation::STATUS_PUBLISHED,
                    'published_by' => auth('admin')->id(),
                    'published_at' => now(),
                    'updated_at' => now()
                ]);

            DB::commit();
            
            return back()->with('success', 'Causelist published successfully.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to publish causelist: ' . $e->getMessage());
        }
    }

    public function view($id)
    {
        try {
            $causelist = CaseAllocation::with(['bench.judge', 'caseFile', 'purpose'])
                                     ->findOrFail($id);
            
            $cases = $this->getCaseAllocationsByGroup($id);
            
            return view('admin.internal.causelist.view_causelist', compact('causelist', 'cases'));
            
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load causelist: ' . $e->getMessage());
        }
    }

    public function unpublish($id)
    {
        try {
            DB::beginTransaction();
            
            $representative = CaseAllocation::findOrFail($id);
            $caseAllocations = $this->getCaseAllocationsByGroup($id);
            
            if ($caseAllocations->isEmpty()) {
                return back()->with('error', 'No cases found for this causelist.');
            }

            if ($representative->status !== CaseAllocation::STATUS_PUBLISHED) {
                return back()->with('error', 'Only published causelists can be unpublished.');
            }

            // Revert status back to draft
            CaseAllocation::whereIn('id', $caseAllocations->pluck('id'))
                ->update([
                    'status' => CaseAllocation::STATUS_DRAFT,
                    'published_by' => null,
                    'published_at' => null,
                    'updated_at' => now()
                ]);

            DB::commit();
            
            return back()->with('success', 'Causelist unpublished successfully.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to unpublish causelist: ' . $e->getMessage());
        }
    }

    public function downloadPdf($id)
    {
        try {
            // Get the representative case allocation record
            $representative = CaseAllocation::findOrFail($id);
            
            // Get all case allocations for this group (same date, type, bench)
            $cases = $this->getCaseAllocationsByGroup($id);

            // Check if causelist is prepared or published
            if (!in_array($representative->status, [CaseAllocation::STATUS_PREPARED, CaseAllocation::STATUS_PUBLISHED])) {
                return redirect()->back()->with('error', 'PDF can only be generated for Prepared or Published causelists.');
            }

            $data = [
                'causelist' => $representative, // Using representative as causelist
                'cases' => $cases,
                'generated_at' => now()->format('d-m-Y H:i:s')
            ];

            $pdf = PDF::loadView('admin.internal.causelist.pdf_causelist', $data);
            
            $filename = 'causelist_' . ($representative->bench->court_no ?? 'unknown') . '_' . 
                    \Carbon\Carbon::parse($representative->causelist_date)->format('d-m-Y') . '.pdf';
            
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }

    private function getCauseListGroups()
    {
        // Get all case allocations grouped by causelist_date, causelist_type, and bench_id
        $groups = CaseAllocation::with(['bench.judge'])
            ->select([
                'causelist_date', 
                'causelist_type', 
                'bench_id',
                DB::raw('MIN(id) as representative_id'),
                DB::raw('COUNT(*) as total_cases')
            ])
            ->groupBy(['causelist_date', 'causelist_type', 'bench_id'])
            ->orderByDesc('causelist_date')
            ->orderBy('bench_id')
            ->get();

        // For each group, get the representative record with full details including status
        return $groups->map(function ($group) {
            $representative = CaseAllocation::with(['bench.judge'])
                ->where('causelist_date', $group->causelist_date)
                ->where('causelist_type', $group->causelist_type)
                ->where('bench_id', $group->bench_id)
                ->first();

            if ($representative) {
                $representative->total_cases = $group->total_cases;
                return $representative;
            }
            return null;
        })->filter();
    }

    private function getCaseAllocationsByGroup($representativeId)
    {
        $representative = CaseAllocation::findOrFail($representativeId);
        
        return CaseAllocation::with(['bench.judge', 'caseFile', 'purpose'])
            ->where('causelist_date', $representative->causelist_date)
            ->where('causelist_type', $representative->causelist_type)
            ->where('bench_id', $representative->bench_id)
            ->orderBy('serial_no')
            ->get();
    }

    private function generateCauseListPDF($representative)
    {
        $cases = $this->getCaseAllocationsByGroup($representative->id);
        $date = Carbon::parse($representative->causelist_date);
        
        $data = [
            'cases' => $cases,
            'date' => $date,
            'judge' => $representative->bench->judge ?? null,
            'courtNo' => $representative->bench->court_no ?? 1,
            'time' => '10:30 AM'
        ];

        return PDF::loadView('admin.internal.causelist.pdf_causelist', $data);
    }

    private function generateCauseListFilename($date, $benchId)
    {
        return 'causelist_' . $date->format('d_m_Y') . '_' . str_pad($benchId, 4, '0', STR_PAD_LEFT) . '.pdf';
    }
}