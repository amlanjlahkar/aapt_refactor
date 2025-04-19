<header
    class="flex flex-row flex-wrap justify-between w-full py-1 text-sm bg-gray-200 border-b-1 border-gray-400 pl-4 pr-4">
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
        <a href={{ route("login.show") }} class="text-blue-700 hover:underline">Login</a>
    </div>
</header>
