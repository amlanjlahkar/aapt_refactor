{{--
    The default view container for user.
    It conatins a fixed side panel and the area(slot) where
    main contents should go
--}}
@props([
    'header' => null,
])

<div class="flex min-h-screen flex-row">
    {{-- side panel --}}
    <div class="flex-1/5">
        <div
            class="mt-12 mb-12 ml-12 flex min-h-screen flex-col rounded bg-gray-700 shadow-lg"
        >
            <div class="flex flex-col">
                <div class="flex flex-row items-center gap-3 p-6 pb-0">
                    <x-fas-gavel class="h-5 w-5 text-blue-400" />
                    <h2 class="text-xl font-semibold text-white">
                        CASE FILING
                    </h2>
                </div>
                <div class="mt-6 flex flex-col gap-3.5 bg-gray-800 p-6">
                    <p class="font-medium text-gray-300">
                        Original Application
                    </p>
                    <p class="font-medium text-gray-300">Misc Application</p>
                    <p class="font-medium text-gray-300">Contempt Petition</p>
                    <p class="font-medium text-gray-300">Review Application</p>
                    <p class="font-medium text-gray-300">PT Filing</p>
                    <p class="font-medium text-gray-300">Document Filing</p>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="flex flex-row items-center gap-3 p-6 pb-0">
                    <x-fas-file-contract class="h-5 w-5 text-blue-400" />
                    <h2 class="text-xl font-semibold text-white">REPORTS</h2>
                </div>
                <div class="mt-6 flex flex-col gap-3.5 bg-gray-800 p-6">
                    <p class="font-medium text-gray-300">Document Report</p>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="flex flex-row items-center gap-3 p-6 pb-0">
                    <x-fas-user class="h-5 w-5 text-blue-400" />
                    <h2 class="text-xl font-semibold text-white">ACCOUNT</h2>
                </div>
                <div class="mt-6 flex flex-col gap-3.5 bg-gray-800 p-6">
                    <form
                        method="POST"
                        action="{{ route('user.auth.logout') }}"
                    >
                        @csrf
                        <button class="cursor-pointer font-medium text-red-400">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- contetnt area --}}
    <div class="flex-4/5">
        <div class="m-12 rounded-md bg-gray-100 shadow-lg">
            <div
                class="flex flex-row items-center justify-between rounded-tl rounded-tr border-b-1 border-gray-400 bg-gray-300 pt-5 pr-7 pb-5 pl-7"
            >
                <h2 class="text-3xl font-semibold text-gray-800">
                    {{ $header ? $header : 'Assam APT Dashboard' }}
                </h2>
                <p class="text-gray-800">
                    Logged in as:
                    <span class="font-semibold text-black">
                        {{ session('user') }}
                    </span>
                </p>
            </div>

            @if ($errors->any())
                <div
                    class="m-6 mb-0 rounded-sm border border-red-300 bg-red-100 px-6 py-3 text-red-600"
                >
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="{{ Request::is('user/efiling*') ? 'p-0' : 'p-7' }}">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
