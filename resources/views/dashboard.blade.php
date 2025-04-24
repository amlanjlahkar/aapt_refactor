<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - AAPT</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-gray-100">
    <x-ui.header />

    <div class="flex min-h-[calc(100vh-200px)]">
        <!-- Left Panel -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4 border-b border-gray-300">
                <h2 class="text-2xl font-bold text-gray-800">User Panel</h2>
            </div>
            <nav class="mt-4">
                <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                    Case Filing
                </a>
                <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                    Reports
                </a>
                <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                    Account
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <div class="p-4 border-b border-gray-300">
                <h1 class="text-2xl font-bold text-gray-800 pl-4">Welcome to AAPT Dashboard</h1>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1 -->
                    <div class="bg-white rounded shadow-sm p-6 text-center">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Total No. of Draft Cases</h3>
                        <p class="text-3xl font-bold text-gray-900 mb-4">24</p>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">View Details</a>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded shadow-sm p-6 text-center">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Total No. of Pending Cases</h3>
                        <p class="text-3xl font-bold text-gray-900 mb-4">156</p>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">View Details</a>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded shadow-sm p-6 text-center">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Total No. of Defective Cases</h3>
                        <p class="text-3xl font-bold text-gray-900 mb-4">12</p>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">View Details</a>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white rounded shadow-sm p-6 text-center">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Today's Filed Cases</h3>
                        <p class="text-3xl font-bold text-gray-900 mb-4">8</p>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-ui.footer />
</body>
</html> 