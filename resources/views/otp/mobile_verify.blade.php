<x-layout title="Verify Mobile">
    @include('partials.header')
    <main>
        <div
            class="mx-auto mt-5 mb-5 max-w-md rounded-md bg-white p-6 shadow-md"
        >
            <div class="flex flex-col items-center justify-center">
                <div class="mb-5 text-center">
                    <h2 class="text-2xl font-semibold">Verify Mobile Number</h2>
                    <p class="mt-5">
                        We have sent a 6-digit OTP to your registered mobile number
                        (<span class="font-semibold">
                            {{ session('mobile') ? session('mobile') : '!mobile number unavailable!' }}
                        </span>).
                        Please enter it below to verify your mobile number.
                    </p>
                </div>

                <!-- OTP Submission Form -->
                <form
                    method="POST"
                    action="{{ route('verify.mobile.submit') }}"
                    class="w-full mt-5"
                >
                    @csrf

                    <div class="flex justify-between space-x-2 mb-4">
                        @for ($i = 1; $i <= 6; $i++)
                            <input
                                type="text"
                                name="otp_digit_{{ $i }}"
                                maxlength="1"
                                required
                                class="w-12 h-12 text-center text-xl border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                                pattern="[0-9]*"
                                inputmode="numeric"
                            >
                        @endfor
                    </div>

                    @error('otp')
                        <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
                    @enderror

                    <button
                        type="submit"
                        class="w-full cursor-pointer rounded bg-blue-500 px-4 py-2 font-medium text-white hover:bg-blue-600"
                    >
                        Verify OTP
                    </button>
                </form>

                <!-- Resend OTP Form -->
                <form
                    method="POST"
                    action="{{ route('mobile.resend') }}"
                    class="w-full mt-4 text-center"
                >
                    @csrf
                    <button
                        type="submit"
                        class="text-blue-500 hover:underline text-sm"
                    >
                        Resend OTP
                    </button>
                </form>
            </div>
        </div>
    </main>
    @include('partials.footer')

    <script>
        // Auto-focus next input box when typing
        const inputs = document.querySelectorAll('input[name^="otp_digit_"]');
        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && input.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    </script>
</x-layout>
