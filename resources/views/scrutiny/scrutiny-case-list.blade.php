<x-layout title="Pending Case Files for Scrutiny | Admin">
    @include('partials.header')

    <main
        class="grow bg-cover bg-center"
        style="background-image: url('{{ asset('images/gavel.jpg') }}')"
    >
        <x-admin.container header="Case Files for Scrutiny">

            <div class="mb-5 flex flex-row items-center justify-start gap-3">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="flex flex-row items-center justify-center gap-1.5 rounded border border-gray-300 bg-gray-100 px-4 py-2.5 font-semibold text-gray-600 shadow-sm hover:bg-gray-200"
                >
                    <x-fas-arrow-left class="h-4 w-4 text-gray-600" />
                    <span>Back</span>
                </a>
            </div>

            <div class="mb-5 flex flex-row items-center justify-between gap-5">
                <h2 class="text-xl font-semibold text-gray-800">Available Cases</h2>
                <span class="rounded-sm border border-green-300 bg-green-50 px-3 py-1.5 text-sm font-medium text-green-700">
                    {{ $cases->count() }} Cases Pending
                </span>
            </div>

            @if($cases->isEmpty())
                <div class="rounded-lg border border-gray-200 bg-white p-12 text-center shadow-sm">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                        <x-fas-folder-open class="h-8 w-8 text-gray-400" />
                    </div>
                    <h3 class="mb-2 text-lg font-medium text-gray-900">No Pending Cases</h3>
                    <p class="text-gray-600">There are currently no case files available for scrutiny.</p>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sl. No.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Filing Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Case Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Filed By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Filing</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scrutiny Level</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($cases as $index => $case)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $case->filing_number }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $case->case_type ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $case->filed_by ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($case->filing_date)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        @switch($case->scrutiny_level)
                                            @case(1)
                                                Registry Reviewer
                                                @break
                                            @case(2)
                                                Section Officer
                                                @break
                                            @case(3)
                                                Department Head
                                                @break
                                            @default
                                                Not Started
                                        @endswitch
                                        <br>
                                        <span class="text-xs text-gray-500 italic">
                                            ({{ $case->scrutiny_status ?? 'Not Started' }})
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $canScrutinize = false;
                                            $admin = Auth::guard('admin')->user();
                                            $role = $admin->roles->pluck('name')->first();
                                            $levelMap = [
                                                            'scrutiny-admin' => 1,         // use this if it's the actual role name
                                                            'registry-reviewer' => 1,
                                                            'section-officer' => 2,
                                                            'department-head' => 3,
                                                        ];

                                            $currentLevel = $levelMap[$role] ?? null;

                                            // Fallback scrutiny level
                                            $scrutinyLevel = (int) ($case->scrutiny_level ?? 0);
                                        @endphp

                                        <!-- {{-- Debug output --}}
                                        <pre class="text-xs text-red-600">
                                        Role: {{ $role }}
                                        Current Level: {{ $currentLevel }}
                                        Case Level: {{ $scrutinyLevel }}
                                        Status: {{ $case->scrutiny_status ?? 'null' }}
                                        </pre> -->

                                        @if(in_array($scrutinyLevel, [0, 1]) && $currentLevel === 1)
                                            @php $canScrutinize = true; @endphp
                                        @elseif($currentLevel === 2 && $scrutinyLevel === 1 && $case->scrutiny_status === 'Forwarded')
                                            @php $canScrutinize = true; @endphp
                                        @elseif($currentLevel === 3 && $scrutinyLevel === 2 && $case->scrutiny_status === 'Forwarded')
                                            @php $canScrutinize = true; @endphp
                                        @endif


                                        {{-- View Case - always available --}}
                                        <a
                                            href="{{ route('scrutiny.casefiles.show', $case->id) }}"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors mb-1"
                                        >
                                            <x-fas-eye class="h-3.5 w-3.5" />
                                            View Filed Case
                                        </a>


                                        {{-- Scrutinize - only if eligible --}}
                                        @if($canScrutinize)
                                            <a
                                                href="{{ route('scrutiny.create', $case->id) }}"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition-colors"
                                            >
                                                <x-fas-search class="h-3.5 w-3.5" />
                                                Scrutinize
                                            </a>
                                        @else
                                            <span class="inline-block px-4 py-2 text-sm text-gray-500 italic">
                                                Scrutinize Not Available
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(method_exists($cases, 'links'))
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            {{ $cases->links() }}
                        </div>
                    @endif
                </div>
            @endif

        </x-admin.container>
    </main>

    @include('partials.footer-alt')
</x-layout>
