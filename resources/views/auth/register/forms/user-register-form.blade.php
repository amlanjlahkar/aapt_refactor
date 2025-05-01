<div
    class="mx-auto mt-5 mb-5 max-w-xl overflow-hidden rounded-md bg-white shadow-md"
>
    <div class="p-6">
        <h2 class="mb-4 text-xl font-semibold">User Registration</h2>

        <div
            id="clientErrors"
            class="mb-4 hidden rounded border border-red-300 bg-red-100 px-4 py-2 text-red-700"
        >
            <ul class="list-inside list-disc" id="errorList"></ul>
        </div>

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

        <form
            method="POST"
            action="{{ route('user.auth.register.attempt') }}"
            id="registrationForm"
        >
            @csrf
            <div class="mb-4 flex gap-4">
                <div class="flex-1">
                    <label
                        for="first_name"
                        class="mb-2 block text-sm font-bold text-gray-700"
                    >
                        First Name
                    </label>
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="{{ old('first_name') }}"
                        class="w-full rounded-xs border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required
                    />
                </div>

                <div class="flex-1">
                    <label
                        for="middle_name"
                        class="mb-2 block text-sm font-bold text-gray-700"
                    >
                        Middle Name
                    </label>
                    <input
                        type="text"
                        id="middle_name"
                        name="middle_name"
                        value="{{ old('middle_name') }}"
                        class="w-full rounded-xs border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <div class="flex-1">
                    <label
                        for="last_name"
                        class="mb-2 block text-sm font-bold text-gray-700"
                    >
                        Last Name
                    </label>
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="{{ old('last_name') }}"
                        class="w-full rounded-xs border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required
                    />
                </div>
            </div>

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
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    class="w-full rounded-xs border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required
                />
            </div>

            <div class="mb-4">
                <label
                    for="mobile_no"
                    class="mb-2 block text-sm font-bold text-gray-700"
                >
                    Mobile Number
                </label>
                <input
                    type="tel"
                    id="mobile_no"
                    name="mobile_no"
                    value="{{ old('mobile_no') }}"
                    placeholder="Enter your mobile number"
                    maxlength="10"
                    class="w-full rounded-xs border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required
                />
            </div>

            <div class="mb-6 flex gap-4">
                <div class="flex-1">
                    <label
                        for="password"
                        class="mb-2 block text-sm font-bold text-gray-700"
                    >
                        Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        class="w-full rounded-xs border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required
                    />
                </div>

                <div class="flex-1">
                    <label
                        for="password_confirmation"
                        class="mb-2 block text-sm font-bold text-gray-700"
                    >
                        Confirm Password
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirm your password"
                        class="w-full rounded-xs border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required
                    />
                </div>
            </div>

            <button
                type="submit"
                class="w-full cursor-pointer rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-600"
            >
                Register
            </button>

            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Already registered?
                    <a
                        href="{{ route('user.auth.login.form') }}"
                        class="text-blue-500 hover:text-blue-600 hover:underline"
                    >
                        Login here
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        document
            .getElementById('registrationForm')
            .addEventListener('submit', function (e) {
                e.preventDefault()
                const errors = []
                const errorList = document.getElementById('errorList')
                const clientErrors = document.getElementById('clientErrors')

                errorList.innerHTML = ''
                clientErrors.classList.add('hidden')

                const email = document.getElementById('email').value.trim()
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
                if (!emailRegex.test(email)) {
                    errors.push('Please enter a valid email address')
                }

                const mobileNo = document
                    .getElementById('mobile_no')
                    .value.trim()
                const mobileRegex = /^[0-9]{10}$/
                if (!mobileRegex.test(mobileNo)) {
                    errors.push('Mobile number must be exactly 10 digits')
                }

                const password = document.getElementById('password').value
                const confirmPassword = document.getElementById(
                    'password_confirmation'
                ).value

                if (!password) {
                    errors.push('Password is required')
                } else if (password.length < 8) {
                    errors.push('Password must be at least 8 characters long')
                }

                if (password !== confirmPassword) {
                    errors.push('Passwords do not match')
                }

                if (errors.length > 0) {
                    clientErrors.classList.remove('hidden')
                    errors.forEach((error) => {
                        const li = document.createElement('li')
                        li.textContent = error
                        errorList.appendChild(li)
                    })
                    return
                }

                this.submit()
            })
    </script>
@endpush
