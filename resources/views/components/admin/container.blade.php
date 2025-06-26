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
    <div class="w-64">
        <div
            class="mt-12 mb-12 ml-12 flex min-h-screen flex-col rounded bg-gray-700 shadow-lg"
        >
            <div id="navbar" class="flex flex-col">
                <div class="flex flex-row items-center gap-3 p-6 pb-0">
                    <x-fas-gavel class="h-5 w-5 text-blue-400" />
                    <h2 class="text-xl font-semibold text-white">
                        Master Modules
                    </h2>
                </div>
                <div class="mt-6 flex flex-col gap-3.5 bg-gray-800 p-6">
                    <x-nav-item
                        route="admin.dashboard"
                        url_pattern="admin/dashboard"
                    >
                        Admin User
                    </x-nav-item>
                    <!-- <a
                        href="#"
                        class="font-medium text-gray-400 hover:font-semibold hover:text-gray-50"
                    >
                        Advocates
                    </a> -->
                    <x-nav-item
                        route="admin.internal.bench_compositions.index"
                        url_pattern="admin/internal/bench_compositions"
                    >
                        Bench Composition
                    </x-nav-item>

                    <x-nav-item
                        route="admin.internal.notices.index"
                        url_pattern="admin/internal/notices*"
                    >
                        Notices
                    </x-nav-item>

                    <!-- Listing Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button
                            @click="open = !open"
                            class="flex w-full items-center justify-between px-2 py-2 font-medium text-gray-400 hover:text-white"
                        >
                            <span>Listing</span>
                            <svg
                                :class="{ 'rotate-180': open }"
                                class="h-4 w-4 transform transition-transform"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.96l3.71-3.73a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.23 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div
                            x-show="open"
                            x-cloak
                            class="ml-4 mt-2 space-y-2 pl-2 border-l border-gray-500"
                        >
                            <x-nav-item
                                route="admin.efiling.case_files.index"
                                url_pattern="admin/efiling/case_files*"
                            >
                                List Case
                            </x-nav-item>
                            <br>
                            <x-nav-item
                                route="admin.internal.causelists.index"
                                url_pattern="admin/internal/causelists*"
                            >
                                Prepare CauseList
                            </x-nav-item>
                        </div>
                    </div>
    
                    <x-nav-item
                        route="internal.case_proceeding.index"
                        url_pattern="internal/case-proceeding*"
                    >
                        Proceedings
                    </x-nav-item>
                    
                    <!-- <a
                        href="#"
                        class="font-medium text-gray-400 hover:font-semibold hover:text-gray-50"
                    >
                        Subjects
                    </a>
                    <a
                        href="#"
                        class="font-medium text-gray-400 hover:font-semibold hover:text-gray-50"
                    >
                        Purposes
                    </a>
                    <a
                        href="#"
                        class="font-medium text-gray-400 hover:font-semibold hover:text-gray-50"
                    >
                        Judges
                    </a>
                    <a
                        href="#"
                        class="font-medium text-gray-400 hover:font-semibold hover:text-gray-50"
                    >
                        Designations
                    </a>
                    <a
                        href="#"
                        class="font-medium text-gray-400 hover:font-semibold hover:text-gray-50"
                    >
                        Document Types
                    </a>
                    <a
                        href="#"
                        class="font-medium text-gray-400 hover:font-semibold hover:text-gray-50"
                    >
                        Ministries
                    </a> -->
                    <x-nav-item
                        route="admin.internal.dept.show"
                        url_pattern="admin/internal/dept*"
                    >
                        Departments
                    </x-nav-item>
                    <!-- <a
                        href="#"
                        class="font-medium text-gray-400 hover:font-semibold hover:text-gray-50"
                    >
                        Districts
                    </a>
                    <a
                        href="#"
                        class="font-medium text-gray-400 hover:font-semibold hover:text-gray-50"
                    >
                        Roles
                    </a>
                    <a
                        href="#"
                        class="font-medium text-gray-400 hover:font-semibold hover:text-gray-50"
                    >
                        Permissions
                    </a> -->
                </div>
            </div>
            <div class="flex flex-col">
                <div class="flex flex-row items-center gap-3 p-6 pb-0">
                    <x-fas-user class="h-5 w-5 text-blue-400" />
                    <h2 class="text-xl font-semibold text-white">Account</h2>
                </div>
                <div class="mt-6 flex flex-col gap-3.5 bg-gray-800 p-6">
                    <form
                        method="POST"
                        action="{{ route('admin.auth.logout') }}"
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
    <div class="flex-1 overflow-x-auto">
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
                        {{ session('admin') }}
                    </span>
                </p>
            </div>

            @if ($errors->any())
                <div
                    class="m-6 mb-0 rounded-sm border border-red-300 bg-red-100 px-6 py-3 text-red-700"
                >
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="p-7">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
