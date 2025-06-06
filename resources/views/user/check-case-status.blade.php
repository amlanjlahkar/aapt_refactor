<x-layout title="Check Case Status">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <x-user.container header="Check Case Status">
            <livewire:check-case-status />
        </x-user.container>
    </main>
    @include('partials.footer-alt')
</x-layout>
