<x-ui.layout title="Login">
    <x-ui.header />
    <main class="grow">
        <div
            class="m-10 mx-auto max-w-md overflow-hidden rounded-md bg-white p-6 shadow-md"
        >
            <h2 class="mb-6 text-center text-xl font-semibold">
                Select Login Type
            </h2>

            <div class="space-y-4">
                <a
                    href="{{ route('user.auth.login.form') }}"
                    class="block w-full rounded bg-blue-500 px-4 py-3 text-center font-bold text-white hover:bg-blue-600"
                >
                    User Login
                </a>

                <a
                    href="#"
                    class="focus:shadow-outline block w-full rounded bg-gray-500 px-4 py-3 text-center font-bold text-white transition duration-150 hover:bg-gray-600 focus:outline-none"
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
    <x-ui.footer />
</x-ui.layout>
