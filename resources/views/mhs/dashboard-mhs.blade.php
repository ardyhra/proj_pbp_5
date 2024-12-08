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
                "title" => "Pengisian IRS",
                "path" => "pengisianirs-mhs",
            ],
            (object) [
                "title" => "IRS",
                "path" => "irs-mhs",
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
                <h2 class="text-lg text-black font-bold">{{ $mhs->nama_mhs }}</h2>
                <p class="text-xs text-gray-800">NIM {{ $mhs->nim }}</p>
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
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-full lg:w-8/5 lg:ml-auto p-8">
            <h1 class="text-4xl font-bold mb-2">Dashboard</h1>
            <div class="grid grid-cols-4 gap-4 p-4 bg-white rounded-lg">
                <div class="col-span-4">
                    <h2 class="text-2xl font-bold mb-2">Status Akademik</h2>
                </div>
                <div class="col-span-2 flex flex-col justify-center items-center p-4 bg-gray-300 rounded-lg text-center h-32">
                    <h3 class="text-lg font-semibold">Dosen Wali</h3>
                    <p class="text-2xl font-bold">{{ $doswal->nama }}</p>
                    <p class="text-2xl font-bold">NIDN: {{ $doswal->nidn }}</p>
                </div>
                <div class="col-span-2 flex flex-col justify-center items-center p-4 bg-gray-300 rounded-lg text-center h-32">
                    <h3 class="text-lg font-semibold">Semester Akademik</h3>
                    <p class="text-4xl font-bold">{{ $tahun_ajaran }}</p>
                </div>
                <div class="col-span-1 flex flex-col justify-center items-center p-4 bg-gray-300 rounded-lg text-center h-32">
                    <h3 class="text-lg font-semibold">Semester Studi</h3>
                    <p class="text-4xl font-bold">{{ $mhs->semester }}</p>
                </div>
                <div class="col-span-1 flex flex-col justify-center items-center p-4 bg-gray-300 rounded-lg text-center h-32">
                    <h3 class="text-lg font-semibold">Status</h3>
                    <p class="text-4xl font-bold">{{ $mhs->status }}</p>
                </div>
                <div class="col-span-1 flex flex-col justify-center items-center p-4 bg-gray-300 rounded-lg text-center h-32">
                    <h3 class="text-lg font-semibold">IPK</h3>
                    <p class="text-4xl font-bold">{{ number_format($ipk, 2) }}</p>
                </div>
                <div class="col-span-1 flex flex-col justify-center items-center p-4 bg-gray-300 rounded-lg text-center h-32">
                    <h3 class="text-lg font-semibold">SKSk</h3>
                    <p class="text-4xl font-bold">{{ $sksk }}</p>
                </div>
            </div> 

            <!-- Informasi Perubahan Jadwal -->
            <div class="mt-6 p-4 bg-white rounded-lg shadow-lg">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Riwayat Status</h2>
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
                        @foreach ($riwayat_status as $index => $status)
                            <tr class="border-b">
                                <td class="py-2 px-4 text-center w-8">{{ $index + 1 }}</td>
                                <td class="py-2 px-4 text-center">{{ $status->tahun_ajaran }}</td>
                                <td class="py-2 px-4 text-center">{{ $status->status }}</td>
                            </tr>
                        @endforeach
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
