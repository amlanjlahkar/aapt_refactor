<div
    class="mx-auto mt-5 mb-5 max-w-md overflow-hidden rounded-md bg-white p-6 shadow-md"
>
    <h2 class="mb-4 text-xl font-semibold">Enter user credentials</h2>

    @if ($errors->any())
        <div
            class="mb-4 rounded border border-red-300 bg-red-100 px-4 py-2 text-red-700"
        >
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('user.login.submit') }}">
        @csrf
        <div class="mb-4">
            <label
                for="email"
                class="mb-2 block text-sm font-bold text-gray-700"
            >
                Email Address
            </label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                class="w-full rounded-xs border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
            />
        </div>
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <label
                    for="otp"
                    class="mb-2 block text-sm font-bold text-gray-700"
                >
                    Password
                </label>
                <p
                    class="cursor-pointer text-sm text-gray-600 hover:text-blue-600 hover:underline"
                >
                    Forgot password?
                </p>
            </div>
            <input
                type="password"
                id="email-password"
                name="password"
                placeholder="Enter your password"
                class="w-full rounded-xs border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
            />
        </div>
        <button
            type="submit"
            class="w-full cursor-pointer rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-600"
        >
            Login as User
        </button>
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                Not registered already?
                <a
                    href="{{ route('user.register') }}"
                    class="text-blue-500 hover:text-blue-600 hover:underline"
                >
                    Register here
                </a>
            </p>
        </div>
    </form>
</div>
