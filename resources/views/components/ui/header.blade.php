<header
    class="sticky top-0 z-50 flex flex-row flex-wrap justify-between w-full py-1 text-sm bg-gray-200 border-b-1 border-gray-400 pl-4 pr-4">
    <div class="flex flex-row flex-wrap space-x-4">
        <p>Government of Assam</p>
        <a href="#" class="text-blue-700 hover:underline">Old Website Link</a>
        <a href="#" class="text-blue-700 hover:underline">Get Mobile App</a>
        <a href="#" class="text-blue-700 hover:underline">Skip to Main Content</a>
        <a href="#" class="text-blue-700 hover:underline">Screen Reader Access</a>
    </div>
    <div class="flex flex-row flex-wrap space-x-4">
        <div class="flex flex-row justify-center items-center space-x-2.5">
            <button>A+</button>
            <button>A</button>
            <button>A-</button>
        </div>
        <select>
            <option value="English">English</option>
        </select>
        <a href={{ route('login.show') }} class="text-blue-700 hover:underline">Login</a>
    </div>
</header>

<a href="{{ route('home') }}" class="block">
    <div class="h-40 flex items-center w-full pl-4">
        <img src="{{ asset('images/aapt_logo.jpg') }}" alt="AAPT Logo" class="h-32 object-contain">
        <div class="flex flex-col ml-4">
            <h2 class="text-2xl font-bold">অসম প্ৰশাসনিক আৰু পেঞ্চন ন্যায়াধিকৰণ </h2>
            <h2 class="text-2xl font-bold">Assam Administrative and Pension Tribunal</h2>
            <h3 class="text-xl font-bold">Guwahati, Assam</h3>
        </div>
    </div>
</a>

<div class="w-full h-16 bg-blue-700 flex items-center justify-center">
    <nav class="flex items-center space-x-8 text-white">
        <a href="#" class="hover:text-blue-200 transition-colors duration-200">HOME</a>
        <a href="#" class="hover:text-blue-200 transition-colors duration-200">ABOUT US</a>
        <a href="#" class="hover:text-blue-200 transition-colors duration-200">ACT & REGULATIONS</a>
        <a href="#" class="hover:text-blue-200 transition-colors duration-200">MEMBER</a>
        <a href="#" class="hover:text-blue-200 transition-colors duration-200">NOTICES</a>
        <a href="#" class="hover:text-blue-200 transition-colors duration-200">CASE MANAGEMENT SERVICES</a>
        <a href="#" class="hover:text-blue-200 transition-colors duration-200">RTI</a>
        <a href="#" class="hover:text-blue-200 transition-colors duration-200">FAQS</a>
        <a href="#" class="hover:text-blue-200 transition-colors duration-200">CONTACT US</a>
    </nav>
</div>
