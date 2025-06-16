<x-layout title="Generate Notice | Admin">
    @include('partials.header')
    <main class="grow bg-cover bg-center" style="background-image: url('{{ asset('images/gavel.jpg') }}')">
        <x-admin.container header="Generate Notice">
            <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Generate Notice</h2>
                
                <form method="POST" action="{{ route('admin.internal.notices.store') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Case Number -->
                    <div>
                        <label for="case_id" class="block text-sm font-medium text-gray-700 mb-2">Case No.</label>
                        <select name="case_id" id="case_id" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50">
                            <option value="">-- Select Case --</option>
                            @foreach ($cases as $case)
                                <option value="{{ $case->id }}" 
                                    {{ (old('case_id') ?? ($selectedCaseId ?? '')) == $case->id ? 'selected' : '' }}>
                                    {{ $case->case_no ?? $case->filing_number }}
                                </option>
                            @endforeach
                        </select>
                        @error('case_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Select Notice Type -->
                    <div>
                        <label for="notice_type" class="block text-sm font-medium text-gray-700 mb-2">Select Notice Type</label>
                        <select name="notice_type" id="notice_type" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white appearance-none">
                            <option value="">-- Select Notice Type --</option>
                            @foreach (\App\Models\Notice::NOTICE_TYPES as $key => $value)
                                <option value="{{ $key }}" {{ old('notice_type') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('notice_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        
                        <!-- Custom dropdown arrow -->
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Hearing Date -->
                    <div>
                        <label for="hearing_date" class="block text-sm font-medium text-gray-700 mb-2">Hearing Date</label>
                        <input type="date" name="hearing_date" id="hearing_date" 
                            value="{{ old('hearing_date') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white" />
                        @error('hearing_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Generate Notice Button -->
                    <div class="flex justify-end pt-4">
                        <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                            Generate Notice
                        </button>
                    </div>
                </form>
            </div>
        </x-admin.container>
    </main>
    @include('partials.footer-alt')
</x-layout>