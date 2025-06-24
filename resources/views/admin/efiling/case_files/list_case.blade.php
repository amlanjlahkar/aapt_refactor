<x-layout title="Allocate Cases to Causelist | Admin">
    @include('partials.header')

    <main class="grow bg-cover bg-center" style="background-image: url('{{ asset('images/gavel.jpg') }}')">
        <x-admin.container header="Allocate Case to Causelist">

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

            {{-- Main Allocation Form --}}
            <div class="rounded-lg border bg-white p-6 shadow">
                <form method="GET" action="{{ route('admin.efiling.case_files.index') }}" id="searchForm">
                    
                    {{-- Case Hearing Date --}}
                    <div class="mb-6">
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Case Hearing Date:</label>
                        <input type="date" name="date" id="date" 
                               class="w-full max-w-xs rounded border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                               value="{{ old('date', request('date', \Carbon\Carbon::today()->format('Y-m-d'))) }}">
                    </div>

                    {{-- Bench Selection --}}
                    <div class="mb-6">
                        <label for="bench_id" class="block text-sm font-medium text-gray-700 mb-2">Bench:</label>
                        <select name="bench_id" id="bench_id" 
                                class="w-full max-w-md rounded border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            <option value="">-- Select Bench --</option>
                            @foreach ($benches as $bench)
                                <option value="{{ $bench->id }}" {{ old('bench_id', request('bench_id')) == $bench->id ? 'selected' : '' }}>
                                    {{ $bench->id }} - {{ $bench->judge->judge_name ?? 'No Judge Assigned' }}
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
                            
                            <input type="number" name="case_no" 
                                   class="w-20 rounded border border-gray-300 px-3 py-2 text-sm bg-gray-100 cursor-not-allowed"
                                   value="{{ old('case_no', request('case_no', session('next_case_no', 1))) }}"
                                   readonly>
                            
                            <input type="number" name="year" 
                                   class="w-24 rounded border border-gray-300 px-3 py-2 text-sm bg-gray-100 cursor-not-allowed"
                                   value="{{ old('year', request('year', session('next_case_year', date('Y')))) }}"
                                   readonly>
                            
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition font-medium text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Search Case
                            </button>
                        </div>
                        <!-- <p class="text-xs text-gray-500 mt-1">Cases are searched automatically in sequence. Fields are read-only.</p> -->
                    </div>
                </form>

                {{-- Search Results Section --}}
                @if(isset($cases) && $cases->count())
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Search Results:</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Case No</th>
                                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Party Name</th>
                                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Purpose</th>
                                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Allocate</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($cases as $case)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-900 font-medium">
                                                {{ $case->case_type }}/{{ $case->case_reg_no }}/{{ $case->case_reg_year }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-900">
                                                {{ $case->party_name }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <form method="POST" action="{{ route('admin.efiling.case_files.allocate') }}" class="inline-block allocation-form">
                                                    @csrf
                                                    <input type="hidden" name="case_id" value="{{ $case->id }}">
                                                    <input type="hidden" name="bench_id" value="{{ request('bench_id') }}">
                                                    <input type="hidden" name="causelist_date" value="{{ request('date') }}">
                                                    <input type="hidden" name="current_case_no" value="{{ request('case_no') }}">
                                                    <input type="hidden" name="current_year" value="{{ request('year') }}">
                                                    <select name="purpose" 
                                                            class="rounded border border-gray-300 px-3 py-1.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                                        @foreach($purposes as $purpose)
                                                            <option value="{{ $purpose->id }}" {{ $purpose->purpose_name == 'FOR ADMISSION' ? 'selected' : '' }}>
                                                                {{ $purpose->purpose_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                            </td>
                                            <td class="px-6 py-4">
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to allocate this case?')"
                                                        class="px-4 py-1.5 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                                                    Allocate
                                                </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif(request()->filled('case_no') || request()->filled('case_type'))
                    <div class="border-t pt-6">
                        <div class="flex flex-col items-center justify-center rounded-md border border-gray-200 bg-gray-50 py-10 text-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-lg font-semibold text-red-600">No Case Found</p>
                            <p class="text-sm">Case {{ request('case_type') }}/{{ request('case_no') }}/{{ request('year') }} was not found.</p>
                            <div class="mt-4">
                                <form method="GET" action="{{ route('admin.efiling.case_files.index') }}" class="inline">
                                    <input type="hidden" name="date" value="{{ request('date') }}">
                                    <input type="hidden" name="bench_id" value="{{ request('bench_id') }}">
                                    <input type="hidden" name="case_type" value="Original Application">
                                    <input type="hidden" name="case_no" value="{{ (int)request('case_no') + 1 }}">
                                    <input type="hidden" name="year" value="{{ request('year') }}">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                        Try Next Case ({{ (int)request('case_no') + 1 }})
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

        </x-admin.container>
    </main>

    @include('partials.footer-alt')

    {{-- Auto search and increment logic --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit form on page load if bench is selected but no search has been performed
            const form = document.getElementById('searchForm');
            const benchSelect = document.getElementById('bench_id');
            const caseNoInput = document.querySelector('input[name="case_no"]');
            const yearInput = document.querySelector('input[name="year"]');
            const hasSearchResults = document.querySelector('.text-red-600') || document.querySelector('tbody');
            
            // Auto search when bench is selected and no previous search
            if (benchSelect.value && !hasSearchResults && !new URLSearchParams(window.location.search).has('case_no')) {
                form.submit();
            }
            
            // Handle allocation form submissions
            document.querySelectorAll('.allocation-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    // Form will submit normally, backend will handle incrementing
                });
            });
            
            // Handle "Try Next Case" functionality
            const nextCaseButtons = document.querySelectorAll('button[type="submit"]');
            nextCaseButtons.forEach(button => {
                if (button.textContent.includes('Try Next Case')) {
                    button.addEventListener('click', function() {
                        // The form will handle incrementing the case number
                    });
                }
            });
        });
    </script>
</x-layout>