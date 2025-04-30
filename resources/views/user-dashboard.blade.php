<x-ui.layout title="User Dashboard">
    <x-ui.header />
    <main
        class="bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <x-ui.dashboard.user.content header='Welcome to Assam APT Dashboard'>
            <div class="p-7">
                <div
                    class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4"
                >
                    <div class="rounded bg-blue-700 p-6 text-center shadow-sm">
                        <h3 class="mb-2 text-lg font-semibold text-gray-200">
                            Total No. of Draft Cases
                        </h3>
                        <p class="mb-4 text-3xl font-bold text-blue-300">24</p>
                        <a href="#" class="text-sm text-white hover:underline">
                            View Details
                        </a>
                    </div>

                    <div
                        class="rounded bg-yellow-700 p-6 text-center shadow-sm"
                    >
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

                    <div
                        class="rounded bg-orange-700 p-6 text-center shadow-sm"
                    >
                        <h3 class="mb-2 text-lg font-semibold text-gray-200">
                            Total No. of Defective Cases
                        </h3>
                        <p class="mb-4 text-3xl font-bold text-red-300">12</p>
                        <a href="#" class="text-sm text-white hover:underline">
                            View Details
                        </a>
                    </div>

                    <div class="rounded bg-green-700 p-6 text-center shadow-sm">
                        <h3 class="mb-2 text-lg font-semibold text-gray-200">
                            Today's Filed Cases
                        </h3>
                        <p class="mb-4 text-3xl font-bold text-green-300">8</p>
                        <a href="#" class="text-sm text-white hover:underline">
                            View Details
                        </a>
                    </div>
                </div>
            </div>

            <div class="pr-7 pb-7 pl-7">
                <div
                    class="grid grid-cols-1 gap-6 md:grid-cols-1 lg:grid-cols-3"
                >
                    <div
                        class="cursor-pointer rounded border-1 border-transparent bg-white p-4 text-center shadow-sm hover:border-gray-400 hover:bg-gray-300"
                    >
                        <p class="font-medium text-gray-700">
                            Check Case Status
                        </p>
                    </div>
                    <div
                        class="cursor-pointer rounded border-1 border-transparent bg-white p-4 text-center shadow-sm hover:border-gray-400 hover:bg-gray-300"
                    >
                        <p class="font-medium text-gray-700">Edit Profile</p>
                    </div>
                    <div
                        class="cursor-pointer rounded border-1 border-transparent bg-white p-4 text-center shadow-sm hover:border-gray-400 hover:bg-gray-300"
                    >
                        <p class="font-medium text-gray-700">New Case Filing</p>
                    </div>
                </div>
            </div>
        </x-ui.dashboard.user.content>
    </main>
    <x-ui.footer />
</x-ui.layout>
