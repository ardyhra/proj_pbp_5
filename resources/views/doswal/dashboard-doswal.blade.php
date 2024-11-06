<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>SISKARA Dashboard Doswal</title>
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
                <h2 class="text-lg text-black font-bold">Ucok, S.Kom</h2>
                <p class="text-xs text-gray-800">NIDN 001</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Dosen</p>
                <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
            </div>
            <nav class="space-y-4">
                <a href="{{ url('/dashboard-doswal') }}"
                   class="flex items-center space-x-2 p-2 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">
                    <span>Dashboard</span>
                </a>
                <a href="{{ url('/persetujuanIRS-doswal') }}"
                   class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                    <span>Persetujuan IRS</span>
                </a>
                <a href="{{ url('/rekap-doswal') }}"
                   class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                    <span>Rekap Mahasiswa</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-full lg:w-4/5 lg:ml-auto p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-5xl font-bold">Overview</h1>
                <div class="relative">
                    <input type="text" placeholder="Search"
                           class="pl-4 pr-10 py-2 rounded-full bg-gray-200 text-gray-700 focus:outline-none">
                    <svg class="absolute right-3 top-2 w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M12.9 14.32A8 8 0 112 8a8 8 0 0110.9 6.32l5.4 5.38-1.5 1.5-5.4-5.38zM8 14a6 6 0 100-12 6 6 0 000 12z"
                              clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>

            <!-- Year Info -->
            <div class="mb-6">
                <div class="p-4 bg-gray-200 rounded-lg text-gray-700">
                    <p class="text-lg">Tahun Ajaran</p>
                    <p class="text-2xl font-semibold">2024/2025 Ganjil</p>
                </div>
            </div>

            <!-- Statistics -->
            <button class="p-6 w-full bg-gray-300 rounded-lg text-center hover:bg-gray-400 hover:text-white active:bg-opacity-80">
                <p class="text-lg">Total Mahasiswa Perwalian</p>
                <p class="text-4xl font-bold">50</p>
            </button>
            <div class="grid grid-cols-3 gap-4 mt-4">
                <button class="p-6 bg-gray-300 rounded-lg text-center hover:bg-gray-400 hover:text-white active:bg-opacity-80">
                    <p class="text-lg">Belum mengumpulkan IRS</p>
                    <p class="text-4xl font-bold">10</p>
                </button>
                <button class="p-6 bg-gray-300 rounded-lg text-center hover:bg-gray-400 hover:text-white active:bg-opacity-80">
                    <p class="text-lg">IRS belum disetujui</p>
                    <p class="text-4xl font-bold">17</p>
                </button>
                <button class="p-6 bg-gray-300 rounded-lg text-center hover:bg-gray-400 hover:text-white active:bg-opacity-80">
                    <p class="text-lg">IRS Disetujui</p>
                    <p class="text-4xl font-bold">23</p>
                </button>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4 absolute w-full">
        <hr>
        <p class="text-sm text-center">&copy; Siskara Inc. All rights reserved.</p>
    </footer>

    <!-- Script untuk toggle sidebar -->
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('sidebar-closed');
        }
    </script>

</body>

</html>
