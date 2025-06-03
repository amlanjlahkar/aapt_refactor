<x-layout title="User Dashboard">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <x-user.container header="Welcome to Assam APT Dashboard">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded bg-blue-700 p-6 text-center shadow-sm">
                    <h3 class="mb-2 text-lg font-semibold text-gray-200">
                        Total No. of Draft Cases
                    </h3>
                    <p class="mb-4 text-3xl font-bold text-blue-300">
                        {{ $case['draft_count'] }}
                    </p>
                    <a
                        href="{{ route('user.cases.draft') }}"
                        class="text-sm text-white hover:underline"
                    >
                        View Details
                    </a>
                </div>

                <div class="rounded bg-yellow-700 p-6 text-center shadow-sm">
                    <h3 class="mb-2 text-lg font-semibold text-gray-100">
                        Total No. of Pending Cases
                    </h3>
                    <p class="mb-4 text-3xl font-bold text-yellow-400">
                        {{ $case['pending_count'] }}
                    </p>
                    <a
                        href="{{ route('user.cases.pending') }}"
                        class="text-sm text-white hover:underline"
                    >
                        View Details
                    </a>
                </div>

                <div class="rounded bg-orange-700 p-6 text-center shadow-sm">
                    <h3 class="mb-2 text-lg font-semibold text-gray-200">
                        Total No. of Defective Cases
                    </h3>
                    <p class="mb-4 text-3xl font-bold text-red-300">
                        {{ $case['defective_count'] }}
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
                        {{ $case['today_count'] }}
                    </p>
                    <a href="#" class="text-sm text-white hover:underline">
                        View Details
                    </a>
                </div>
            </div>

            <div
                class="mt-7 grid grid-cols-1 gap-6 md:grid-cols-1 lg:grid-cols-3"
            >
                <a href="{{ route('user.check_case_status') }}">
                    <div
                        class="cursor-pointer rounded border-1 border-transparent bg-white p-4 text-center shadow-sm hover:border-gray-400 hover:bg-gray-300"
                    >
                        <p class="font-medium text-gray-700">
                            Check Case Status
                        </p>
                    </div>
                </a>
                <div
                    class="cursor-pointer rounded border-1 border-transparent bg-white p-4 text-center shadow-sm hover:border-gray-400 hover:bg-gray-300"
                >
                    <p class="font-medium text-gray-700">Edit Profile</p>
                </div>
                <a
                    href="{{ route('user.efiling.register.step1.create', ['step' => 1]) }}"
                >
                    <div
                        class="cursor-pointer rounded border-1 border-transparent bg-white p-4 text-center shadow-sm hover:border-gray-400 hover:bg-gray-300"
                    >
                        <p class="font-medium text-gray-700">New Case Filing</p>
                    </div>
                </a>
            </div>
        </x-user.container>
    </main>
    @include('partials.footer')
</x-layout>
