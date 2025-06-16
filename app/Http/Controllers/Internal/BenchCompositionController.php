<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BenchComposition;
use App\Models\Court;
use App\Models\JudgeMaster;
use App\Models\BenchType;

class BenchCompositionController extends Controller
{
    public function index()
    {
        $benchCompositions = BenchComposition::with(['court', 'judge', 'benchType'])->get();
        return view('admin.internal.bench_composition.index', compact('benchCompositions'));
    }

    public function create()
    {
        $courts = Court::all();
        $judges = JudgeMaster::all();
        $benchTypes = BenchType::all();
        return view('admin.internal.bench_composition.create', compact('courts', 'judges', 'benchTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'court_no' => 'required|exists:courts,id',
            'judge_id' => 'required|exists:judge_master,id',
            'bench_type' => 'nullable|exists:bench_types,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'display' => 'required|boolean',
        ]);

        BenchComposition::create($validated);

        return redirect()->route('bench-composition.index')->with('success', 'Bench composition added successfully.');
    }

    public function edit($id)
    {
        $benchComposition = BenchComposition::findOrFail($id);
        $courts = Court::all();
        $judges = JudgeMaster::all();
        $benchTypes = BenchType::all();

        return view('admin.internal.bench_composition.edit', compact('benchComposition', 'courts', 'judges', 'benchTypes'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'court_no' => 'required|exists:courts,id',
            'judge_id' => 'required|exists:judge_master,id',
            'bench_type' => 'nullable|exists:bench_types,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'display' => 'required|boolean',
        ]);

        $bench = BenchComposition::findOrFail($id);
        $bench->update($validated);

        return redirect()->route('bench-composition.index')->with('success', 'Bench composition updated successfully.');
    }

    public function destroy($id)
    {
        $bench = BenchComposition::findOrFail($id);
        $bench->delete();

        return redirect()->route('bench-composition.index')->with('success', 'Bench composition deleted.');
    }
}
