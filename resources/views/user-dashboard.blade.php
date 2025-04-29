<x-ui.layout title="User Dashboard">
    <x-ui.header />
    <main class="bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        ">
        <div class="flex min-h-screen flex-row">
            {{-- side panel --}}
            <div class="flex-1/5">
                <div class="m-5 flex min-h-screen flex-col rounded bg-gray-700 shadow-lg">
                    <div class="flex flex-col">
                        <div class="flex flex-row gap-3 p-6 pb-0 items-center">
                            <x-fas-gavel class="w-5 h-5 text-blue-400" />
                            <h2 class="text-xl font-semibold text-white">
                                CASE FILING
                            </h2>
                        </div>
                        <div class="flex flex-col p-6 mt-6 bg-gray-800 gap-3.5">
                            <p class="font-medium text-gray-300">
                                Original Application
                            </p>
                            <p class="font-medium text-gray-300">
                                Misc Application
                            </p>
                            <p class="font-medium text-gray-300">
                                Contempt Petition
                            </p>
                            <p class="font-medium text-gray-300">
                                Review Application
                            </p>
                            <p class="font-medium text-gray-300">PT Filing</p>
                            <p class="font-medium text-gray-300">
                                Document Filing
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex flex-row gap-3 p-6 pb-0 items-center">
                            <x-fas-file-contract class="w-5 h-5 text-blue-400" />
                            <h2 class="text-xl font-semibold text-white">
                                REPORTS
                            </h2>
                        </div>
                        <div class="flex flex-col p-6 mt-6 bg-gray-800 gap-3.5">
                            <p class="font-medium text-gray-300">
                                Document Report
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex flex-row gap-3 p-6 pb-0 items-center">
                            <x-fas-user class="w-5 h-5 text-blue-400" />
                            <h2 class="text-xl font-semibold text-white">
                                ACCOUNT
                            </h2>
                        </div>
                        <div class="flex flex-col p-6 mt-6 bg-gray-800 gap-3.5">
                            <p class="font-medium text-red-400">Logout</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-4/5">
                {{-- contetnt area --}}
                <div class="m-5 rounded bg-gray-100 shadow-lg">
                    <div
                        class="flex flex-row items-center justify-between rounded-tl rounded-tr border-b-1 border-gray-400 bg-gray-300 pt-5 pr-7 pb-5 pl-7">
                        <h2 class="text-3xl font-semibold text-gray-800">
                            Welcome to Assam APT Dashboard
                        </h2>
                        <p class="text-xl text-gray-800">
                            Username:
                            <span class="font-semibold text-cyan-800">
                                Unknown
                            </span>
                        </p>
                    </div>

                    <div class="p-7">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                            <div class="rounded bg-blue-700 p-6 text-center shadow-sm">
                                <h3 class="mb-2 text-lg font-semibold text-gray-200">
                                    Total No. of Draft Cases
                                </h3>
                                <p class="mb-4 text-3xl font-bold text-blue-300">
                                    24
                                </p>
                                <a href="#" class="text-sm text-white hover:underline">
                                    View Details
                                </a>
                            </div>

                            <div class="rounded bg-yellow-700 p-6 text-center shadow-sm">
                                <h3 class="mb-2 text-lg font-semibold text-gray-100">
                                    Total No. of Pending Cases
                                </h3>
                                <p class="mb-4 text-3xl font-bold text-yellow-400">
                                    156
                                </p>
                                <a href="#" class="text-sm text-white hover:underline">
                                    View Details
                                </a>
                            </div>

                            <div class="rounded bg-orange-700 p-6 text-center shadow-sm">
                                <h3 class="mb-2 text-lg font-semibold text-gray-200">
                                    Total No. of Defective Cases
                                </h3>
                                <p class="mb-4 text-3xl font-bold text-red-300">
                                    12
                                </p>
                                <a href="#" class="text-sm text-white hover:underline">
                                    View Details
                                </a>
                            </div>

                            <div class="rounded bg-green-700 p-6 text-center shadow-sm">
                                <h3 class="mb-2 text-lg font-semibold text-gray-200">
                                    Today's Filed Cases
                                </h3>
                                <p class="mb-4 text-3xl font-bold text-green-300">
                                    8
                                </p>
                                <a href="#" class="text-sm text-white hover:underline">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="pr-7 pb-7 pl-7">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-1 lg:grid-cols-3">
                            <div
                                class="rounded border-1 border-transparent bg-white p-4 text-center shadow-sm hover:border-black">
                                <p class="font-medium text-gray-700">
                                    Check Case Status
                                </p>
                            </div>
                            <div
                                class="rounded border-1 border-transparent bg-white p-4 text-center shadow-sm hover:border-black">
                                <p class="font-medium text-gray-700">
                                    Edit Profile
                                </p>
                            </div>
                            <div
                                class="rounded border-1 border-transparent bg-white p-4 text-center shadow-sm hover:border-black">
                                <p class="font-medium text-gray-700">
                                    New Case Filing
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-ui.footer />
</x-ui.layout>
