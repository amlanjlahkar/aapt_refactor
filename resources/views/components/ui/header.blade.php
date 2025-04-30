<header
    class="sticky top-0 z-50 flex w-full flex-row flex-wrap justify-between border-b-1 border-gray-400 bg-gray-200 py-1 pr-4 pl-4 text-sm"
>
    <div class="flex flex-row flex-wrap space-x-4">
        <p>Government of Assam</p>
        <a href="#" class="text-blue-700 hover:underline">Old Website Link</a>
        <a href="#" class="text-blue-700 hover:underline">Get Mobile App</a>
        <a href="#" class="text-blue-700 hover:underline">
            Skip to Main Content
        </a>
        <a href="#" class="text-blue-700 hover:underline">
            Screen Reader Access
        </a>
    </div>
    <div class="flex flex-row flex-wrap space-x-4">
        <div class="flex flex-row items-center justify-center space-x-2.5">
            <button>A+</button>
            <button>A</button>
            <button>A-</button>
        </div>
        <select>
            <option value="English">English</option>
        </select>
        <a href="{{ route('login') }}" class="text-blue-700 hover:underline">
            Login
        </a>
    </div>
</header>

<a href="{{ route('home') }}" class="block">
    <div class="flex h-40 w-full items-center pl-4">
        <img
            src="{{ asset('images/aapt_logo.jpg') }}"
            alt="AAPT Logo"
            class="h-32 object-contain"
        />
        <div class="ml-4 flex flex-col">
            <h2 class="text-2xl font-bold">
                অসম প্ৰশাসনিক আৰু পেঞ্চন ন্যায়াধিকৰণ
            </h2>
            <h2 class="text-2xl font-bold">
                Assam Administrative and Pension Tribunal
            </h2>
            <h3 class="text-xl font-bold">Guwahati, Assam</h3>
        </div>
    </div>
</a>

<div class="flex h-16 w-full items-center justify-center bg-gray-800">
    <nav class="flex items-center space-x-8 text-white">
        <a
            href="#"
            class="font-medium text-gray-300 transition-colors duration-200 hover:text-blue-400"
        >
            HOME
        </a>
        <a
            href="#"
            class="font-medium text-gray-300 transition-colors duration-200 hover:text-blue-400"
        >
            ABOUT US
        </a>
        <a
            href="#"
            class="font-medium text-gray-300 transition-colors duration-200 hover:text-blue-400"
        >
            ACT & REGULATIONS
        </a>
        <a
            href="#"
            class="font-medium text-gray-300 transition-colors duration-200 hover:text-blue-400"
        >
            MEMBER
        </a>
        <a
            href="#"
            class="font-medium text-gray-300 transition-colors duration-200 hover:text-blue-400"
        >
            NOTICES
        </a>
        <a
            href="#"
            class="font-medium text-gray-300 transition-colors duration-200 hover:text-blue-400"
        >
            CASE MANAGEMENT SERVICES
        </a>
        <a
            href="#"
            class="font-medium text-gray-300 transition-colors duration-200 hover:text-blue-400"
        >
            RTI
        </a>
        <a
            href="#"
            class="font-medium text-gray-300 transition-colors duration-200 hover:text-blue-400"
        >
            FAQS
        </a>
        <a
            href="#"
            class="font-medium text-gray-300 transition-colors duration-200 hover:text-blue-400"
        >
            CONTACT US
        </a>
    </nav>
</div>
