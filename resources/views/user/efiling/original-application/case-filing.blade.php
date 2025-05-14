<x-layout title="Application Filing">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <x-user.container header="Step {{ $step }}: Case Information">
            <form
                id="case_info"
                class="grid grid-cols-2 gap-6 rounded-md p-6 pb-0"
                method="POST"
                action="{{ route('user.efiling.register.step' . $step . '.attempt', compact('step')) }}"
            >
                @csrf
                <div class="flex flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="case_type">
                        Case Type
                    </label>
                    <select
                        required
                        name="case_type"
                        class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    >
                        <option value="" disabled selected>
                            Select case type
                        </option>
                        <option
                            value="Original Application"
                            selected
                            {{-- {{ old('case_type') == 'Original Application' ? 'selected' : '' }} --}}
                        >
                            Original Application
                        </option>
                    </select>
                </div>

                <div class="flex flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="bench">
                        Select Bench
                        <span class="text-red-400">*</span>
                    </label>
                    <select
                        required
                        name="bench"
                        class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    >
                        <option value="" disabled selected>Select bench</option>
                        <option
                            value="Guwahati"
                            {{ old('bench') == 'Guwahati' ? 'selected' : '' }}
                        >
                            Guwahati
                        </option>
                    </select>
                </div>

                <div class="flex min-w-1/4 flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="legal_aid">
                        Legal Aid
                        <span class="text-red-400">*</span>
                    </label>
                    <select
                        required
                        name="legal_aid"
                        class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    >
                        <option value="" disabled selected>
                            Legal aid required?
                        </option>
                        <option
                            value="1"
                            {{ old('legal_aid') == '1' ? 'selected' : '' }}
                        >
                            Yes
                        </option>
                        <option
                            value="0"
                            {{ old('legal_aid') == '0' ? 'selected' : '' }}
                        >
                            No
                        </option>
                    </select>
                </div>

                <div class="flex min-w-1/4 flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="subject">
                        Subject
                        <span class="text-red-400">*</span>
                    </label>
                    <select
                        required
                        name="subject"
                        class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    >
                        <option value="" disabled selected>
                            Select case subject
                        </option>
                        <option value="null">Subject 1</option>
                        <option value="null">Subject 2</option>
                    </select>
                </div>
            </form>

            <div class="flex justify-end p-6">
                <button
                    type="submit"
                    form="case_info"
                    class="w-1/5 cursor-pointer items-end rounded bg-blue-500 px-4 py-2 font-semibold text-white shadow-sm hover:bg-blue-600"
                >
                    Save & Proceed ({{ $step }}/5)
                </button>
            </div>
            <div
                class="item-center w-full rounded-br rounded-bl bg-gray-700 p-2"
            >
                <p class="text-center text-sm font-medium text-gray-300 italic">
                    Note: Labels marked with asterisk("
                    <span class="text-red-400">*</span>
                    ") are required fields
                </p>
            </div>
        </x-user.container>
    </main>
    @include('partials.footer-alt')
</x-layout>
