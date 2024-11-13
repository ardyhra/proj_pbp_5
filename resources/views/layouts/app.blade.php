<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SISKARA')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Assumes Tailwind CSS is compiled here -->
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-blue-500">SISKARA</a>
            <div class="flex items-center space-x-4">
                <a href="#" class="text-gray-700">Home</a>
                <a href="#" class="text-gray-700">About</a>
                <a href="#" class="text-gray-700">Profile</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mx-auto flex mt-6">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-gray-100 text-center py-4 mt-8 text-gray-600 text-sm">
        <p>©2024 SISKARA</p>
        <p>Don't Forget Follow Diponegoro University Social Media!</p>
    </footer>

</body>
</html>
