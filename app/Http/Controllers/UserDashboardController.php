<?php

namespace App\Http\Controllers;

use App\Models\Efiling\CaseFile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserDashboardController extends Controller {
    public function getCaseCounts(): View {
        $case = [
            'draft_count' => CaseFile::where('status', 'Draft')->count(),
            'pending_count' => CaseFile::where('status', 'Pending')->count(),
            'defective_count' => CaseFile::where('status', 'Defective')->count(),
            'today_count' => CaseFile::whereDate('updated_at', now()->toDateString())
                ->where('step', '5')
                ->where('status', 'Pending')
                ->count(),
        ];

        return view('user.dashboard', compact('case'));
    }

    /**
     * @param  string  $case_status
     */
    public function indexCases($case_status): View {
        $count = CaseFile::where('status', $case_status)->count();

        return view('user.case-index', compact('count', 'case_status'));
    }

    public function checkCaseStatus(): View {
        return view('user.check-case-status');
    }

    /**
     * @param  string  $case_file_id
     */
    public function continueDraftCase($case_file_id): RedirectResponse {
        $case_file = CaseFile::find($case_file_id);

        return to_route("user.efiling.register.step{$case_file->step}.create",
            [
                'step' => $case_file->step,
                'case_file_id' => $case_file->id,
            ]);
    }
}
