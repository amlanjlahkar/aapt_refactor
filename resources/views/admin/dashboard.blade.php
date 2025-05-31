<x-layout title="Admin Dashboard">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/gavel.jpg') }}');
        "
    >
        <x-admin.container header="Admin Dashboard for Assam APT">
            <h1 class="text-xl font-semibold">
                Welcome {{ session('admin') }}
            </h1>
        </x-admin.container>
    </main>
    @include('partials.footer-alt')
</x-layout>
