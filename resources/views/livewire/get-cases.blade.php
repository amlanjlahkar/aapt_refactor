<div class="relative mx-auto">
    <table class="min-w-full border-gray-300">
        <thead class="">
            <tr class="text-left">
                <th class="border border-gray-300 px-4 py-3 font-semibold">Case ID</th>
                <th class="border border-gray-300 px-4 py-3 font-semibold">Filing No.</th>
                <th class="border border-gray-300 px-4 py-3 font-semibold">Filed By</th>
                <th class="border border-gray-300 px-4 py-3 font-semibold">Created At</th>
                <th class="border border-gray-300 px-4 py-3 font-semibold">
                    Last Updated At
                </th>
                <th class="border border-gray-300 px-4 py-3 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cases as $case)
                <tr class="text-left">
                    <td class="border border-gray-300 px-4 py-3">
                        {{ $case->id }}
                    </td>
                    <td class="border border-gray-300 px-4 py-3">
                        {{ $case->filing_number }}
                    </td>
                    <td class="border border-gray-300 px-4 py-3">
                        {{ $case->filed_by }}
                    </td>
                    <td class="border border-gray-300 px-4 py-3">
                        {{ $case->created_at }}
                    </td>
                    <td class="border border-gray-300 px-4 py-3">
                        {{ $case->updated_at }}
                    </td>
                    <td class="border border-gray-300 px-2 py-3">
                        <div class="grid grid-cols-3 gap-3 px-2">
                            <form
                                class="col-span-3"
                                @switch($case->status)
                                    @case("Draft")
                                        method="GET"
                                        action="{{ route("user.cases.draft.continue", ["case_file_id" => $case->id]) }}"

                                        @break
                                    @case("Pending")
                                        method="POST"
                                        action="{{ route("user.efiling.generate_case_pdf", ["case_file_id" => $case->id]) }}"

                                        @break
                                @endswitch
                            >
                                @csrf
                                <button
                                    class="flex cursor-pointer items-center justify-center gap-1.5 rounded-sm bg-gray-700 px-3.5 py-1.5 text-sm font-medium text-white shadow-md hover:bg-gray-800"
                                >
                                    @switch($case->status)
                                        @case("Draft")
                                            <x-fas-arrow-right
                                                class="h-3.5 w-3.5"
                                            />
                                            Continue

                                            @break
                                        @case("Pending")
                                            <x-fas-eye class="h-3.5 w-3.5" />
                                            View Filed Form

                                            @break
                                    @endswitch
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
