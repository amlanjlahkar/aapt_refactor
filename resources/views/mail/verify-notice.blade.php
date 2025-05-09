<x-layout title="Verify Mail">
    @include('partials.header')
    <main class="grow">
        <div
            class="mx-auto mt-5 mb-5 max-w-md rounded-md bg-white p-6 shadow-md"
        >
            <div class="flex flex-col items-center justify-center">
                <div class="mb-5 text-justify">
                    <h2 class="text-center text-2xl font-semibold">
                        Verify Email Address
                    </h2>
                    <p class="mt-5">
                        A verification link has been sent to your registered
                        email address (
                        <span class="font-semibold">
                            {{ session('email') ? session('email') : '!email address unavailable!' }}
                        </span>
                        ). Please verify it to proceed.
                    </p>
                </div>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button
                        type="submit"
                        class="cursor-pointer rounded bg-blue-500 px-4 py-2 font-medium text-white hover:bg-blue-600"
                    >
                        Resend Verification Email
                    </button>
                </form>
            </div>
        </div>
    </main>
    @include('partials.footer')
</x-layout>
