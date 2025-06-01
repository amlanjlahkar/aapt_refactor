@extends('components.layout')

@section('content')
<div class="container">
    <h2>Scrutiny Form for Filing Number: {{ $case->filing_number }}</h2>

    <form action="{{ route('scrutiny.store') }}" method="POST">
        @csrf

        <input type="hidden" name="case_file_id" value="{{ $case->id }}">

        <div class="mb-3">
            <label>Filing Number</label>
            <input type="text" name="filing_number" value="{{ $case->filing_number }}" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label>Objection Status</label>
            <select name="objection_status" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="defect">Defect</option>
                <option value="defect_free">Defect Free</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Other Objection Remarks</label>
            <textarea name="other_objection" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label>Scrutiny Status</label>
            <select name="scrutiny_status" class="form-control" required>
                <option value="Completed">Completed</option>
                <option value="Pending">Pending</option>
                <option value="Rejected">Rejected</option>
                <option value="Forwarded">Forwarded</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Scrutiny Date</label>
            <input type="date" name="scrutiny_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>User ID (Scrutinizer)</label>
            <input type="number" name="user_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Level</label>
            <select name="level" class="form-control">
                <option value="1">Registry Reviewer</option>
                <option value="2">Section Officer</option>
                <option value="3">Department Head</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Remarks (Registry)</label>
            <textarea name="remarks_registry" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit Scrutiny</button>
    </form>
</div>
@endsection
