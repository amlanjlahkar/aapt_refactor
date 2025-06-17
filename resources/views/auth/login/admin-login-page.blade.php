<x-layout title="Admin Login">
    @include('partials.header')
    @include('partials.navbar')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <div class="container mx-auto px-4 py-4">
            @include('auth.login.forms.admin-login-form')
        </div>
    </main>
    @include('partials.footer')
    @stack('scripts')
</x-layout>
