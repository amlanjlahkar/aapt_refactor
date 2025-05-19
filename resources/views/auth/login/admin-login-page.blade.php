<<<<<<< HEAD
<x-layout title="Admin Login">
=======
<x-layout title="User Login">
>>>>>>> 80c7f37 (feat: Initial admin logic)
    @include('partials.header')
    @include('partials.navbar')
    <main class="grow">
        <div class="container mx-auto px-4 py-4">
            @include('auth.login.forms.admin-login-form')
        </div>
    </main>
    @stack('scripts')
    @include('partials.footer')
</x-layout>
