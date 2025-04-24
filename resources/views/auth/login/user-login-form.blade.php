<div id="user-login-form" class="max-w-md mx-auto mt-10 bg-white rounded-md shadow-md overflow-hidden p-6">
    <h2 class="text-xl font-semibold mb-4">Enter user credentials</h2>

    @if ($errors->any())
        <div class="mb-4 text-red-700 bg-red-100 border border-red-300 rounded px-4 py-2">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('user.login.submit') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email"
                class="w-full px-3 py-2 border border-gray-300 rounded-xs focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <label for="otp" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <p class="text-sm text-gray-600 hover:text-blue-600 hover:underline cursor-pointer">Forgot password?</p>
            </div>
            <input type="password" id="email-password" name="password" placeholder="Enter your password"
                class="w-full px-3 py-2 border border-gray-300 rounded-xs focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>
        <button type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
            Login as User
        </button>
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                Not registered already?
                <a href="{{ route('user.register') }}"
                    class="text-blue-500 hover:text-blue-600 hover:underline">Register here</a>
            </p>
        </div>
    </form>
</div>
