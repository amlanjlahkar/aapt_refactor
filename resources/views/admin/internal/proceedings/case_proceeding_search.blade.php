<x-layout title="Case Proceeding | Admin">
    @include('partials.header')

    <main class="grow bg-cover bg-center" style="background-image: url('{{ asset('images/gavel.jpg') }}')">
        <x-admin.container header="Case Proceeding">

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="mb-4 rounded bg-green-100 px-4 py-2 text-green-800 shadow">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 rounded bg-red-100 px-4 py-2 text-red-800 shadow">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Back Button --}}
            <div class="mb-5 flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-1.5 rounded border border-gray-300 bg-gray-100 px-4 py-2.5 font-semibold text-gray-600 shadow-sm hover:bg-gray-200">
                    <x-fas-arrow-left class="h-4 w-4 text-gray-600" />
                    <span>Back</span>
                </a>
            </div>
            
            {{-- Main Case Search Form --}}
            <div class="rounded-lg border bg-white p-6 shadow mb-6">
                <form action="{{ route('internal.case_proceeding.search') }}" method="GET" id="searchForm">
                    
                    {{-- Bench Selection --}}
                    <div class="mb-6">
                        <label for="bench_id" class="block text-sm font-medium text-gray-700 mb-2">Bench:</label>
                        <select name="bench_id" id="bench_id" 
                                class="w-full max-w-md rounded border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            <option value=""> Select </option>
                            @foreach ($benches as $bench)
                                <option value="{{ $bench->id }}" {{ request('bench_id') == $bench->id ? 'selected' : '' }}>
                                    Bench {{ $bench->court_no }} - {{ $bench->judge->judge_name ?? 'No Judge Assigned' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Auto Search Case Section --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Case (Auto-Sequential):</label>
                        <div class="flex items-center gap-4">
                            <input type="text" name="case_type" 
                                   class="rounded border border-gray-300 px-3 py-2 text-sm bg-gray-100 cursor-not-allowed"
                                   value="Original Application"
                                   readonly>
                            
                            <input type="number" name="case_reg_no" 
                                   class="w-20 rounded border border-gray-300 px-3 py-2 text-sm bg-gray-100 cursor-not-allowed"
                                   value="{{ old('case_reg_no', request('case_reg_no', session('next_proceeding_case_no', 1))) }}"
                                   readonly>
                            
                            <input type="number" name="case_reg_year" 
                                   class="w-24 rounded border border-gray-300 px-3 py-2 text-sm bg-gray-100 cursor-not-allowed"
                                   value="{{ old('case_reg_year', request('case_reg_year', session('next_proceeding_case_year', date('Y')))) }}"
                                   readonly>
                            
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition font-medium text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Search Case
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Search Results Section --}}
            @if(isset($case) && $case)
                {{-- Section 2: Search Results Table --}}
                <div class="rounded-lg border bg-white p-6 shadow mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Search Result:</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Case No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Party Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Court No</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $case->case_type }}/{{ $case->case_reg_no }}/{{ $case->case_reg_year }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $case->party_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $case->purpose ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $case->court_no ?? 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Section 3: Previous Proceedings (Only show if there are proceedings) --}}
                @if(isset($previousProceedings) && $previousProceedings->count() > 0)
                    <div class="rounded-lg border bg-white p-6 shadow mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Previous Proceedings:</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Listing Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Court No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bench</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next Purpose</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($previousProceedings as $proceeding)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $proceeding->listing_date ? \Carbon\Carbon::parse($proceeding->listing_date)->format('d M Y') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $proceeding->purpose ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $proceeding->court_no ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $proceeding->bench ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $proceeding->next_date ? \Carbon\Carbon::parse($proceeding->next_date)->format('d M Y') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $proceeding->next_purpose ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate" title="{{ $proceeding->remarks }}">
                                                {{ $proceeding->remarks ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                {{-- Section 4: New Proceeding Form --}}
                <div class="rounded-lg border bg-white p-6 shadow">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Proceeding:</h3>
                    
                    <form action="{{ route('internal.case_proceeding.store') }}" method="POST" class="proceeding-form">
                        @csrf
                        <input type="hidden" name="case_file_id" value="{{ $case->id }}">
                        <input type="hidden" name="bench_id" value="{{ request('bench_id') }}">
                        <input type="hidden" name="current_case_no" value="{{ request('case_reg_no') }}">
                        <input type="hidden" name="current_year" value="{{ request('case_reg_year') }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {{-- Column 1 --}}
                            <div class="space-y-4">
                                <div>
                                    <label for="todays_status" class="block text-sm font-medium text-gray-700 mb-2">Today's Status</label>
                                    <select name="todays_status" id="todays_status" class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                                        <option value=""> Select  </option>
                                        <option value="Pending">PENDING</option>
                                        <option value="Disposed">DISPOSED</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="next_criteria" class="block text-sm font-medium text-gray-700 mb-2">Next Criteria</label>
                                    <select name="next_criteria" id="next_criteria" class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                        <option value=""> Select </option>
                                        <option value="Fixed">FIXED</option>
                                        <option value="Not Fixed">NOT FIXED</option>
                                        
                                    </select>
                                </div>
                            </div>

                            <div id="disposal_date_field" class="hidden">
                                <label for="disposal_date" class="block text-sm font-medium text-gray-700 mb-2">Disposal Date</label>
                                <input type="date" name="disposal_date" id="disposal_date" 
                                    class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            </div>

                            
                            {{-- Column 2 --}}
                            <div class="space-y-4">
                                <div>
                                    <label for="todays_action" class="block text-sm font-medium text-gray-700 mb-2">Today's Action</label>
                                    <select name="todays_action" id="todays_action" class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                                        <option value=""> Select </option>
                                        @foreach($actionTypes as $action)
                                            <option value="{{ $action->name }}">{{ $action->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="next_date" class="block text-sm font-medium text-gray-700 mb-2">Next Date</label>
                                    <input type="date" name="next_date" id="next_date" class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                </div>
                            </div>
                            
                            {{-- Column 3 --}}
                            <div class="space-y-4">
                                <div>
                                    <label for="next_purpose" class="block text-sm font-medium text-gray-700 mb-2">Next Purpose</label>
                                    <select name="next_purpose" id="next_purpose" class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                        <option value=""> Select </option>
                                        @foreach($nextPurposes as $purpose)
                                            <option value="{{ $purpose->purpose_name }}">{{ $purpose->purpose_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            </div>
                        </div>

                        {{-- Remarks --}}
                        <div class="mt-6">
                            <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                            <textarea name="remarks" id="remarks" rows="4" class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" 
                                    placeholder="Enter any additional remarks or observations..."></textarea>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="mt-6 flex justify-between">
                            <div class="flex gap-3">
                                <button type="submit" name="action" value="save_only"
                                        class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            @elseif(request()->filled('case_reg_no') || request()->filled('case_type'))
                <div class="rounded-lg border bg-white p-6 shadow">
                    <div class="flex flex-col items-center justify-center rounded-md border border-gray-200 bg-gray-50 py-10 text-center text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-lg font-semibold text-red-600">No Case Found</p>
                        <p class="text-sm">Case {{ request('case_type') }}/{{ request('case_reg_no') }}/{{ request('case_reg_year') }} was not found in the system.</p>
                        <div class="mt-4">
                            <form method="GET" action="{{ route('internal.case_proceeding.search') }}" class="inline">
                                <input type="hidden" name="bench_id" value="{{ request('bench_id') }}">
                                <input type="hidden" name="case_type" value="Original Application">
                                <input type="hidden" name="case_reg_no" value="{{ (int)request('case_reg_no') + 1 }}">
                                <input type="hidden" name="case_reg_year" value="{{ request('case_reg_year') }}">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                    Try Next Case ({{ (int)request('case_reg_no') + 1 }})
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

        </x-admin.container>
    </main>

    @include('partials.footer-alt')

    {{-- Enhanced JavaScript --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const nextCriteriaSelect = document.getElementById('next_criteria');
        const nextDateInput = document.getElementById('next_date');
        const todaysStatusSelect = document.getElementById('todays_status');
        const disposalDateField = document.getElementById('disposal_date_field');
        
        // Get the next hearing related fields (but NOT today's status/action fields)
        const nextPurposeField = document.getElementById('next_purpose').closest('div');
        const nextCriteriaField = nextCriteriaSelect.closest('div');
        const nextDateField = nextDateInput.closest('div');

        // Auto-set Next Date based on criteria
        if (nextCriteriaSelect && nextDateInput) {
            nextCriteriaSelect.addEventListener('change', function() {
                const criteria = this.value;
                const today = new Date();
                let nextDate = new Date(today);
                
                switch(criteria) {
                    case '1 Week':
                        nextDate.setDate(today.getDate() + 7);
                        break;
                    case '2 Weeks':
                        nextDate.setDate(today.getDate() + 14);
                        break;
                    case '1 Month':
                        nextDate.setMonth(today.getMonth() + 1);
                        break;
                    case '2 Months':
                        nextDate.setMonth(today.getMonth() + 2);
                        break;
                    case '3 Months':
                        nextDate.setMonth(today.getMonth() + 3);
                        break;
                    default:
                        return;
                }
                
                nextDateInput.value = nextDate.toISOString().split('T')[0];
            });
        }

        // Show/hide fields based on Today's Status
        if (todaysStatusSelect && disposalDateField) {
            todaysStatusSelect.addEventListener('change', function () {
                if (this.value === 'Disposed') {
                    // Show disposal date field
                    disposalDateField.classList.remove('hidden');
                    
                    // Hide next hearing related fields
                    if (nextPurposeField) nextPurposeField.classList.add('hidden');
                    if (nextCriteriaField) nextCriteriaField.classList.add('hidden');
                    if (nextDateField) nextDateField.classList.add('hidden');
                    
                    // Clear values of hidden fields
                    document.getElementById('next_purpose').value = '';
                    document.getElementById('next_criteria').value = '';
                    document.getElementById('next_date').value = '';
                    
                } else {
                    // Hide disposal date field
                    disposalDateField.classList.add('hidden');
                    document.getElementById('disposal_date').value = '';
                    
                    // Show next hearing related fields
                    if (nextPurposeField) nextPurposeField.classList.remove('hidden');
                    if (nextCriteriaField) nextCriteriaField.classList.remove('hidden');
                    if (nextDateField) nextDateField.classList.remove('hidden');
                }
            });
        }

        // Form submission validation
        const proceedingForm = document.querySelector('.proceeding-form');
        if (proceedingForm) {
            proceedingForm.addEventListener('submit', function(e) {
                const todaysStatus = todaysStatusSelect.value;
                const todaysAction = document.getElementById('todays_action').value;

                if (!todaysStatus) {
                    alert('Please select Today\'s Status');
                    e.preventDefault();
                    return;
                }

                if (!todaysAction) {
                    alert('Please select Today\'s Action');
                    e.preventDefault();
                    return;
                }

                // Validate disposal date if status is disposed
                if (todaysStatus === 'Disposed') {
                    const disposalDate = document.getElementById('disposal_date').value;
                    if (!disposalDate) {
                        alert('Please enter the Disposal Date');
                        e.preventDefault();
                    }
                }
            });
        }
    });
</script>

</x-layout>