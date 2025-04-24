<x-ui.layout>
    <x-ui.header />
    <main>
        <div class="max-w-md mx-auto mt-10 bg-white rounded-lg shadow-md overflow-hidden p-6">
            <h2 class="text-xl font-semibold mb-6 text-center">Select Login Type</h2>

            <div class="space-y-4">
                <a href="{{ route('user.login') }}"
                    class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                    User Login
                </a>

                <a href="#"
                    class="block w-full text-center bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                    Admin Login
                </a>
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Not registered already?
                    <a href="{{ route('user.register') }}" class="text-blue-500 hover:text-blue-600 hover:underline">
                        Register here
                    </a>
                </p>
            </div>
        </div>
    </main>
    <x-ui.footer />
</x-ui.layout>
