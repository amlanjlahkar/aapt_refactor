<?php

namespace App\Http\Controllers;

use App\Models\Efiling\CaseFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserDashboardController extends Controller {
    public function index(): View {
        $case = [
            'draft_count' => CaseFile::where('status', 'Draft')->count(),
            'pending_count' => CaseFile::where('status', 'Pending')->count(),
            'defective_count' => CaseFile::where('status', 'Defective')->count(),
            'today_count' => CaseFile::whereDate('updated_at', now()->toDateString())
                ->where('step', '5')
                ->count(),
        ];

        return view('user.dashboard', compact('case'));
    }

    // Drafts {{{1
    public function indexDraftCases(): View {
        $cases = CaseFile::where('status', 'Draft')->orderBy('created_at', 'desc')->paginate(10);

        return view('user.case-index.drafts', compact('cases'));
    }

    public function continueDraftCase($case_file_id): RedirectResponse {
        $case_file = CaseFile::find($case_file_id);

        return to_route("user.efiling.register.step{$case_file->step}.create",
            [
                'step' => $case_file->step,
                'case_file_id' => $case_file->id,
            ]);
    }

    // 1}}}
    // Pending {{{1
    public function indexPendingCases(): View {
        $cases = CaseFile::where('status', 'Pending')->orderBy('created_at', 'desc')->paginate(10);

        return view('user.case-index.pendings', compact('cases'));
    }
    // 1}}}
}
