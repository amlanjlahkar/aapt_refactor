<x-layout title="Verify Mail">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        @if (session('success'))
            <div
                id="flash"
                class="mx-auto mt-10 flex max-w-xl rounded border border-green-300 bg-green-100 px-3 py-4 font-medium text-green-600"
            >
                {{ session('success') }}
            </div>
        @endif

        <div
            class="mx-auto mt-10 mb-5 max-w-xl rounded-sm border border-gray-300 bg-white p-6"
        >
            <div class="flex flex-col gap-5 p-2">
                <h2 class="text-2xl font-semibold">Verify Email Address</h2>
                <p class="text-left">
                    A verification link has been sent to your registered email address <span class="font-semibold">{{ request('email') }}</span>. Please verify it to proceed.
                </p>
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button
                        type="submit"
                        class="mt-2 cursor-pointer rounded bg-blue-500 px-4 py-2 font-medium text-white hover:bg-blue-600"
                    >
                        Resend Verification Email
                    </button>
                </form>
            </div>
        </div>
    </main>
    @include('partials.footer')
    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash')
            flash.style.display = 'none'
        }, 5000)
    </script>
</x-layout>
