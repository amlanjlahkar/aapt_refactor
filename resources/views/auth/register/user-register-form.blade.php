<div class="max-w-xl mx-auto mt-10 bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">User Registration</h2>
        <form>
            <div class="flex gap-4 mb-4">
                <div class="flex-1">
                    <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                    <input type="text" id="first_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="flex-1">
                    <label for="middle_name" class="block text-gray-700 text-sm font-bold mb-2">Middle Name</label>
                    <input type="text" id="middle_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex-1">
                    <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                    <input type="text" id="last_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                <input type="email" id="email" placeholder="Enter your email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="mobile" class="block text-gray-700 text-sm font-bold mb-2">Mobile Number</label>
                <input type="tel" id="mobile" placeholder="Enter your mobile number"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="flex gap-4 mb-6">
                <div class="flex-1">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" id="password" placeholder="Enter your password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="flex-1">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                    <input type="password" id="password_confirmation" placeholder="Confirm your password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                Register
            </button>

            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Already registered?
                    <a href="{{ route('user.login') }}" class="text-blue-500 hover:text-blue-600 hover:underline">
                        Login here
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
