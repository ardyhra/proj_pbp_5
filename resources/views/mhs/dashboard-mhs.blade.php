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

        /* Sidebar terbuka */
        .sidebar-open {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    @php
        $menus = [
            (object) [
                "title" => "Dasboard",
                "path" => "dashboard-mhs",
            ],
            (object) [
                "title" => "Persetujuan IRS",
                "path" => "pengisianirs-mhs",
            ],
            (object) [
                "title" => "Rekap Mahasiswa",
                "path" => "irs-mhs",
            ],
            (object) [
                "title" => "KHS",
                "path" => "dashboard-mhs",
            ]

        ];
    @endphp
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
                     style="background-image: url(img/fsm.jpg)"></div>
                <h2 class="text-lg text-black font-bold">Budi</h2>
                <p class="text-xs text-gray-800">NIM 24060122120033</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Mahasiswa</p>
                <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
            </div>
            <nav class="space-y-4">
                {{-- active : bg-sky-800 rounded-xl text-white hover:bg-opacity-70 --}}
                {{-- passive : bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white --}}
                @foreach ($menus as $menu)
                <a href="{{ url($menu->path) }}"
                   class="flex items-center space-x-2 p-2 {{ Str::startsWith(request()->path(), $menu->path) ? 'bg-sky-800 rounded-xl text-white hover:bg-opacity-70' : 'bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white' }}">
                    <span>{{$menu->title}}</span>
                </a>
                @endforeach
                <!-- <a href="{{ url('/dashboard-mhs') }}"
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
                <a href="{{ url('/dashboard-mhs') }}"
                   class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                    <span>KHS</span>
                </a> -->
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-full lg:w-8/5 lg:ml-auto p-8">
            <div class="grid grid-cols-3 gap-4 p-4 bg-white rounded-lg">
                <!-- Status Akademik -->
                <div class="col-span-1">
                    <h3 class="text-2xl font-bold mb-2">Status Akademik</h3>
                    <p>Dosen Wali: Adit Saputra, S.Kom, M.Kom (NIP: 122341431414143415)</p>
                    <p>Semester Akademik Sekarang: 2024/2025 Ganjil</p>
                    <p>Semester Studi: 4</p>
                    <p>Status: Aktif</p>
                </div>

                <!-- Prestasi Akademik - IPK -->
                <div class="col-span-1 flex flex-col justify-center items-center p-4 bg-gray-300 rounded-lg text-center h-32">
                    <h3 class="text-lg font-semibold">IPK</h3>
                    <p class="text-4xl font-bold">3.76</p>
                </div>

                <!-- Prestasi Akademik - SKS -->
                <div class="col-span-1 flex flex-col justify-center items-center p-4 bg-gray-300 rounded-lg text-center h-32">
                    <h3 class="text-lg font-semibold">SKSk</h3>
                    <p class="text-4xl font-bold">85</p>
                </div>
            </div> 

            <!-- Informasi Perubahan Jadwal -->
            <div class="mt-6 p-4 bg-white rounded-lg shadow-lg">
                <div>
                    <h3 class="text-2xl font-bold mb-2">Riwayat Status</h3>
                </div>
                <table class="w-full bg-white rounded-lg overflow-hidden shadow-lg">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-2 px-4 text-center w-8">No</th>
                            <th class="py-2 px-4 text-center">Tahun Ajaran</th>
                            <th class="py-2 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-2 px-4 text-center w-8">1</td>
                            <td class="py-2 px-4 text-center">2022/2023 Ganjil</td>
                            <td class="py-2 px-4 text-center">AKTIF</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 px-4 text-center w-8">2</td>
                            <td class="py-2 px-4 text-center">2022/2023 Genap</td>
                            <td class="py-2 px-4 text-center">AKTIF</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 px-4 text-center w-8">3</td>
                            <td class="py-2 px-4 text-center">2023/2024 Ganjil</td>
                            <td class="py-2 px-4 text-center">AKTIF</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 px-4 text-center w-8">4</td>
                            <td class="py-2 px-4 text-center">2023/2024 Genap</td>
                            <td class="py-2 px-4 text-center">CUTI</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 px-4 text-center w-8">5</td>
                            <td class="py-2 px-4 text-center">2024/2025 Ganjil</td>
                            <td class="py-2 px-4 text-center">AKTIF</td>
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
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-open');
            sidebar.classList.toggle('sidebar-closed');
        }
    </script>
</body>
</html>
