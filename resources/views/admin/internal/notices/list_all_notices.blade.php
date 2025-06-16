<x-layout title="Notice Management | Admin">
    @include('partials.header')
    <main class="grow bg-cover bg-center" style="background-image: url('{{ asset('images/gavel.jpg') }}')">
        <x-admin.container header="Notice Management">
            <!-- Case List Section -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Case List</h3>
                <table class="min-w-full table-auto border border-gray-300 bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2 text-left">Sl. No.</th>
                            <th class="border px-4 py-2 text-left">Filing Number</th>
                            <th class="border px-4 py-2 text-left">Case Type</th>
                            <th class="border px-4 py-2 text-left">Filed By</th>
                            <th class="border px-4 py-2 text-left">Date of Filing</th>
                            <th class="border px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cases ?? [] as $index => $case)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2">{{ $case->filing_number ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $case->case_type ?? 'Original Application' }}</td>
                                <td class="border px-4 py-2">{{ $case->filed_by ?? '' }}</td>
                                <td class="border px-4 py-2">{{ $case->created_at ? \Carbon\Carbon::parse($case->created_at)->format('d-m-Y') : '' }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('admin.internal.notices.create', ['case_id' => $case->id]) }}"
                                        class="rounded bg-blue-600 px-3 py-1 text-white text-sm hover:bg-blue-700">
                                        Create Notice
                                    </a>


                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border px-4 py-2 text-center text-gray-500">No cases found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Available Notices Section -->
            <div>
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Available Notices</h3>
                <table class="min-w-full table-auto border border-gray-300 bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2 text-left">Sl. No.</th>
                            <th class="border px-4 py-2 text-left">Case No.</th>
                            <th class="border px-4 py-2 text-left">Petitioner</th>
                            <th class="border px-4 py-2 text-left">Respondent</th>
                            <th class="border px-4 py-2 text-left">Hearing Date</th>
                            <th class="border px-4 py-2 text-left">Notice Type</th>
                            <th class="border px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            @forelse ($notices as $index => $notice)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-4 py-2">{{ $index + 1 }}</td>

                                    {{-- Case No using registration number --}}
                                    <td class="border px-4 py-2">
                                        {{ $notice->case->case_reg_no ?? 'N/A' }}/{{ $notice->case->case_reg_year ?? '' }}
                                    </td>

                                    {{-- Petitioner name(s) --}}
                                    <td class="border px-4 py-2">
                                        {{ $notice->case->petitioners->pluck('pet_name')->filter()->join(', ') ?: 'N/A' }}
                                    </td>

                                    {{-- Respondent name(s) --}}
                                    <td class="border px-4 py-2">
                                        {{ $notice->case->respondents->pluck('res_name')->filter()->join(', ') ?: 'N/A' }}
                                    </td>

                                    {{-- Hearing date --}}
                                    <td class="border px-4 py-2">
                                        {{ \Carbon\Carbon::parse($notice->hearing_date)->format('d/m/Y') }}
                                    </td>

                                    {{-- Notice type --}}
                                    <td class="border px-4 py-2">{{ $notice->notice_type_name }}</td>

                                    {{-- Actions --}}
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('admin.internal.notices.show', $notice->id) }}" class="text-blue-600 hover:underline text-sm">View</a>
                                        <span class="mx-1">|</span>
                                        <a href="{{ route('admin.internal.notices.edit', $notice->id) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                                        <span class="mx-1">|</span>
                                        <form method="POST" action="{{ route('admin.internal.notices.destroy', $notice->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="border px-4 py-2 text-center text-gray-500">No notices found.</td>
                                </tr>
                            @endforelse
                    </tbody>

                </table>
            </div>
        </x-admin.container>
    </main>
    @include('partials.footer-alt')
</x-layout>