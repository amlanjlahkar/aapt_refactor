<div
    class="mx-auto mt-5 mb-5 max-w-xl overflow-hidden rounded bg-white p-6 border border-gray-300"
>
    <div class="mb-6 flex flex-row items-center justify-start gap-2">
        <x-fas-user class="h-5 w-5" />
        <h2 class="text-2xl font-semibold">Enter User Credentials</h2>
    </div>

    @if ($errors->any())
        <div
            class="mb-4 rounded border border-red-300 bg-red-100 px-4 py-2 text-red-700"
        >
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    @if (str_contains($error, 'captcha'))
                        <li>Invalid captcha</li>
                    @else
                        <li>{{ $error }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('user.auth.login.attempt') }}">
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
                placeholder="Enter your user email"
                value="{{ old('email') }}"
                class="w-full rounded-xs border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
            />
        </div>
        <div class="mb-4">
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
                id="password"
                name="password"
                placeholder="Enter your password"
                class="w-full rounded-xs border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
            />
        </div>
        <div class="mb-6">
            <div class="flex flex-row items-center justify-between gap-3.5">
                <input
                    type="text"
                    id="captcha"
                    name="captcha"
                    placeholder="Enter captcha"
                    class="w-2/3 rounded-xs border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required
                />
                <span id="captcha_img" class="w-1/3">
                    {!! captcha_img('flat') !!}
                </span>
                <x-fas-arrow-rotate-right
                    id="captcha_refresh_btn"
                    class="w-5 cursor-pointer text-gray-700"
                    title="Refresh captcha"
                />
            </div>
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
                    href="{{ route('user.auth.register.form') }}"
                    class="text-blue-500 hover:text-blue-600 hover:underline"
                >
                    Register here
                </a>
            </p>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        const captcha = document.getElementById('captcha_img')
        const refreshBtn = document.getElementById('captcha_refresh_btn')

        refreshBtn.addEventListener('click', () => {
            fetch('/refresh-captcha')
                .then((res) => res.text())
                .then((data) => {
                    captcha.innerHTML = data
                })
        })
    </script>
@endpush
