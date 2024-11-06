<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Dashboard Mahasiswa</title>
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
                <h2 class="text-lg text-black font-bold">Budi</h2>
                <p class="text-xs text-gray-800">NIM 24060122120033</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Mahasiswa</p>
                <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
            </div>
            <nav class="space-y-4">
                <a href="{{ url('/dashboard-mhs') }}"
                   class="flex items-center space-x-2 p-2 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">
                    <span>Dashboard</span>
                </a>
                <a href="{{ url('/pengisianirs-mhs') }}"
                   class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                    <span>Pengisian IRS</span>
                </a>
                <a href="{{ url('/irs-mhs') }}"
                   class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                    <span>IRS</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-full lg:w-4/5 lg:ml-auto p-8">
            <!-- Status Akademik -->
            <div class="mb-6">
                <h3 class="text-2xl font-bold mb-2">Status Akademik</h3>
                <p>Dosen Wali: Adit Saputra, S.Kom, M.Kom (NIP: 122341431414143415)</p>
                <p>Semester Akademik Sekarang: 2024/2025 Ganjil</p>
                <p>Semester Studi: 4</p>
                <p>Status: -</p>
            </div>

            <!-- Prestasi Akademik -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="p-4 bg-gray-300 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">IPK</h3>
                    <p class="text-4xl font-bold">3.81</p>
                </div>
                <div class="p-4 bg-gray-300 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">SKS</h3>
                    <p class="text-4xl font-bold">85</p>
                </div>
            </div>

            <!-- Informasi Perubahan Jadwal -->
            <div class="mb-6">
                <h3 class="text-2xl font-bold mb-2">Informasi Perubahan Jadwal Mata Kuliah</h3>
                <table class="w-full bg-white rounded-lg overflow-hidden shadow-lg">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-2 px-4 text-left">No</th>
                            <th class="py-2 px-4 text-left">Mata Kuliah</th>
                            <th class="py-2 px-4 text-left">Pertemuan</th>
                            <th class="py-2 px-4 text-left">Jadwal Pengganti</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-2 px-4">1</td>
                            <td class="py-2 px-4">Teori Bahasa dan Otomata</td>
                            <td class="py-2 px-4">2</td>
                            <td class="py-2 px-4">Jumat, 30 Agustus 2024, 15:30 - 18:50, A103</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Jadwal Kuliah -->
            <div class="mb-6">
                <h3 class="text-2xl font-bold mb-2">Jadwal Kuliah - September 2024</h3>
                <table class="w-full bg-white rounded-lg overflow-hidden shadow-lg">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-2 px-4 text-left">Senin</th>
                            <th class="py-2 px-4 text-left">Selasa</th>
                            <th class="py-2 px-4 text-left">Rabu</th>
                            <th class="py-2 px-4 text-left">Kamis</th>
                            <th class="py-2 px-4 text-left">Jumat</th>
                            <th class="py-2 px-4 text-left">Sabtu</th>
                            <th class="py-2 px-4 text-left">Minggu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-2 px-4">13:00 Teori Bah...</td>
                            <td class="py-2 px-4">09:40 Pembelaj...</td>
                            <td class="py-2 px-4">09:40 Pembelaj...</td>
                            <td class="py-2 px-4">15:40 Komputas...</td>
                            <td class="py-2 px-4">07:00 Sistem In...</td>
                            <td class="py-2 px-4"></td>
                            <td class="py-2 px-4"></td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">13:00 Teori Bah...</td>
                            <td class="py-2 px-4">09:40 Pembelaj...</td>
                            <td class="py-2 px-4">09:40 Pembelaj...</td>
                            <td class="py-2 px-4">15:40 Komputas...</td>
                            <td class="py-2 px-4">07:00 Sistem In...</td>
                            <td class="py-2 px-4"></td>
                            <td class="py-2 px-4"></td>
                        </tr>
                    </tbody>
                </table>
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
