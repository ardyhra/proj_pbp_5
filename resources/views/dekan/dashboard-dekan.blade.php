<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKARA - Dashboard Dekan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animasi untuk sidebar */
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
            <!-- Tombol menu untuk membuka sidebar -->
            <button onclick="toggleSidebar()" class="focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <!-- Logo dan judul aplikasi -->
            <h1 class="text-xl font-bold">SISKARA</h1>
        </div>
        <nav class="space-x-4">
            <a href="{{ url('/') }}" class="hover:underline">Home</a>
            <a href="{{ url('/about') }}" class="hover:underline">About</a>
        </nav>
    </header>

    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar w-1/5 bg-sky-500 h-screen p-4 text-white sidebar-closed fixed lg:static">
            <!-- profil -->
            <div class="p-3 pb-1 bg-gray-300 rounded-3xl text-center mb-6">
                <div class="w-24 h-24 mx-auto bg-gray-400 rounded-full mb-3 bg-center bg-contain bg-no-repeat"
                     style="background-image: url(img/fsm.jpg)">
                </div>
                <h2 class="text-lg text-black font-bold">Budi, S.Kom</h2>
                <p class="text-xs text-gray-800">NIP 123431431431415</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Dekan</p>
                <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
            </div>
            <nav class="space-y-4">
                <a href="/dashboard-dekan" class="block py-2 px-3 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">Dashboard</a>
                <a href="/usulanruang" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Usulan Ruang Kuliah</a>
                <a href="/usulanjadwal" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Usulan Jadwal Kuliah</a>
                <a href="/aturgelombang" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Atur Gelombang IRS</a>
                <!-- Tombol Switch Role -->
                @if(Auth::user()->pembimbing_akademik)
                <div class="mt-6">
                    <a href="{{ route('switch.role') }}" class="flex items-center justify-center space-x-2 p-2 bg-green-500 rounded-xl text-white hover:bg-green-600">
                        <span>Switch Role</span>
                    </a>
                </div>
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-full lg:w-4/5 lg:ml-auto p-8">
            <!-- Judul Halaman -->
            <h1 class="text-3xl font-bold mb-6">Dashboard Dekan</h1>

            <!-- Academic Year Section -->
            <section class="bg-gray-200 p-6 rounded-lg mb-6">
                <h2 class="text-xl font-semibold mb-2">Tahun Ajaran</h2>
                <p class="text-2xl font-bold">2024/2025 Ganjil</p>
            </section>

            <!-- Stats Section -->
            <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="p-6 bg-gray-300 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">Status Usulan Ruang Kuliah</h3>
                    <p class="text-xl font-bold">Menunggu Persetujuan</p>
                </div>
                <div class="p-6 bg-gray-300 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">Jumlah Usulan Ruang</h3>
                    <p class="text-4xl font-bold">2</p>
                </div>
                <div class="p-6 bg-gray-300 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">Status Usulan Jadwal Kuliah</h3>
                    <p class="text-xl font-bold">Sudah Disetujui</p>
                </div>
                <div class="p-6 bg-gray-300 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">Jumlah Usulan Jadwal</h3>
                    <p class="text-4xl font-bold">1</p>
                </div>
            </section>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4 absolute w-full">
        <hr>
        <p class="text-sm text-center">&copy; Siskara Inc. All rights reserved.</p>
    </footer>

    <!-- Script -->
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('sidebar-closed');
        }
    </script>

</body>
</html>
