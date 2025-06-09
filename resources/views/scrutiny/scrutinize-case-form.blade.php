@php
    $userLevel = auth()->user()->level ?? 1; // Default to 1 if not defined
@endphp

<x-layout title="Scrutinize Case Form | Admin">
    @include('partials.header')

    <main 
        class="grow bg-gray-100 bg-cover bg-center"
        style="background-image: url('{{ asset('images/gavel.jpg') }}')"
    >
        <x-admin.container header="Scrutiny">

            <!-- General Case Information -->
            <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">General Case Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div><span class="font-medium">Diary No.:</span> {{ $case->diary_no }}</div>
                    <div><span class="font-medium">Filing Date:</span> {{ \Carbon\Carbon::parse($case->filing_date)->format('d M Y') }}</div>
                    <div><span class="font-medium">Case Type:</span> {{ $case->case_type }}</div>
                    <div><span class="font-medium">Subject:</span> {{ $case->subject }}</div>
                </div>
            </section>

            <!-- Checklist Form -->
            <form action="{{ route('scrutiny.store') }}" method="POST">
                @csrf
                <input type="hidden" name="case_file_id" value="{{ $case->id }}">
                <input type="hidden" name="filing_number" value="{{ $case->filing_number }}">
                <input type="hidden" name="level" value="{{ $userLevel }}">

                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Checklist</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border border-gray-200 text-sm text-gray-800">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3 border text-left">Defect No.</th>
                                    <th class="px-4 py-3 border text-left">Checklist</th>
                                    <th class="px-4 py-3 border text-center">Option</th>
                                    <th class="px-4 py-3 border text-left">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checklists as $item)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-2 border text-center">{{ $item[0] }}</td>
                                        <td class="px-4 py-2 border">{{ $item[1] }}</td>
                                        <td class="px-4 py-2 border text-center">
                                            <select name="responses[{{ $item[0] }}]" class="form-select w-full rounded-md border-gray-300 shadow-sm">
                                                <option value="YES">YES</option>
                                                <option value="NO">NO</option>
                                                <option value="NA">NA</option>
                                            </select>
                                        </td>
                                        <td class="px-4 py-2 border">
                                            <input type="text" name="remarks_checklist[{{ $item[0] }}]" placeholder="Remarks" class="form-input w-full rounded-md border-gray-300 shadow-sm">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Additional Fields Section -->
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Additional Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Scrutiny Date -->
                        <div>
                            <label for="scrutiny_date" class="block text-sm font-medium text-gray-700 mb-1">Scrutiny Date</label>
                            <input 
                                type="date" 
                                id="scrutiny_date" 
                                name="scrutiny_date" 
                                value="{{ old('scrutiny_date', date('Y-m-d')) }}"
                                class="form-input w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >
                        </div>

                        <!-- Objection Status -->
                        <div>
                            <label for="objection_status" class="block text-sm font-medium text-gray-700 mb-1">Objection Status</label>
                            <select 
                                id="objection_status" 
                                name="objection_status" 
                                class="form-select w-full rounded-md border-gray-300 shadow-sm"
                                required
                            >
                                <option value="">Select</option>
                                <option value="defect_free" {{ old('objection_status') == 'defect_free' ? 'selected' : '' }}>Defect Free</option>
                                <option value="defect" {{ old('objection_status') == 'defect' ? 'selected' : '' }}>Defect</option>
                            </select>
                        </div>
                    </div>

                    <!-- Remarks Based on User Level -->
                    <div class="mt-6">
                        @if($userLevel == 1)
                            <label class="block text-sm font-medium text-gray-700 mb-1">Registry Reviewer Remarks</label>
                            <textarea name="remarks_registry" class="form-textarea w-full rounded-md border-gray-300 shadow-sm" rows="4">{{ old('remarks_registry') }}</textarea>
                        @elseif($userLevel == 2)
                            <label class="block text-sm font-medium text-gray-700 mb-1">Section Officer Remarks</label>
                            <textarea name="remarks_section_officer" class="form-textarea w-full rounded-md border-gray-300 shadow-sm" rows="4">{{ old('remarks_section_officer') }}</textarea>
                        @elseif($userLevel == 3)
                            <label class="block text-sm font-medium text-gray-700 mb-1">Department Head Remarks</label>
                            <textarea name="remarks_dept_head" class="form-textarea w-full rounded-md border-gray-300 shadow-sm" rows="4">{{ old('remarks_dept_head') }}</textarea>
                        @endif
                    </div>

                    <!-- Scrutiny Status -->
                    <div class="mt-6">
                        <label for="scrutiny_status" class="block text-sm font-medium text-gray-700 mb-1">Scrutiny Status</label>
                        <select 
                            id="scrutiny_status" 
                            name="scrutiny_status" 
                            class="form-select w-full rounded-md border-gray-300 shadow-sm"
                            required
                        >
                            <option value="">Select Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Forwarded">Forwarded</option>
                            <option value="Rejected">Rejected</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </section>

                <!-- Submit Button -->
                <div class="flex justify-end mb-8">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition duration-200">
                        Submit Scrutiny
                    </button>
                </div>
            </form>

        </x-admin.container>
    </main>

    @include('partials.footer-alt')
</x-layout>
