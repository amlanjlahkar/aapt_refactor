<x-layout title="Submit Notice">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <div class="flex flex-col gap-5 p-7">
            <div
                class="mx-auto mt-12 max-w-1/2 rounded bg-white p-6 shadow-md"
            >
                <h1 class="mb-4 text-2xl font-semibold text-gray-700">
                    Your application has been submitted successfully!
                </h1>

                <p class="mb-16 text-gray-700">
                    You can now return to your dashboard or download a copy of
                    your case file application.
                </p>

                <div
                    class="flex flex-col gap-5"
                >
                    <a
                        href="{{ route('user.dashboard') }}"
                        class="inline-block font-medium text-blue-600 underline hover:text-blue-800"
                    >
                        ← Return to Dashboard
                    </a>

                    <form
                        action="{{ route('user.efiling.generate_case_pdf', compact('case_file_id')) }}"
                        method="POST"
                    >
                        @csrf
                        <button
                            type="submit"
                            class="flex justify-center items-center gap-2 rounded bg-blue-500 px-5 py-2 font-semibold text-white shadow hover:bg-blue-600"
                        >
                            <x-fas-file-pdf class="w-4 h-4" />
                            Download Submitted Application
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    @include('partials.footer-alt')
</x-layout>
