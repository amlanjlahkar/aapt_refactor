<x-ui.layout>
    <x-ui.header />
    <main>
        <div class="container mx-auto px-4 py-4">
            @include('auth.register.forms.user-register-form')
        </div>
    </main>
    <x-ui.footer />
    @stack('scripts')
</x-ui.layout>
