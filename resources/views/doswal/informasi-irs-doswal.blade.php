<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>SISKARA informasi IRS Mahasiswa</title>
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
            "path" => "dashboard-doswal",
        ],
        (object) [
            "title" => "Persetujuan IRS",
            "path" => "persetujuanIRS-doswal",
        ],
        (object) [
            "title" => "Rekap Mahasiswa",
            "path" => "rekap-doswal",
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
            <div class="flex justify-between items-center mb-3">
                <h1 class="text-5xl text-blue-500 font-bold">
                    <a href="{{ route('rekap-doswal') }}">< Rekap Mahasiswa</a>
                </h1>
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

            {{-- <!-- Year Info -->
            <div class="mb-3">
                <div class="p-4 bg-gray-200 rounded-lg text-gray-700">
                    <p class="text-lg">Tahun Ajaran</p>
                    <p class="text-2xl font-semibold">{{ $tahun->tahun_ajaran }}</p>
                </div>
            </div> --}}

            {{-- code starts here --}}

            <!-- Informasi Mahasiswa -->
            <section class="container bg-gray-100 p-3 rounded-lg shadow mb-3">
                <h3 class="text-xl font-semibold mb-4">Informasi Mahasiswa</h3>
                <div class="grid grid-cols-3 gap-2 text-sm">
                    <div><strong>Nama: </strong>{{ $result->nama }}</div>
                    <div><strong>NIM: </strong>{{ $result->nim }}</div>
                    <div><strong>Program Studi: </strong>Informatika</div>
                    <div><strong>Semester: </strong> {{ $result->semester }}</div>
                    {{-- <div><strong>Maksimum SKS:</strong> 24</div> --}}
                    {{-- <div><strong>IPS Sebelumnya:</strong> 3.7</div> --}}
                    <div><strong>Dosen Wali: </strong>{{ $dosen->nama }}</div>
                    <div><strong>Status IRS semester ini: </strong> <span class="bg-yellow-300 px-2 py-1 rounded">{{$result->status}}</span></div>
                </div>
            </section>
            
            <div class="container flex justify-between">
                {{-- {{ route('irs.filter.mhs') }} --}}
                {{-- Dropdown filter semester --}}
                <form method="GET" action="#" class="w-1/5 mb-3">
                    <label for="kategori-irs-mahasiswa" class="block mb-2 text-sm font-medium text-gray-900">Pilih Semester</label>
                    <select id="kategori-irs-mahasiswa" name="filter"
                            onchange="this.form.submit()"
                            class="border text-sm rounded-lg block w-full p-2.5 bg-slate-600 border-gray-300 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                        @for ($i = 1; $i <= $result->semester; $i++)
                        <option value="semester_{i}" {{ request('filter_semester') == '{i}' ? 'selected' : '' }}>{{$i}}</option>
                        @endfor
                    </select>
                </form>

                {{-- jumlah sks --}}
                <div class="container flex flex-col justify-center w-auto">
                    <p class="jml-sks block mb-2 text-sm font-medium text-gray-900 border-gray-300 border-2 rounded-lg bg-gray-200 p-3 round">Jumlah SKS : {{$sum_sks}}</p>
                </div>
            </div>

            <!-- Daftar IRS -->
            <section class="container overflow-y-auto h-3/5">
                <table class="w-full bg-white rounded-lg shadow text-sm text-left">
                    <thead class="sticky top-0">
                        <tr class="bg-blue-600 text-white">
                            <th class="p-4">No</th>
                            <th>Kode MK</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Kelas</th>
                            <th>Ruang</th>
                            <th>Status</th>
                            <th>Jadwal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($irs as $row)
                        <tr>
                            <td class="p-4">{{$loop->iteration}}</td>
                            <td>{{$row->kode_mk}}</td>
                            <td>{{$row->nama}}</td>
                            <td>{{$row->sks}}</td>
                            <td>{{$row->kelas}}</td>
                            <td>{{$row->id_ruang}}</td>
                            <td>{{$row->status}}</td>
                            <td>{{$row->hari}}, {{$row->waktu_mulai}}-{{$row->waktu_selesai}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>

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
