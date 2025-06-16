<x-layout title="Edit Bench Composition | Admin">
    @include('partials.header')
    <main class="grow bg-cover bg-center" style="background-image: url('{{ asset('images/gavel.jpg') }}')">
        <x-admin.container header="Edit Bench Composition">
            <a href="{{ route('admin.internal.bench_compositions.index') }}" class="flex w-1/12 items-center gap-2 rounded border border-gray-300 bg-gray-100 p-2 text-gray-600 hover:bg-gray-200">
                <x-fas-arrow-left class="h-4 w-4" /> Back
            </a>

            <form method="POST" action="{{ route('admin.internal.bench_compositions.update', $benchComposition->id) }}" class="mt-5 grid grid-cols-2 gap-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="court_id" class="block text-sm font-bold text-gray-700 mb-1">Court</label>
                    <select id="court_no" name="court_no" class="w-full border border-gray-300 rounded px-3 py-2">
                        @foreach ($courts as $court)
                            <option value="{{ $court->id }}" {{ $benchComposition->court_id == $court->id ? 'selected' : '' }}>
                                Court {{ $court->court_no }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="judge_id" class="block text-sm font-bold text-gray-700 mb-1">Judge</label>
                    <select id="judge_id" name="judge_id" class="w-full border border-gray-300 rounded px-3 py-2">
                        @foreach ($judges as $judge)
                            <option value="{{ $judge->id }}" {{ $benchComposition->judge_id == $judge->id ? 'selected' : '' }}>
                                {{ $judge->judge_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="bench_type" class="block text-sm font-bold text-gray-700 mb-1">Bench Type</label>
                    <select id="bench_type" name="bench_type" class="w-full border border-gray-300 rounded px-3 py-2">
                        @foreach ($benchTypes as $type)
                            <option value="{{ $type->id }}" {{ $benchComposition->bench_type == $type->id ? 'selected' : '' }}>
                                {{ $type->type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="from_date" class="block text-sm font-bold text-gray-700 mb-1">From Date</label>
                    <input type="date" id="from_date" name="from_date" value="{{ $benchComposition->from_date }}" class="w-full border border-gray-300 rounded px-3 py-2" />
                </div>

                <div>
                    <label for="to_date" class="block text-sm font-bold text-gray-700 mb-1">To Date</label>
                    <input type="date" id="to_date" name="to_date" value="{{ $benchComposition->to_date }}" class="w-full border border-gray-300 rounded px-3 py-2" />
                </div>

                <div>
                    <label for="display" class="block text-sm font-bold text-gray-700 mb-1">Display</label>
                    <select id="display" name="display" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="1" {{ $benchComposition->display ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !$benchComposition->display ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <button type="submit" class="col-span-2 mt-4 rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                    Update
                </button>
            </form>
        </x-admin.container>
    </main>
    @include('partials.footer-alt')
    @stack('scripts')
</x-layout>
