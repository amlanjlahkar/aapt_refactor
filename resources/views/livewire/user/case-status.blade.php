<div>
    <input
        wire:model="search"
        type="search"
        placeholder="Enter case filing number"
        class="w-1/4 rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
    />

    <button
        wire:click="check"
        class="ml-2.5 cursor-pointer items-end rounded-sm bg-blue-500 px-4 py-2 font-semibold text-white shadow-sm hover:bg-blue-600"
    >
        Check
    </button>

    @if (session()->has('error'))
        <div
            class="mt-5 w-full rounded-sm border border-red-300 bg-red-100 px-4 py-4 text-red-600"
        >
            {{ session('error') }}
        </div>
    @endif


    @if ($case)
        <table class="mt-5 w-full border border-gray-300">
            <thead class="bg-gray-200">
                <tr class="text-left">
                    <th class="w-1/12 border border-gray-300 px-4 py-3">
                        Case ID
                    </th>
                    <th class="w-2/12 border border-gray-300 px-4 py-3">
                        Case Status
                    </th>
                    <th class="w-3/12 border border-gray-300 px-4 py-3">
                        Case Filed By
                    </th>
                    <th class="w-2/12 border border-gray-300 px-4 py-3">
                        Created At
                    </th>
                    <th class="w-2/12 border border-gray-300 px-4 py-3">
                        Last Updated At
                    </th>
                    <th class="w-2/12 border border-gray-300 px-4 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white text-left">
                    <td class="border border-gray-300 px-4 py-3">
                        {{ $case->id }}
                    </td>
                    <td class="border border-gray-300 px-4 py-3">
                        {{ $case->status }}
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
            </tbody>
        </table>
    @endif
</div>
