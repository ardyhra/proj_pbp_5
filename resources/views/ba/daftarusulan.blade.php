<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKARA - Daftar Usulan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animasi untuk sidebar */
        .sidebar {
            transition: transform 0.3s ease;
        }

        .sidebar-closed {
            transform: translateX(-100%);
        }

        /* Konten Utama */
        .table-container {
            max-height: 300px;
            overflow-y: auto;
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
                <p class="text-xs text-gray-800">NIP 002</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Bagian Akademik</p>
                <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
            </div>
            <nav class="space-y-4">
                <a href="/dashboard-ba" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Dashboard</a>
                <a href="/buatusulan" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Buat Usulan</a>
                <a href="/daftarusulan" class="block py-2 px-3 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">Daftar Usulan</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-full lg:w-4/5 lg:ml-auto p-8">
            <!-- Judul Halaman -->
            <h1 class="text-3xl font-bold mb-6">Daftar Usulan</h1>

            <!-- Daftar Usulan -->
            <div class="space-y-4">
                <!-- Usulan Semester Genap -->
                <div onclick="tampilkanRekap('genap2023')" class="bg-white p-4 rounded-lg shadow cursor-pointer hover:bg-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-semibold">Genap 2023/2024</h2>
                            <p class="text-gray-600">Status: <span class="text-green-500">✓ Sudah disetujui</span></p>
                        </div>
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Lihat</button>
                    </div>
                </div>

                <!-- Usulan Semester Ganjil -->
                <div onclick="tampilkanRekap('ganjil2024')" class="bg-white p-4 rounded-lg shadow cursor-pointer hover:bg-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-semibold">Ganjil 2024/2025</h2>
                            <p class="text-gray-600">Status: <span class="text-gray-600">⏳ Belum diajukan</span></p>
                        </div>
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Lihat</button>
                    </div>
                </div>
            </div>

            <!-- Tabel Rekap Ruang Kuliah -->
            <div id="rekap-ruang-container" class="mt-6 hidden">
                <h2 class="text-2xl font-bold mb-4" id="judul-rekap"></h2>
                <div class="table-container">
                    <table class="min-w-full bg-white border border-gray-200 text-sm">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">No</th>
                                <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">Program Studi</th>
                                <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">Jumlah Ruang</th>
                                <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="rekap-ruang">
                            <!-- Daftar program studi akan dimuat di sini -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Detail Ruang Kuliah -->
            <div id="detail-ruang-container" class="mt-6 hidden">
                <h3 class="text-xl font-bold mb-2" id="judul-detail-ruang"></h3>
                <div class="table-container">
                    <table class="min-w-full bg-white border border-gray-200 text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">No</th>
                                <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">Nama Ruang</th>
                                <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">Kapasitas</th>
                            </tr>
                        </thead>
                        <tbody id="detail-ruang">
                            <!-- Daftar ruang kuliah akan dimuat di sini -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tombol Tambahan untuk Tahun Ajaran Aktif -->
            <div id="tombol-aksi-container" class="mt-6 flex space-x-4 justify-end">
                <button onclick="ajukanUsulan()" class="bg-green-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-600">Ajukan Usulan</button>
                <button onclick="batalkanUsulan()" class="bg-red-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-600">Batalkan Usulan</button>
                <button onclick="mintaPerbaikan()" class="bg-yellow-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-yellow-600">Minta Perbaikan</button>
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
            document.getElementById('sidebar').classList.toggle('sidebar-closed');
        }

        function tampilkanRekap(semester) {
            const rekapRuangContainer = document.getElementById('rekap-ruang-container');
            const tombolAksiContainer = document.getElementById('tombol-aksi-container');
            const judulRekap = document.getElementById('judul-rekap');

            rekapRuangContainer.classList.remove('hidden');
            document.getElementById('detail-ruang-container').classList.add('hidden');

            // Ganti judul rekap berdasarkan semester
            if (semester === 'ganjil2024') {
                judulRekap.innerText = 'Rekap Ruang Kuliah - Ganjil 2024/2025';
                tombolAksiContainer.classList.remove('hidden'); // Tampilkan tombol jika tahun ajaran aktif
            } else {
                judulRekap.innerText = 'Rekap Ruang Kuliah - Genap 2023/2024';
                tombolAksiContainer.classList.add('hidden'); // Sembunyikan tombol jika tahun ajaran lama
            }

            // Tampilkan data rekap ruang
            const dataRekap = [
                { no: 1, programStudi: 'Teknik Informatika', jumlahRuang: 5 },
                { no: 2, programStudi: 'Teknik Sipil', jumlahRuang: 3 },
                { no: 3, programStudi: 'Teknik Elektro', jumlahRuang: 4 }
            ];

            const rekapRuangTabel = document.getElementById('rekap-ruang');
            rekapRuangTabel.innerHTML = ''; // Kosongkan tabel
            dataRekap.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.no}</td>
                    <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.programStudi}</td>
                    <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.jumlahRuang}</td>
                    <td class="px-2 py-1 border-b border-gray-200 text-center">
                        <button onclick="lihatDetail('${item.programStudi}')" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">Detail</button>
                    </td>
                `;
                rekapRuangTabel.appendChild(row);
            });
        }

        function lihatDetail(programStudi) {
            const detailRuangContainer = document.getElementById('detail-ruang-container');
            const judulDetailRuang = document.getElementById('judul-detail-ruang');
            const detailRuangTabel = document.getElementById('detail-ruang');

            detailRuangContainer.classList.remove('hidden');
            judulDetailRuang.innerText = `Daftar Ruang Kuliah - ${programStudi}`;

            // Data contoh ruang kuliah untuk program studi
            const dataRuang = [
                { no: 1, namaRuang: 'Ruang 101', kapasitas: 50 },
                { no: 2, namaRuang: 'Ruang 102', kapasitas: 40 },
                { no: 3, namaRuang: 'Ruang 103', kapasitas: 35 }
            ];

            detailRuangTabel.innerHTML = ''; // Kosongkan tabel
            dataRuang.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.no}</td>
                    <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.namaRuang}</td>
                    <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.kapasitas}</td>
                `;
                detailRuangTabel.appendChild(row);
            });
        }

        function ajukanUsulan() {
            alert("Usulan diajukan.");
        }

        function batalkanUsulan() {
            alert("Usulan dibatalkan.");
        }

        function mintaPerbaikan() {
            alert("Permintaan perbaikan dikirim.");
        }
    </script>
</body>
</html>
