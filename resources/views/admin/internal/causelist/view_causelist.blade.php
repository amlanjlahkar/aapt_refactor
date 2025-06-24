<x-layout title="View Causelist | Admin">
    @include('partials.header')

    <main class="grow bg-cover bg-center" style="background-image: url('{{ asset('images/gavel.jpg') }}')">
        <x-admin.container header="View Causelist">

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

            <div class="mb-5 flex items-center gap-3">
                <a href="{{ route('admin.internal.causelists.index') }}"
                class="flex items-center gap-1.5 rounded border border-gray-300 bg-gray-100 px-4 py-2.5 font-semibold text-gray-600 shadow-sm hover:bg-gray-200">
                    <x-fas-arrow-left class="h-4 w-4 text-gray-600" />
                    <span>Back to Causelist Management</span>
                </a>
            </div>

            <div class="rounded-lg border bg-white p-6 shadow mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">
                            ASSAM ADMINISTRATIVE AND PENSION TRIBUNAL
                        </h2>
                        <h3 class="text-lg font-semibold text-gray-700 mb-1">
                            LIST OF CASES TO BE HEARD ON {{ \Carbon\Carbon::parse($causelist->causelist_date)->format('d-m-Y') }}
                        </h3>
                        <p class="text-sm text-gray-600">Daily List</p>
                    </div>
                    <div class="text-right">
                        @if($causelist->status === 'published')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Published
                            </span>
                        @elseif($causelist->isPrepared())
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                Prepared
                            </span>
                        @endif
                    </div>
                </div>

                <div class="border-t pt-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Judge</p>
                            <p class="text-lg font-semibold text-gray-800">
                                HON'BLE {{ strtoupper($causelist->bench->judge->judge_name ?? 'JUSTICE NAME') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Court No</p>
                            <p class="text-lg font-semibold text-gray-800">
                                {{ $causelist->bench->court_no ?? '1' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Time</p>
                            <p class="text-lg font-semibold text-gray-800">10:30 AM</p>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-4 mt-4">
                    <div class="flex gap-3">
                        <a href="{{ route('admin.internal.causelists.download-pdf', $causelist->id) }}" 
                           class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition font-medium">
                            Download PDF
                        </a>
                        @if($causelist->isPrepared() && !$causelist->published_at)
                            <form method="POST" action="{{ route('admin.internal.causelists.publish', $causelist->id) }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to publish this causelist?')"
                                        class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition font-medium">
                                    Publish
                                </button>
                            </form>
                        @endif
                        @if($causelist->published_at)
                            <form method="POST" action="{{ route('admin.internal.causelists.unpublish', $causelist->id) }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to unpublish this causelist?')"
                                        class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition font-medium">
                                    Unpublish
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="rounded-lg border bg-white shadow">
                <div class="border-b bg-gray-50 px-6 py-4 rounded-t-lg">
                    <h3 class="text-lg font-semibold text-gray-800">Cases ({{ $cases->count() }} total)</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sl.
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Case No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Purpose
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Petitioner
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Respondent
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($cases as $index => $case)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-medium text-gray-900">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $case->caseFile->case_type ?? 'Original Application' }}/{{ $case->caseFile->case_number ?? $case->id }}/{{ \Carbon\Carbon::parse($causelist->causelist_date)->format('Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ strtoupper($case->purpose->purpose_name ?? $case->purpose ?? 'FOR ADMISSION') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $case->caseFile->petitioner_name ?? 'ABC' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $case->caseFile->respondent_name ?? 'XYZ' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No cases found in this causelist.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t bg-gray-50 px-6 py-4 text-center">
                    <p class="text-sm text-gray-600">
                        Dy. REGISTRAR/Joint REGISTRAR/SECTION OFFICER/REGISTRAR
                    </p>
                    @if($causelist->published_at)
                        <p class="text-xs text-gray-500 mt-1">
                            Published on: {{ \Carbon\Carbon::parse($causelist->published_at)->format('d-m-Y H:i:s') }}
                            by {{ $causelist->publishedBy->name ?? 'Admin' }}
                        </p>
                    @endif
                </div>
            </div>
        </x-admin.container>
    </main>

    @include('partials.footer-alt')
</x-layout>