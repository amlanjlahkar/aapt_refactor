<div class="max-w-md mx-auto mt-10 bg-white rounded-lg shadow-md overflow-hidden">
    <div class="flex border-b border-gray-200">
        <div class="flex-1 text-center py-4 px-4 cursor-pointer font-medium transition-all login-tab active border-b-2 border-blue-500 text-blue-500"
            data-form="email-form">
            User Login
        </div>
        <div class="flex-1 text-center py-4 px-4 cursor-pointer font-medium transition-all login-tab hover:bg-gray-50 border-b-2 border-transparent"
            data-form="phone-form">
            Admin Login
        </div>
    </div>

    <div class="p-6">
        <div id="email-form" class="login-form block">
            <h2 class="text-xl font-semibold mb-4">Enter user credentials</h2>
            <form>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                    <input type="tel" id="phone" placeholder="Enter your phone number"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <label for="otp" class="block text-gray-700 text-sm font-bold mb-2">OTP</label>
                        <p class="text-sm text-gray-600 hover:text-blue-600 hover:underline cursor-pointer">Resend OTP
                        </p>
                    </div>
                    <input type="text" minlength="6" maxlength="6" inputmode="numeric" id="otp" placeholder="Enter One Time Password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                    Login as User
                </button>
            </form>
        </div>

        <div id="phone-form" class="login-form hidden">
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
                        <p class="text-sm text-gray-600 hover:text-blue-600 hover:underline cursor-pointer">Forgot
                            password?</p>
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
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.login-tab');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class and styles from all tabs
                document.querySelectorAll('.login-tab').forEach(t => {
                    t.classList.remove('active');
                    t.classList.remove('border-blue-500');
                    t.classList.remove('text-blue-500');
                    t.classList.add('border-transparent');
                    t.classList.add('hover:bg-gray-50');
                });

                // Add active class and styles to clicked tab
                this.classList.add('active');
                this.classList.add('border-blue-500');
                this.classList.add('text-blue-500');
                this.classList.remove('border-transparent');
                this.classList.remove('hover:bg-gray-50');

                // Hide all forms
                document.querySelectorAll('.login-form').forEach(f => {
                    f.classList.add('hidden');
                    f.classList.remove('block');
                });

                // Show corresponding form
                const formId = this.getAttribute('data-form');
                document.getElementById(formId).classList.remove('hidden');
                document.getElementById(formId).classList.add('block');
            });
        });
    });
</script>
