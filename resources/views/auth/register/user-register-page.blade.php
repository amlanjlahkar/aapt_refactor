<x-layout title="User Register">
    @include('partials.header')
    <main class="grow">
        <div class="container mx-auto px-4 py-4">
            @include('auth.register.forms.user-register-form')
        </div>
    </main>
    @include('partials.footer')
    @stack('scripts')
</x-layout>
