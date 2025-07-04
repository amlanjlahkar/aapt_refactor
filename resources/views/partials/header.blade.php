<header
    class="top-0 z-50 flex w-full flex-row flex-wrap justify-between border-t border-b border-blue-200 bg-blue-50 py-2 pr-12 pl-12 text-sm"
>
    <div class="flex flex-row flex-wrap items-center gap-4">
        <img
            src="{{ asset('images/india_flag.png') }}"
            alt="National Flag"
            class="h-4 object-contain"
        />
        <div class="flex flex-row items-center space-x-2">
            <p class="font-noto-assamese mt-1">অসম চৰকাৰ</p>
            <p>Government of Assam</p>
        </div>
        <a href="#" class="text-blue-700 hover:underline">Old Website Link</a>
        <a href="#" class="text-blue-700 hover:underline">Get Mobile App</a>
        <a href="#" class="text-blue-700 hover:underline">
            Skip to Main Content
        </a>
        <a href="#" class="text-blue-700 hover:underline">
            Screen Reader Access
        </a>
    </div>
    <div class="flex flex-row flex-wrap items-center gap-4">
        <div class="flex flex-row items-center justify-center space-x-2.5">
            <button>A+</button>
            <button>A</button>
            <button>A-</button>
        </div>
        <select>
            <option value="English">English</option>
        </select>
        <a href="{{ route('login') }}">
            <div
                class="flex items-center gap-1.5 rounded-sm bg-gray-800 px-3 py-2 font-medium text-gray-300 shadow-sm"
            >
                @if (! Request::is('user*', 'admin*'))
                    <x-fas-arrow-right-to-bracket class="h-3.5 w-3.5" />
                    <p class="text-sm">Login</p>
                @else
                    <x-fas-arrow-right-from-bracket class="h-3.5 w-3.5" />
                    <p class="text-sm">Logout</p>
                @endif
            </div>
        </a>
    </div>
</header>

<div
    class="flex h-40 w-full items-center justify-between gap-3 border-b border-gray-300 pr-12 pl-12"
>
    <a href="{{ route('home') }}" class="block">
        <div class="mx-0 flex flex-row items-center">
            <img
                src="{{ asset('images/aapt_logo.png') }}"
                alt="AAPT Logo"
                class="h-24 object-contain"
            />
            <div class="ml-4 flex flex-col">
                <h2 class="font-noto-assamese text-xl font-medium">
                    অসম প্ৰশাসনিক আৰু পেঞ্চন ন্যায়াধিকৰণ
                </h2>
                <h2 class="text-xl font-semibold">
                    Assam Administrative and Pension Tribunal
                </h2>
                <h3 class="text-xl font-medium">Guwahati, Assam</h3>
            </div>
        </div>
    </a>

    <img
        src="{{ asset('images/india_emblem.png') }}"
        alt="AAPT Logo"
        class="h-24 object-contain"
    />
</div>
