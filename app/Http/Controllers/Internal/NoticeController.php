<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;
use App\Models\Efiling\CaseFile;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;


class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::with(['case.petitioners', 'case.respondents'])->latest()->get();
        $cases = CaseFile::latest()->get();

        return view('admin.internal.notices.list_all_notices', compact('notices', 'cases'));
    }



    public function create(Request $request)
    {
        $cases = CaseFile::select('id', 'filing_number')->get();
        $selectedCaseId = $request->get('case_id'); // Get from URL
        return view('admin.internal.notices.create_new_notice', compact('cases', 'selectedCaseId'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'case_id' => 'required|exists:case_files,id',
            'notice_type' => 'required|in:1,2,3,4,5,6',
            'hearing_date' => 'required|date',
        ]);

        Notice::create($request->only('case_id', 'notice_type', 'hearing_date'));

        return redirect()->route('admin.internal.notices.index')->with('success', 'Notice created successfully.');
    }

    public function edit($id)
    {
        $notice = Notice::findOrFail($id);
        $cases = CaseFile::select('id', 'filing_number')->get();
        return view('admin.internal.notices.edit_existing_notice', compact('notice', 'cases'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'case_id' => 'required|exists:case_files,id',
            'notice_type' => 'required|in:1,2,3,4,5,6',
            'hearing_date' => 'required|date',
        ]);

        $notice = Notice::findOrFail($id);
        $notice->update($request->only('case_id', 'notice_type', 'hearing_date'));

        return redirect()->route('admin.internal.notices.index')->with('success', 'Notice updated successfully.');
    }

    public function destroy($id)
    {
        Notice::destroy($id);
        return back()->with('success', 'Notice deleted.');
    }

    public function show($id)
    {
        $notice = Notice::with('case')->findOrFail($id);
        return view('admin.internal.notices.show_notice', compact('notice'));
    }

   public function downloadPdf($id)
    {
        $notice = Notice::with(['case.petitioners', 'case.respondents'])->findOrFail($id);

        $pdf = DomPDF::loadView('admin.internal.notices.show_notice', [
            'notice' => $notice,
            'isPdf' => true,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('notice_' . $notice->id . '.pdf');
    }

}
