<x-layout title="Departments - Admin">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/gavel.jpg') }}');
        "
    >
        <x-admin.container header="Department Module">
            <a
                href="{{ route('admin.internal.dept.users.index') }}"
                class="rounded border-1 bg-blue-500 p-3 font-medium text-white shadow-sm hover:bg-blue-600"
            >
                Manage Users
            </a>
        </x-admin.container>
    </main>
    @include('partials.footer-alt')
    @stack('scripts')
</x-layout>
