<x-layout title="Pending Cases">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <x-user.container header="Pending Cases">
            @if (count($cases) === 0)
                <div
                    class="mx-auto rounded border border-yellow-300 bg-yellow-100 px-3 py-4 font-medium text-yellow-500"
                >
                    <p>No Pending Cases!</p>
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
                                Filed At
                            </th>
                            <th class="border border-gray-300 px-4 py-3">
                                Actions
                            </th>
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
                                    {{ $case->updated_at }}
                                </td>
                                <td class="border border-gray-300 px-2 py-3">
                                    <div class="grid grid-cols-3 gap-3 px-2">
                                        <form
                                            method="POST"
                                            action="{{ route('user.efiling.generate_case_pdf', ['case_file_id' => $case->id]) }}"
                                        >
                                        @csrf
                                            <button
                                                class="cursor-pointer flex items-center justify-center gap-1.5 rounded-sm bg-yellow-600 px-3.5 py-1.5 text-sm font-medium text-yellow-50 shadow-md hover:bg-yellow-700"
                                            >
                                                <x-fas-eye
                                                    class="h-3.5 w-3.5"
                                                />
                                                View Filled Form
                                            </button>
                                        </form>
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
