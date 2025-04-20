<div id="admin-login-form" class="login-form">
    <h2 class="text-xl font-semibold mb-4">Enter admin credentials</h2>
    <form>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
            <input type="email" id="email" placeholder="Enter your email"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <label for="otp" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <p class="text-sm text-gray-600 hover:text-blue-600 hover:underline cursor-pointer">Forgot password?</p>
            </div>
            <input type="password" id="email-password" placeholder="Enter your password"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <button type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
            Login as Admin
        </button>
    </form>
</div>
