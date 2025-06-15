<x-layout title="Pending Case Files for Scrutiny | Admin">
    @include('partials.header')

    <main class="grow bg-cover bg-center" style="background-image: url('{{ asset('images/gavel.jpg') }}')">
        <x-admin.container header="Case Files for Scrutiny">

            {{-- Back Button --}}
            <div class="mb-5 flex flex-row items-center justify-start gap-3">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-1.5 rounded border border-gray-300 bg-gray-100 px-4 py-2.5 font-semibold text-gray-600 shadow-sm hover:bg-gray-200">
                    <x-fas-arrow-left class="h-4 w-4 text-gray-600" />
                    <span>Back</span>
                </a>
            </div>

            {{-- All Pending Cases --}}
            <div class="mb-5 flex items-center justify-between gap-5">
                <h2 class="text-xl font-semibold text-gray-800">Pending Case Files for Scrutiny</h2>
                <span class="rounded-sm border border-blue-300 bg-blue-50 px-3 py-1.5 text-sm font-medium text-blue-700">
                    {{ $cases->count() }} Total Pending
                </span>
            </div>

            @if($cases->isEmpty())
                <div class="flex flex-col items-center justify-center rounded-md border border-gray-200 bg-gray-50 py-10 text-center text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h4l3 3h11v9H3V7z" />
                    </svg>

                    <p class="text-lg font-semibold">{{ $title ?? 'Nothing to show' }}</p>
                    <p class="text-sm">{{ $message ?? 'No data available.' }}</p>
                </div>

            @else
                <div class="overflow-x-auto rounded-lg border bg-white shadow">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Ref No</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Filing Date</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Subject</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($cases as $case)
                                <tr>
                                    <td class="px-6 py-4">{{ $case->ref_number }}</td>
                                    <td class="px-6 py-4">{{ $case->filing_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4">{{ $case->subject }}</td>
                                    <td class="px-6 py-4">
                                        @if($case->latestScrutiny)
                                            <span class="rounded px-2 py-1 text-xs font-medium 
                                                {{ $case->latestScrutiny->objection_status === 'defect_free' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst(str_replace('_', ' ', $case->latestScrutiny->objection_status)) }}
                                            </span>
                                        @else
                                            <span class="rounded bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                            <a href="{{ route('case-file.view', $case->id) }}"
                                            class="inline-block px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">
                                                View Filed Case
                                            </a>
                                    @if ($case->latestScrutiny && $case->latestScrutiny->scrutiny_status === 'Forwarded')
                                        <button class="btn btn-secondary" disabled>Already Scrutinized</button>
                                    @else
                                        <a href="{{ route('scrutiny.create', $case->id) }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                            Scrutinize
                                        </a>
                                    @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </x-admin.container>
    </main>

    @include('partials.footer-alt')
</x-layout>
