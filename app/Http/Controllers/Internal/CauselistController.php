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

            CaseAllocation::whereIn('id', $caseAllocations->pluck('id'))
                ->update([
                    'status' => CaseAllocation::STATUS_PREPARED,
                    'updated_at' => now()
                ]);

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
            
            $caseAllocations = $this->getCaseAllocationsByGroup($id);
            
            if ($caseAllocations->isEmpty()) {
                return back()->with('error', 'No cases found for this causelist.');
            }

            if ($caseAllocations->first()->status !== CaseAllocation::STATUS_PREPARED) {
                return back()->with('error', 'Causelist must be prepared before publishing.');
            }

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
            
            if (!$causelist->published_at && $causelist->status !== 'prepared') {
                return back()->with('error', 'This causelist is not prepared or published yet.');
            }

            $cases = $this->getCaseAllocationsByGroup($id);
            
            return view('admin.internal.causelist.view', compact('causelist', 'cases'));
            
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load causelist: ' . $e->getMessage());
        }
    }

    public function unpublish($id)
    {
        try {
            DB::beginTransaction();
            
            $caseAllocations = $this->getCaseAllocationsByGroup($id);
            
            if ($caseAllocations->isEmpty()) {
                return back()->with('error', 'No cases found for this causelist.');
            }

            CaseAllocation::whereIn('id', $caseAllocations->pluck('id'))
                ->update([
                    'status' => CaseAllocation::STATUS_PREPARED,
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

    public function downloadPDF($id)
    {
        try {
            $representative = CaseAllocation::findOrFail($id);
            $pdf = $this->generateCauseListPDF($representative);
            
            $filename = $this->generateCauseListFilename(
                Carbon::parse($representative->causelist_date),
                $representative->bench_id
            );
            
            return $pdf->download($filename);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    private function getCauseListGroups()
    {
        return CaseAllocation::with(['bench.judge'])
            ->select([
                'causelist_date', 
                'causelist_type', 
                'bench_id',
                DB::raw('MIN(id) as id'),
                DB::raw('MAX(published_at) as published_at'),
                DB::raw('MAX(status) as status'),
                DB::raw('COUNT(*) as total_cases'),
                DB::raw("MAX(CASE WHEN status = '".CaseAllocation::STATUS_PUBLISHED."' THEN 1 ELSE 0 END) as is_published"),
                DB::raw("MAX(CASE WHEN status = '".CaseAllocation::STATUS_PREPARED."' THEN 1 ELSE 0 END) as is_prepared")
            ])
            ->groupBy(['causelist_date', 'causelist_type', 'bench_id'])
            ->orderByDesc('causelist_date')
            ->orderBy('bench_id')
            ->get()
            ->map(function ($item) {
                $representative = CaseAllocation::where('causelist_date', $item->causelist_date)
                    ->where('causelist_type', $item->causelist_type)
                    ->where('bench_id', $item->bench_id)
                    ->first();
                
                $item->id = $representative ? $representative->id : $item->id;
                $item->is_published = (bool) $item->is_published;
                $item->is_prepared = (bool) $item->is_prepared;
                return $item;
            });
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