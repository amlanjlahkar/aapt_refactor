<x-layout title="Login">
    @include('partials.header')
    @include('partials.navbar')
    <main class="grow">
        <div
            class="m-10 mx-auto max-w-md overflow-hidden rounded bg-white p-6 shadow-md"
        >
            <div class="mb-6 flex flex-row items-center justify-center gap-2">
                <x-fas-user class="h-5 w-5" />
                <h2 class="text-center text-xl font-semibold">
                    Select Login Type
                </h2>
            </div>

            <div class="space-y-4">
                <a
                    href="{{ route('user.auth.login.form') }}"
                    class="block w-full rounded-sm border border-gray-300 bg-gray-100 px-4 py-3 text-center font-medium shadow-sm hover:border-gray-400 hover:bg-gray-200"
                >
                    User Login
                </a>

                <a
                    href="{{ route('admin.auth.login.form') }}"
                    class="block w-full rounded-sm border border-gray-300 bg-gray-100 px-4 py-3 text-center font-medium shadow-sm hover:border-gray-400 hover:bg-gray-200"
                >
                    Admin Login
                </a>
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Not registered already?
                    <a
                        href="{{ route('user.auth.register.form') }}"
                        class="text-blue-500 hover:text-blue-600 hover:underline"
                    >
                        Register here
                    </a>
                </p>
            </div>
        </div>
    </main>
    @include('partials.footer')
</x-layout>
