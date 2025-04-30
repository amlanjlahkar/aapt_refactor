@props([
    'header' => null,
])

<div class="flex min-h-screen flex-row">
    {{-- side panel --}}
    <div class="flex-1/5">
        <div class="m-5 flex min-h-screen flex-col rounded bg-gray-700 shadow-lg">
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
                    <p class="font-medium text-red-400">Logout</p>
                </div>
            </div>
        </div>
    </div>

    {{-- contetnt area --}}
    <div class="flex-4/5">
        <div class="m-5 rounded bg-gray-100 shadow-lg">
            <div
                class="flex flex-row items-center justify-between rounded-tl rounded-tr border-b-1 border-gray-400 bg-gray-300 pt-5 pr-7 pb-5 pl-7">
                <h2 class="text-3xl font-semibold text-gray-800">
                    {{ $header ? $header : 'Assam APT Dashboard' }}
                </h2>
                <p class="text-xl text-gray-800">
                    Logged in as:
                    <span class="font-semibold text-cyan-800">{{ session('user') }}</span>
                </p>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
