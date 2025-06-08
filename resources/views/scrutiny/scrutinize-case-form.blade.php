<x-layout title="Scrutinize Case Form | Admin">
    @include('partials.header')

    <main 
        class="grow bg-cover bg-center"
        style="background-image: url('{{ asset('images/gavel.jpg') }}')">
        
        <x-admin.container header="Scrutiny">

            <!-- General Case Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">General Case Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div>
                        <span class="font-medium">Diary No.:</span> {{ $case->diary_no }}
                    </div>
                    <div>
                        <span class="font-medium">Filing Date:</span> {{ \Carbon\Carbon::parse($case->filing_date)->format('d M Y') }}
                    </div>
                    <div>
                        <span class="font-medium">Case Type:</span> {{ $case->case_type }}
                    </div>
                    <div>
                        <span class="font-medium">Subject:</span> {{ $case->subject }}
                    </div>
                </div>
            </div>

            <!-- Checklist Form -->
            <form action="{{ route('scrutiny.store') }}" method="POST">
                @csrf
                <input type="hidden" name="case_id" value="{{ $case->id }}">

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Checklist</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 table-auto text-sm text-gray-700">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-2 border">Defect No.</th>
                                    <th class="px-4 py-2 border">Checklist</th>
                                    <th class="px-4 py-2 border">Select Option</th>
                                    <th class="px-4 py-2 border">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checklists as $item)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-2 border text-center">{{ $item[0] }}</td>
                                        <td class="px-4 py-2 border">{{ $item[1] }}</td>
                                        <td class="px-4 py-2 border">
                                            <select name="responses[{{ $item[0] }}]" class="form-select w-full rounded-md border-gray-300 shadow-sm">
                                                <option value="YES">YES</option>
                                                <option value="NO">NO</option>
                                                <option value="NA">NA</option>
                                            </select>
                                        </td>
                                        <td class="px-4 py-2 border">
                                            <input type="text" name="remarks[{{ $item[0] }}]" placeholder="Remarks" class="form-input w-full rounded-md border-gray-300 shadow-sm">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Additional Fields Section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Additional Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Scrutiny Date -->
                        <div>
                            <label for="scrutiny_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Scrutiny Date
                            </label>
                            <input 
                                type="date" 
                                id="scrutiny_date" 
                                name="scrutiny_date" 
                                value="{{ old('scrutiny_date', date('Y-m-d')) }}"
                                class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                        </div>

                        <!-- Case Under -->
                        <div>
                            <label for="case_under" class="block text-sm font-medium text-gray-700 mb-2">
                                Case Under
                            </label>
                            <select 
                                id="case_under" 
                                name="case_under" 
                                class="form-select w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                                <option value="">Select Status</option>
                                <option value="defect_free" {{ old('case_under') == 'defect_free' ? 'selected' : '' }}>Defect Free</option>
                                <option value="defect" {{ old('case_under') == 'defect' ? 'selected' : '' }}>Defect</option>
                            </select>
                        </div>
                    </div>

                    <!-- Other Objection -->
                    <div class="mt-6">
                        <label for="other_objection" class="block text-sm font-medium text-gray-700 mb-2">
                            Other Objection
                        </label>
                        <textarea 
                            id="other_objection" 
                            name="other_objection" 
                            rows="4" 
                            placeholder="Enter any additional objections or remarks..."
                            class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >{{ old('other_objection') }}</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition duration-200">
                        Submit Scrutiny
                    </button>
                </div>
            </form>

        </x-admin.container>
    </main>

    @include('partials.footer-alt')
</x-layout>
