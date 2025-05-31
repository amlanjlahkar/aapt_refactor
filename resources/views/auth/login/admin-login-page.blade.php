<x-layout title="Admin Login">
    @include('partials.header')
    @include('partials.navbar')
    <main class="grow">
        <div class="container mx-auto px-4 py-4">
            @include('auth.login.forms.admin-login-form')
        </div>
    </main>
    @include('partials.footer')
    @stack('scripts')
</x-layout>
