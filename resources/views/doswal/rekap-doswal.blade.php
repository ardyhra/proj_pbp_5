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
    @php
    $menus = [
        (object) [
            "title" => "Dasboard",
            "path" => "dashboard-doswal/".strval($dosen->nidn),
        ],
        (object) [
            "title" => "Persetujuan IRS",
            "path" => "persetujuanIRS-doswal/".strval($dosen->nidn),
        ],
        (object) [
            "title" => "Rekap Mahasiswa",
            "path" => "rekap-doswal/".strval($dosen->nidn),
        ],
        (object) [
            "title" => "Konsultasi",
            "path" => "konsultasi-doswal/".strval($dosen->nidn),
        ],

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
        <aside id="sidebar" class="sidebar w-1/5 bg-sky-500 h-screen p-4 text-white fixed lg:static">
            <!-- profil -->
            <div class="p-3 pb-1 bg-gray-300 rounded-3xl text-center mb-6">
                <div class="w-24 h-24 mx-auto bg-gray-400 rounded-full mb-3 bg-center bg-contain bg-no-repeat"
                     style="background-image: url({{asset('img/fsm.jpg')}})">
                </div>
                <h2 class="text-lg text-black font-bold">{{$dosen->nama}}</h2>
                <p class="text-xs text-gray-800">NIDN {{$dosen->nidn}}</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Dosen</p>
                <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
            </div>
            <nav class="space-y-4">
                @foreach ($menus as $menu)
                <a href="{{ url($menu->path) }}"
                   class="flex items-center space-x-2 p-2 {{ Str::startsWith(request()->path(), $menu->path) ? 'bg-sky-800 rounded-xl text-white hover:bg-opacity-70' : 'bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white' }}">
                    <span>{{$menu->title}}</span>
                </a>
                @endforeach
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-full lg:w-4/5 lg:ml-auto p-8 h-screen">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-5xl font-bold">Rekap Mahasiswa</h1>
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
            <div class="mb-3">
                <div class="p-4 bg-gray-200 rounded-lg text-gray-700">
                    <p class="text-lg">Tahun Ajaran</p>
                    <p class="text-2xl font-semibold">2024/2025 Ganjil</p>
                </div>
            </div>

            <!-- Dropdown filter kategori mahasiswa -->
            <form class="w-1/5 mb-3">
                <label for="kategori-irs-mahasiswa" class="block mb-2 text-sm font-medium text-gray-900">Pilih Kategori</label>
                <select id="kategori-irs-mahasiswa"
                        class="border text-sm rounded-lg block w-full p-2.5 bg-slate-600 border-gray-300 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="semua" selected>Semua</option>
                    <option value="belum-irs">Belum IRS</option>
                    <option value="belum-disetujui">Belum Disetujui</option>
                    <option value="belum-disetujui">Sudah Disetujui</option>
                </select>
            </form>

            <!-- Tabel Mahasiswa -->
            <div class="container overflow-y-auto h-3/5">
                <table class="table-auto min-w-full bg-white border border-gray-200">
                    <!-- Table Header (sticky) -->
                    <thead class="bg-gray-300 sticky top-0">
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">No</th>
                            <th class="px-6 py-3 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">Nama</th>
                            <th class="px-6 py-3 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">NIM</th>
                            <th class="px-6 py-3 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">Semester</th>
                            <th class="px-6 py-3 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">History IRS</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        <!-- Row-->
                        @foreach ($dosen->mahasiswa as $mahasiswa)
                        <tr>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-800 text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-800 text-center">{{ $mahasiswa->nama }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-600 text-center">{{ $mahasiswa->nim }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-600 text-center">{{ $mahasiswa->semester }}</td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-600 text-center">
                                Belum IRS
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-center text-sm">
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-700 hover:underline">Lihat</a>
                            </td>
                        </tr>
                        @endforeach
                        {{-- <!-- Row-->
                        <tr>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-800 text-center">2</td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-800 text-center">Zikry
                                Alfakhri Akram</td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-600 text-center">
                                24060122110001</td>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-600 text-center">5</td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-600 text-center">
                                Belum Disetujui
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-center text-sm">
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-700 hover:underline">Lihat</a>
                            </td>
                        </tr>
                        <!-- Row-->
                        <tr>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-800 text-center">3</td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-800 text-center">Zikry
                                Alfakhri Akram</td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-600 text-center">
                                24060122110001</td>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-600 text-center">5</td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-600 text-center">
                                Sudah Disetujui
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-center text-sm">
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-700 hover:underline">Lihat</a>
                            </td>
                        </tr> --}}
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
