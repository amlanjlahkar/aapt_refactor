<x-layout title="Draft Cases">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <x-user.container header="Draft Cases">
            @if (count($cases) === 0)
                <div
                    class="mx-auto rounded border border-blue-300 bg-blue-100 px-3 py-4 font-medium text-blue-500"
                >
                    <p>No Draft Cases!</p>
                </div>
            @else
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr class="text-left">
                            <th class="border border-gray-300 px-4 py-3">
                                Case ID
                            </th>
                            <th class="border border-gray-300 px-4 py-3">
                                Filing No.
                            </th>
                            <th class="border border-gray-300 px-4 py-3">
                                Created At
                            </th>
                            <th class="border border-gray-300 px-4 py-3">
                                Last Updated At
                            </th>
                            <th class="border border-gray-300 px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cases as $case)
                            <tr class="text-left hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-3">
                                    {{ $case->id }}
                                </td>
                                <td class="border border-gray-300 px-4 py-3">
                                    {{ $case->filing_number }}
                                </td>
                                <td class="border border-gray-300 px-4 py-3">
                                    {{ $case->created_at }}
                                </td>
                                <td class="border border-gray-300 px-4 py-3">
                                    {{ $case->updated_at }}
                                </td>
                                <td class="border border-gray-300 px-2 py-3">
                                    <div class="grid grid-cols-3 gap-3 px-2">
                                        <a
                                            href="{{ route('user.cases.draft.continue', ['case_file_id' => $case->id]) }}"
                                            class="flex items-center justify-center gap-1.5 rounded-sm bg-blue-600 px-3.5 py-1.5 text-sm font-medium text-blue-50 shadow-md hover:bg-blue-700"
                                        >
                                            <x-fas-arrow-right class="h-3.5 w-3.5" />
                                            Continue
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </x-user.container>
    </main>
    @include('partials.footer-alt')
</x-layout>
