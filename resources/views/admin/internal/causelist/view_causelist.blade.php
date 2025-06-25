<x-layout title="View Causelist | Admin">
    @include('partials.header')

    <main class="grow bg-cover bg-center" style="background-image: url('{{ asset('images/gavel.jpg') }}')">
        <x-admin.container header="View Causelist">

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
                <a href="{{ route('admin.internal.causelists.index') }}"
                class="flex items-center gap-1.5 rounded border border-gray-300 bg-gray-100 px-4 py-2.5 font-semibold text-gray-600 shadow-sm hover:bg-gray-200">
                    <x-fas-arrow-left class="h-4 w-4 text-gray-600" />
                    <span>Back to Causelists</span>
                </a>
            </div>

            {{-- Causelist Header Info --}}
            <div class="rounded-lg border bg-white p-6 shadow mb-6">
                <div class="border-b bg-gray-50 px-6 py-4 rounded-t-lg -mx-6 -mt-6 mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Causelist Details</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Court No</label>
                        <div class="text-sm text-gray-900">{{ $causelist->bench->court_no ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judge Name</label>
                        <div class="text-sm text-gray-900">{{ $causelist->bench->judge->judge_name ?? 'No Judge Assigned' }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Causelist Date</label>
                        <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($causelist->causelist_date)->format('d-m-Y') }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $causelist->status === 'Published' ? 'bg-green-100 text-green-800' : 
                               ($causelist->status === 'Prepared' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ $causelist->status }}
                        </span>
                    </div>
                </div>

                {{-- Download PDF Button --}}
                @if(in_array($causelist->status, ['Prepared', 'Published']))
                    <div class="mt-4 pt-4 border-t">
                        <a href="{{ route('admin.internal.causelists.download-pdf', $causelist->id) }}" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition font-medium">
                            <x-fas-file-pdf class="h-4 w-4" />
                            Download PDF
                        </a>
                    </div>
                @endif
            </div>

            {{-- Cases List --}}
            <div class="rounded-lg border bg-white p-6 shadow">
                <div class="border-b bg-gray-50 px-6 py-4 rounded-t-lg -mx-6 -mt-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Cases ({{ $cases->count() }} total)</h3>
                </div>

                @if($cases->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        S.No
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Case Number
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Petitioner
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Respondent
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Purpose
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($cases as $case)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $case->serial_no }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            @if($case->caseFile && $case->caseFile->case_type && $case->caseFile->case_reg_no && $case->caseFile->case_reg_year)
                                                {{ $case->caseFile->case_type }}/{{ $case->caseFile->case_reg_no }}/{{ $case->caseFile->case_reg_year }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            @if($case->caseFile && $case->caseFile->petitioners->isNotEmpty())
                                                {{ $case->caseFile->petitioners->pluck('pet_name')->implode(', ') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            @if($case->caseFile && $case->caseFile->respondents->isNotEmpty())
                                                {{ $case->caseFile->respondents->pluck('res_name')->implode(', ') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $case->purpose->purpose_name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $case->status === 'Published' ? 'bg-green-100 text-green-800' : 
                                                   ($case->status === 'Prepared' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ $case->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Cases Found</h3>
                        <p class="text-gray-500 text-center">No cases found for this causelist.</p>
                    </div>
                @endif
            </div>

        </x-admin.container>
    </main>

    @include('partials.footer-alt')
</x-layout>