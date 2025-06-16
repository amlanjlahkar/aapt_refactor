<x-layout title="Edit Notice | Admin">
    @include('partials.header')
   <main class="grow bg-cover bg-center" style="background-image: url('{{ asset('images/gavel.jpg') }}')">
        <x-admin.container header="Edit Notice">
            <form method="POST" action="{{ route('admin.internal.notices.update', $notice->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Case selection -->
                <div>
                    <label for="case_id" class="block font-medium text-gray-700">Select Case</label>
                    <select name="case_id" id="case_id" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($cases as $case)
                            <option value="{{ $case->id }}" {{ $notice->case_id == $case->id ? 'selected' : '' }}>
                                {{ $case->case_no }}
                            </option>
                        @endforeach
                    </select>
                    @error('case_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notice type -->
                <div>
                    <label for="notice_type" class="block font-medium text-gray-700">Notice Type</label>
                    <select name="notice_type" id="notice_type" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach (\App\Models\Notice::NOTICE_TYPES as $key => $value)
                            <option value="{{ $key }}" {{ $notice->notice_type == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    @error('notice_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hearing date -->
                <div>
                    <label for="hearing_date" class="block font-medium text-gray-700">Hearing Date</label>
                    <input type="date" name="hearing_date" id="hearing_date"
                        value="{{ \Carbon\Carbon::parse($notice->hearing_date)->format('Y-m-d') }}" required
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    @error('hearing_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                        Update Notice
                    </button>
                </div>
            </form>
        </x-admin.container>
    </main>
    @include('partials.footer-alt')
</x-layout>
