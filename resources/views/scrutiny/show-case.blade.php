<x-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Filed Case Details</h1>

        <div class="mb-6">
            <h2 class="text-lg font-semibold">Reference Number: {{ $case_file->ref_number }}</h2>
            <p><strong>Filing Number:</strong> {{ $case_file->filing_number }}</p>
            <p><strong>Subject:</strong> {{ $case_file->subject }}</p>
            <p><strong>Status:</strong> {{ $case_file->status }}</p>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Uploaded Documents</h3>
            <ul class="list-disc ml-5">
                @forelse($case_file->documents as $document)
                    <li>
                        <a href="{{ asset('storage/' . $document->filepath) }}" target="_blank" class="text-blue-600 underline">
                            {{ $document->filename }}
                        </a>
                    </li>
                @empty
                    <li>No documents uploaded.</li>
                @endforelse
            </ul>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Acknowledgment PDF</h3>
            <div class="border rounded shadow-md overflow-hidden">
                <iframe
                    src="{{ route('case-file.pdf.inline', $case_file->id) }}"
                    width="100%"
                    height="600px"
                    class="w-full border-none"
                ></iframe>
            </div>
        </div>

        <a href="{{ url()->previous() }}" class="inline-block px-4 py-2 mt-4 bg-gray-500 text-white rounded hover:bg-gray-600">Back</a>
    </div>
</x-layout>
