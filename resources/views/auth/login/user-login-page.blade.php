<x-ui.layout title="User Login">
    <x-ui.header />

    <main class="grow">
        <div class="container mx-auto px-4 py-4">
            @include('auth.login.forms.user-login-form')
        </div>
    </main>

    <x-ui.footer />
</x-ui.layout>
