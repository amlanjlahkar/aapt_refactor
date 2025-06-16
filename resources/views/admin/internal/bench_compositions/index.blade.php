<x-layout title="Bench Composition | Admin">
    @include('partials.header')
    <main class="grow bg-cover bg-center" style="background-image: url('{{ asset('images/gavel.jpg') }}')">
        <x-admin.container header="Bench Composition List">
            <div class="mb-4 flex justify-end">
                <a href="{{ route('admin.internal.bench_composition.create') }}" class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                    Add New
                </a>
            </div>
            <table class="min-w-full table-auto border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">Sl. No</th>
                        <th class="border px-4 py-2">Court No</th>
                        <th class="border px-4 py-2">Bench Type</th>
                        <th class="border px-4 py-2">Judge</th>
                        <th class="border px-4 py-2">From Date</th>
                        <th class="border px-4 py-2">To Date</th>
                        <th class="border px-4 py-2">Display</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($benchCompositions as $index => $bench)
                        <tr>
                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2">{{ $bench->court->court_no ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">{{ $bench->benchType->type_name ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">{{ $bench->judge->judge_name ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">{{ $bench->from_date }}</td>
                            <td class="border px-4 py-2">{{ $bench->to_date }}</td>
                            <td class="border px-4 py-2">{{ $bench->display ? 'Yes' : 'No' }}</td>
                            <td class="border px-4 py-2">
                                <a href="#" class="text-blue-600 hover:underline">Edit</a> |
                                <form method="POST" action="#" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="border px-4 py-2 text-center">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-admin.container>
    </main>
    @include('partials.footer-alt')
    @stack('scripts')
</x-layout>
