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

        /* Memastikan sidebar dan konten utama memenuhi tinggi layar */
        .flex-container {
            min-height: 100vh;
        }

        /* State normal (sidebar terbuka) */
        #main-content {
            transition: width 0.3s ease, margin-left 0.3s ease;
            /* width sudah diatur oleh utility classes tailwind (w-full lg:w-4/5) */
        }

        /* Ketika sidebar ditutup, buat main-content memenuhi lebar penuh */
        .sidebar-closed ~ #main-content {
            width: 100% !important;
            margin-left: 0 !important;
        }

        /* Konten Utama */
        .card {
            background-color: white;
            border: 1px solid #e2e2e2;
            border-radius: 0.5rem;
            padding: 1rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <header class="bg-gradient-to-r from-sky-500 to-blue-600 text-white p-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <!-- Tombol menu untuk membuka sidebar -->
            <button onclick="toggleSidebar()" class="focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" 
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <h1 class="text-xl font-bold">SISKARA</h1>
        </div>
        <nav class="space-x-4">
            <a href="{{ url('/') }}" class="hover:underline">Home</a>
            <a href="{{ url('/about') }}" class="hover:underline">About</a>
        </nav>
    </header>

    <div class="flex flex-container">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar w-1/5 bg-sky-500 p-4 text-white sidebar fixed lg:static">
            <div class="p-3 pb-1 bg-gray-300 rounded-3xl text-center mb-6">
                <div class="w-24 h-24 mx-auto bg-gray-400 rounded-full mb-3 bg-center bg-contain bg-no-repeat"
                     style="background-image: url(img/fsm.jpg)">
                </div>
                <h2 class="text-lg text-black font-bold">Prof. Dr. Kusworo Adi, S.Si., M.T.</h2>
                <p class="text-xs text-gray-800">NIP 197203171998021001</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Dekan</p>
                <a href="{{ route('login') }}" 
                   class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
            </div>
            <nav class="space-y-4">
                <a href="/dashboard-dekan" class="block py-2 px-3 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">Dashboard</a>
                <a href="/usulanruang" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Usulan Ruang Kuliah</a>
                <a href="/usulanjadwal" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Usulan Jadwal Kuliah</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main id="main-content" class="w-full lg:w-4/5 lg:ml-auto p-8">
            <h1 class="text-3xl font-bold mb-6">Dashboard Dekan</h1>

            <!-- Contoh ringkasan -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="card">
                    <h2 class="text-xl font-semibold mb-2">Tahun Ajaran dengan Usulan Ruang</h2>
                    <ul class="list-disc list-inside text-sm text-gray-700">
                        @foreach($tahunAjaranRuang as $ta)
                            <li>{{ $ta->tahun_ajaran }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="card">
                    <h2 class="text-xl font-semibold mb-2">Tahun Ajaran dengan Usulan Jadwal</h2>
                    <ul class="list-disc list-inside text-sm text-gray-700">
                        @foreach($tahunAjaranJadwal as $tj)
                            <li>{{ $tj->tahun_ajaran }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="card">
                    <h2 class="text-xl font-semibold mb-2">Jumlah Program Studi</h2>
                    <p class="text-2xl font-bold text-gray-800">{{ $jumlahProdi }}</p>
                </div>
            </div>

            <!-- Contoh ringkasan status usulan -->
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-4">Ringkasan Status Usulan Ruang</h2>
                <div class="flex space-x-4">
                    <div class="card flex-1 text-center">
                        <p class="font-semibold text-gray-700">Diajukan</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $countRuangDiajukan }}</p>
                    </div>
                    <div class="card flex-1 text-center">
                        <p class="font-semibold text-gray-700">Disetujui</p>
                        <p class="text-2xl font-bold text-green-600">{{ $countRuangDisetujui }}</p>
                    </div>
                    <div class="card flex-1 text-center">
                        <p class="font-semibold text-gray-700">Ditolak</p>
                        <p class="text-2xl font-bold text-red-600">{{ $countRuangDitolak }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-4">Ringkasan Status Usulan Jadwal</h2>
                <div class="flex space-x-4">
                    <div class="card flex-1 text-center">
                        <p class="font-semibold text-gray-700">Diajukan</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $countJadwalDiajukan }}</p>
                    </div>
                    <div class="card flex-1 text-center">
                        <p class="font-semibold text-gray-700">Disetujui</p>
                        <p class="text-2xl font-bold text-green-600">{{ $countJadwalDisetujui }}</p>
                    </div>
                    <div class="card flex-1 text-center">
                        <p class="font-semibold text-gray-700">Ditolak</p>
                        <p class="text-2xl font-bold text-red-600">{{ $countJadwalDitolak }}</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4 absolute w-full">
        <hr>
        <p class="text-sm text-center">&copy; Siskara Inc. All rights reserved.</p>
    </footer>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('sidebar-closed');

            if (sidebar.classList.contains('sidebar-closed')) {
                // Sidebar tertutup
                mainContent.classList.remove('lg:ml-auto', 'lg:w-4/5');
                mainContent.classList.add('w-full');
            } else {
                // Sidebar terbuka
                mainContent.classList.remove('w-full');
                mainContent.classList.add('lg:ml-auto', 'lg:w-4/5');
            }
        }
    </script>
</body>
</html>
