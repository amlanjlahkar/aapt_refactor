<x-layout title="{{ $case_status }} Cases">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <x-user.container header="{{ $case_status }} Cases">
            @if ($count === 0)
                <div
                    class="mx-auto rounded border border-blue-300 bg-blue-100 px-3 py-4 font-medium text-blue-500"
                >
                    <p>No {{ $case_status }} Cases!</p>
                </div>
            @else
                @livewire('set-order', compact('count'))

                <hr
                    class="mx-auto mt-5 mb-3 w-1/2 text-center text-transparent"
                />

                @livewire('get-cases', compact('case_status'))
            @endif
        </x-user.container>
    </main>
    @include('partials.footer-alt')
</x-layout>
