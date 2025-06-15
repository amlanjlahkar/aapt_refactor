<x-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold mb-6">Cases Ready for Registration</h2>

        @if(session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($cases->isEmpty())
            <p class="text-gray-600">No cases available for registration.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded shadow-sm">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="px-4 py-2">Filing No</th>
                            <th class="px-4 py-2">Case Type</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cases as $case)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $case->filing_no }}</td>
                                <td class="px-4 py-2">{{ $case->case_type }}</td>
                                <td class="px-4 py-2">
                                    <form method="POST" action="{{ route('admin.registration.generate') }}">
                                        @csrf
                                        <input type="hidden" name="filing_number" value="{{ $case->filing_no }}">
                                        <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm">
                                            Register Case
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layout>
