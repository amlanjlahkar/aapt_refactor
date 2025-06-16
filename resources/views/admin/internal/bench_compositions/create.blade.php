<x-layout title="Add Bench Composition | Admin">
    @include('partials.header')
    <main class="grow bg-cover bg-center" style="background-image: url('{{ asset('images/gavel.jpg') }}')">
        <x-admin.container header="Add New Bench Composition">
            <a href="{{ route('admin.internal.bench_composition.index') }}" class="flex w-1/12 items-center gap-2 rounded border border-gray-300 bg-gray-100 p-2 text-gray-600 hover:bg-gray-200">
                <x-fas-arrow-left class="h-4 w-4" /> Back
            </a>

            <form method="POST" action="{{ route('admin.internal.bench_composition.store') }}" class="mt-5 grid grid-cols-2 gap-5">
                @csrf
                <div>
                    <label for="court_id" class="block text-sm font-bold text-gray-700 mb-1">Court</label>
                    <select id="court_id" name="court_id" class="w-full border border-gray-300 rounded px-3 py-2">
                        @foreach ($courts as $court)
                            <option value="{{ $court->id }}">Court {{ $court->court_no }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="judge_id" class="block text-sm font-bold text-gray-700 mb-1">Judge</label>
                    <select id="judge_id" name="judge_id" class="w-full border border-gray-300 rounded px-3 py-2">
                        @foreach ($judges as $judge)
                            <option value="{{ $judge->id }}">{{ $judge->judge_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="bench_type" class="block text-sm font-bold text-gray-700 mb-1">Bench Type</label>
                    <select id="bench_type" name="bench_type" class="w-full border border-gray-300 rounded px-3 py-2">
                        @foreach ($benchTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="from_date" class="block text-sm font-bold text-gray-700 mb-1">From Date</label>
                    <input type="date" id="from_date" name="from_date" class="w-full border border-gray-300 rounded px-3 py-2" />
                </div>

                <div>
                    <label for="to_date" class="block text-sm font-bold text-gray-700 mb-1">To Date</label>
                    <input type="date" id="to_date" name="to_date" class="w-full border border-gray-300 rounded px-3 py-2" />
                </div>

                <div class="flex items-center gap-2 mt-6">
                    <input type="checkbox" id="display" name="display" class="h-4 w-4" checked />
                    <label for="display" class="text-sm font-bold text-gray-700">Display</label>
                </div>

                <button type="submit" class="col-span-2 mt-4 rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                    Submit
                </button>
            </form>
        </x-admin.container>
    </main>
    @include('partials.footer-alt')
    @stack('scripts')
</x-layout>
