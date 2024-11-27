<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Pastikan Vite sudah diatur -->
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        @include('components.sidebar') <!-- Sidebar disisipkan di sini -->

        <!-- Main Content -->
        <div class="w-3/4">
            @yield('content') <!-- Konten halaman -->
        </div>
    </div>
</body>
</html>


