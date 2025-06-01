<x-layout title="Pending Case Files for Scrutiny | Admin">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="background-image: url('{{ asset('images/gavel.jpg') }}')"
    >
        <div class="flex">
            <!-- This will ensure the container takes full width alongside the sidebar -->
            <div class="flex-1 p-6 w-full max-w-full">
                <x-admin.container class="w-full max-w-full" header="Pending Case Files for Scrutiny">

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
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Case ID
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Filing Number
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Filing Year
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($cases as $case)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $case->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $case->filing_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $case->filing_year }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                    Pending Scrutiny
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center gap-3">
                                                    <a
                                                        href="{{ route('cases.show', $case->id) }}"
                                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors"
                                                    >
                                                        <x-fas-eye class="h-3.5 w-3.5" />
                                                        View
                                                    </a>
                                                    <a
                                                        href="{{ route('scrutiny.create', $case->id) }}"
                                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition-colors"
                                                    >
                                                        <x-fas-search class="h-3.5 w-3.5" />
                                                        Scrutinize
                                                    </a>
                                                </div>
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
            </div>
        </div>
    </main>
    @include('partials.footer-alt')
</x-layout>