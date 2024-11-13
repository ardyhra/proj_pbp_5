<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKARA - Dashboard Kaprodi</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animation for sidebar */
        .sidebar {
            transition: transform 0.3s ease;
        }

        .sidebar-closed {
            transform: translateX(-100%);
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <header class="bg-gradient-to-r from-sky-500 to-blue-600 text-white p-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <!-- Menu button to open sidebar -->
            <button onclick="toggleSidebar()" class="focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <!-- App logo and title -->
            <h1 class="text-xl font-bold">SISKARA</h1>
        </div>
        <!-- DIBUAT? -->
        <nav class="space-x-4">
            <a href="{{ url('/') }}" class="hover:underline">Home</a>
            <a href="{{ url('/about') }}" class="hover:underline">About</a>
            <a href="{{ url('/profile') }}" class="hover:underline">Profile</a>
        </nav>
    </header>

    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar w-1/5 bg-sky-500 h-screen p-4 text-white sidebar-closed fixed lg:static">
            <!-- Profile -->
            <div class="p-3 bg-gray-300 rounded-3xl text-center mb-6">
                <div class="w-24 h-24 mx-auto bg-gray-400 rounded-full mb-3"></div>
                <h2 class="text-lg text-black font-bold">Adit Saputra, S.Kom</h2>
                <p class="text-xs text-gray-800">NIP: 123431431431415</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Kaprodi</p>
                <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
            </div>
            {{-- <nav class="space-y-4">
                <a href="/dashboard-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('dashboard') ?  'bg-sky-800 rounded-x1':'bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white' }}">Dashboard</a>
                <a href="/manajemen-jadwal-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('manajemen-jadwal') ?'bg-sky-800 rounded-x1' : 'text-white hover:bg-opacity-70' }}">Manajemen Jadwal</a>
                <a href="/monitoring-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('monitoring') ?'bg-sky-800 rounded-x1': 'bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white' }}">Monitoring</a>
                <a href="/konsultasi-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('konsultasi') ? 'bg-sky-800 rounded-x1':'bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white' }}">Konsultasi</a>
            </nav> --}}
            <nav class="space-y-4">
                <a href="/dashboard-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('dashboard-kaprodi') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">Dashboard</a>
                <a href="/manajemen-jadwal-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('manajemen-jadwal-kaprodi') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">Manajemen Jadwal</a>
                <a href="/monitoring-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('monitoring-kaprodi') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">Monitoring</a>
                <a href="/konsultasi-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('konsultasi-kaprodi') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">Konsultasi</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-full lg:w-4/5 lg:ml-auto p-8">
            <!-- Page Title -->
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

            <!-- Academic Year Section -->
            <section class="bg-gray-200 p-6 rounded-lg mb-6">
                <h2 class="text-xl font-semibold mb-2">Tahun Ajaran</h2>
                <p class="text-2xl font-bold">2024/2025 Ganjil</p>
            </section>

            <!-- Stats Section -->
            <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="p-6 bg-gray-300 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">Jumlah Ruang</h3>
                    <p class="text-4xl font-bold">15</p>
                </div>
                <div class="p-6 bg-gray-300 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">Jumlah Dosen</h3>
                    <p class="text-4xl font-bold">30</p>
                </div>
                <div class="p-6 bg-gray-300 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">Jumlah Mata Kuliah</h3>
                    <p class="text-4xl font-bold">40</p>
                </div>
            </section>

            <!-- Graphs Section -->
            <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 bg-gray-200 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-center">Jumlah Mahasiswa</h3>
                    <img src="img/bar-chart-placeholder.png" alt="Bar Chart" class="w-full h-48">
                </div>
                <div class="p-6 bg-gray-200 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-center">Status Penyusunan Mata Kuliah</h3>
                    <img src="img/donut-chart-placeholder.png" alt="Donut Chart" class="w-full h-48">
                </div>
            </section>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4 w-full mt-6">
        <hr class="mb-2">
        <p class="text-sm">&copy;2024 SISKARA</p>
        <p class="text-xs">Don't Forget Follow Diponegoro University Social Media!</p>
    </footer>

    <!-- Script -->
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('sidebar-closed');
        }
    </script>

</body>
</html>
