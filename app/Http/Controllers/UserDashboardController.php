<?php

namespace App\Http\Controllers;

use App\Models\Efiling\CaseFile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller {
    protected $userCaseFiles;

    public function __construct() {
        $this->userCaseFiles = CaseFile::where('user_id', Auth::id());
    }

    public function getCaseCounts(): View {
        $case = [
            'draft_count' => $this->userCaseFiles->where('status', 'Draft')->count(),
            'pending_count' => $this->userCaseFiles->where('status', 'Pending')->count(),
            'defective_count' => $this->userCaseFiles->where('status', 'Defective')->count(),
            'today_count' => $this->userCaseFiles->whereDate('updated_at', now()->toDateString())
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
        $count = $this->userCaseFiles->where('status', $case_status)->count();

        return view('user.case-index', compact('count', 'case_status'));
    }

    public function checkCaseStatus(): View {
        return view('user.check-case-status');
    }

    /**
     * @param  string  $case_file_id
     */
    public function continueDraftCase($case_file_id): RedirectResponse {
        $case_file = $this->userCaseFiles->find($case_file_id);

        return to_route("user.efiling.register.step{$case_file->step}.create",
            [
                'step' => $case_file->step,
                'case_file_id' => $case_file->id,
            ]);
    }
}
