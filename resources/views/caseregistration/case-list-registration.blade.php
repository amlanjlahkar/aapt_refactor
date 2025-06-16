<x-layout title="Cases Ready for Registration | Admin">
    @include('partials.header')

    <main class="grow bg-cover bg-center" style="background-image: url('{{ asset('images/gavel.jpg') }}')">
        <x-admin.container header="Cases Ready for Registration">
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

            {{-- Header --}}
            <div class="mb-5 flex items-center justify-between gap-5">
                <h2 class="text-xl font-semibold text-gray-800">Ready for Registration</h2>
                <span class="rounded-sm border border-green-300 bg-green-50 px-3 py-1.5 text-sm font-medium text-green-700">
                    {{ $cases->count() }} Ready
                </span>
            </div>

            {{-- Case List --}}
            @if($cases->isEmpty())
                <div class="flex flex-col items-center justify-center rounded-md border border-gray-200 bg-gray-50 py-10 text-center text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13V7H9V3L2 10l7 7z" />
                    </svg>
                    <p class="text-lg font-semibold">No Cases Ready for Registration</p>
                    <p class="text-sm">Please complete scrutiny first.</p>
                </div>
            @else
                <div class="overflow-x-auto rounded-lg border bg-white shadow">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Filing No</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Case Type</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($cases as $case)
                                <tr>
                                    <td class="px-6 py-4">{{ $case->filing_number }}</td>
                                    <td class="px-6 py-4">{{ $case->case_type }}</td>
                                    <td class="px-6 py-4">
                                        @if(is_null($case->case_reg_no))
                                            <form method="POST" action="{{ route('admin.registration.generate') }}">
                                                @csrf
                                                <input type="hidden" name="filing_number" value="{{ $case->filing_number }}">
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to register this case?')"
                                                    class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                                                    Generate Case No
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-green-700 font-semibold">
                                                {{ $case->case_type }}/{{ $case->case_reg_no }}/{{ $case->case_reg_year }}
                                            </span>
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
