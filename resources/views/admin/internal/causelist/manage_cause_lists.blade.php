<x-layout title="Cause List Preparation & Publish | Admin">
    @include('partials.header')

    <main class="grow bg-cover bg-center" style="background-image: url('{{ asset('images/gavel.jpg') }}')">
        <x-admin.container header="Cause List Preparation & Publish">

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

            {{-- Main Content Grid --}}
            <div class="rounded-lg border bg-white p-6 shadow">

                {{-- Header Section --}}
                <div class="border-b bg-gray-50 px-6 py-4 rounded-t-lg">
                    <h2 class="text-lg font-semibold text-gray-800">Cause List Preparation & Publish</h2>
                </div>

                {{-- Causelist Table --}}
                <div class="overflow-x-auto mt-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Court No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Judge Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Causelist Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($causeListGroups ?? [] as $causelist)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $causelist->bench->court_no ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $causelist->bench->judge->judge_name ?? 'No Judge Assigned' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($causelist->causelist_date)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center gap-2">
                                            @if(!$causelist->is_prepared && !$causelist->is_published)
                                                <form method="POST" action="{{ route('admin.internal.causelists.prepare', $causelist->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="px-3 py-1.5 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition font-medium">
                                                        Prepare
                                                    </button>
                                                </form>
                                            @elseif($causelist->is_prepared && !$causelist->is_published)
                                                <form method="POST" action="{{ route('admin.internal.causelists.publish', $causelist->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="px-3 py-1.5 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition font-medium">
                                                        Publish
                                                    </button>
                                                </form>
                                                <a href="{{ route('admin.internal.causelists.view', $causelist->id) }}" 
                                                class="px-3 py-1.5 bg-gray-600 text-white text-xs rounded hover:bg-gray-700 transition font-medium">
                                                    View Causelist
                                                </a>
                                            @else
                                                <a href="{{ route('admin.internal.causelists.view', $causelist->id) }}" 
                                                class="px-3 py-1.5 bg-gray-600 text-white text-xs rounded hover:bg-gray-700 transition font-medium">
                                                    View Causelist
                                                </a>
                                                <form method="POST" action="{{ route('admin.internal.causelists.unpublish', $causelist->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            onclick="return confirm('Are you sure you want to unpublish this causelist?')"
                                                            class="px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition font-medium">
                                                        Unpublish
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" colspan="4">
                                        No cause list records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Status Message --}}
                @if(session('success') && str_contains(session('success'), 'prepared'))
                    <div class="mt-6 p-4 bg-green-50 rounded-lg">
                        <p class="text-green-800 font-medium">Cause list prepared successfully.</p>
                    </div>
                @endif

                {{-- Published Lists Section --}}
                @php
                    $publishedCauselists = $causeListGroups->filter(function($causelist) {
                        return $causelist->is_published;
                    });
                @endphp

                @if($publishedCauselists->isNotEmpty())
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Published Lists</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Court No
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Judge Name
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Causelist Date
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($publishedCauselists as $causelist)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $causelist->bench->court_no ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $causelist->bench->judge->judge_name ?? 'No Judge Assigned' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($causelist->causelist_date)->format('d-m-Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route('admin.internal.causelists.view', $causelist->id) }}" 
                                                class="px-3 py-1.5 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition font-medium">
                                                    View Causelist
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                {{-- Empty State --}}
                @if(isset($causeListGroups) && $causeListGroups->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Causelist Found</h3>
                        <p class="text-gray-500 text-center">No causelist entries found. Please create case allocations first.</p>
                    </div>
                @endif
            </div>

        </x-admin.container>
    </main>

    @include('partials.footer-alt')

    {{-- Confirmation Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add confirmation for prepare action
            document.querySelectorAll('form[action*="prepare"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to prepare this causelist? This will generate a PDF and mark it as prepared.')) {
                        e.preventDefault();
                    }
                });
            });

            // Add confirmation for publish action
            document.querySelectorAll('form[action*="publish"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to publish this causelist? This will make it publicly available.')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</x-layout>