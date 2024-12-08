<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <title>SISKARA - Dashboard Bagian Akademik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar {
            transition: transform 0.3s ease;
        }
        .sidebar-closed {
            transform: translateX(-100%);
        }
        .flex-container {
            min-height: 100vh;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <header class="bg-gradient-to-r from-sky-500 to-blue-600 text-white p-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <button onclick="toggleSidebar()" class="focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                <h2 class="text-lg text-black font-bold">Budi, S.Kom</h2>
                <p class="text-xs text-gray-800">NIP 198611152023101001</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Bagian Akademik</p>
                <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
            </div>
            <nav class="space-y-4">
                <a href="/dashboard-ba" class="block py-2 px-3 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">Dashboard</a>
                <a href="/editruang" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Edit Ruang Kuliah</a>
                <a href="/buatusulan" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Buat Usulan</a>
                <a href="/daftarusulan" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Daftar Usulan</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-full lg:w-4/5 lg:ml-auto p-8">
            <!-- Judul Halaman -->
            <h1 class="text-3xl font-bold mb-6">Dashboard Bagian Akademik</h1>

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold">Total Usulan</h2>
                    <p class="text-3xl font-semibold">{{ $totalUsulan }}</p>
                </div>
                <div class="bg-green-500 text-white p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold">Total Program Studi</h2>
                    <p class="text-3xl font-semibold">{{ $totalProgramStudi }}</p>
                </div>
                <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold">Total Ruang</h2>
                    <p class="text-3xl font-semibold">{{ $totalRuang }}</p>
                </div>
            </div>

            <!-- Rekap Status -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold mb-4">Rekap Status Usulan per Tahun Ajaran</h2>
                <table class="table-auto min-w-full bg-white border border-gray-200 text-sm">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold">Status</th>
                            <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">Belum Diajukan</td>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">{{ $rekapStatus['belum_diajukan'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">Diajukan</td>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">{{ $rekapStatus['diajukan'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">Disetujui</td>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">{{ $rekapStatus['disetujui'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">Ditolak</td>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">{{ $rekapStatus['ditolak'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Usulan Terbaru -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold mb-4">Usulan Terbaru</h2>
                <table class="table-auto min-w-full bg-white border border-gray-200 text-sm">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold">Program Studi</th>
                            <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold">Tahun Ajaran</th>
                            <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usulanTerbaru as $usulan)
                        <tr>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">{{ $usulan->programStudi->nama_prodi }}</td>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">{{ $usulan->tahunAjaran->tahun_ajaran }}</td>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">{{ ucfirst($usulan->status) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
