<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>SISKARA - Buat Usulan</title>
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
                <p class="text-xs text-gray-800">NIP 002</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Bagian Akademik</p>
                <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
            </div>
            <nav class="space-y-4">
                <a href="/dashboard-ba" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Dashboard</a>
                <a href="/buatusulan" class="block py-2 px-3 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">Buat Usulan</a>
                <a href="/daftarusulan" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Daftar Usulan</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-full lg:w-4/5 lg:ml-auto p-8">
            <!-- Judul Halaman -->
            <h1 class="text-3xl font-bold mb-6">Buat Usulan Pengaturan Ruang Kuliah</h1>

            <!-- Form Usulan -->
            <div class="bg-gray-200 p-6 rounded-lg mb-6">
                <!-- Tahun Ajaran -->
                <div class="mb-4">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Tahun Ajaran</label>
                    <p class="p-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-700">2024/2025 Ganjil</p>
                </div>

                <!-- Program Studi -->
                <div class="mb-4">
                    <label for="program-studi" class="block text-lg font-semibold text-gray-700 mb-2">Program Studi</label>
                    <select id="program-studi" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Informatika">Informatika</option>
                        <option value="Sistem Informasi">Sistem Informasi</option>
                        <option value="Teknik Elektro">Teknik Elektro</option>
                    </select>
                </div>

                <!-- Ruang Kuliah -->
                <div class="mb-4">
                    <label for="ruang-kuliah" class="block text-lg font-semibold text-gray-700 mb-2">Ruang Kuliah</label>
                    <select id="ruang-kuliah" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="A101">A101</option>
                        <option value="B202">B202</option>
                        <option value="C303">C303</option>
                        <option value="D404">D404</option>
                    </select>
                </div>

                <!-- Tombol Tambah ke Kanan -->
                <div class="flex justify-end">
                    <button onclick="tambahRuang()" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Tambah Ruang</button>
                </div>
            </div>

            <!-- Tabel Rekap Ruang per Program Studi -->
            <h2 class="text-2xl font-bold mb-4">Rekap Ruang Kuliah per Program Studi</h2>
            <table class="table-auto min-w-full bg-white border border-gray-200 text-sm">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="px-2 py-2 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">No</th>
                        <th class="px-2 py-2 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">Program Studi</th>
                        <th class="px-2 py-2 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">Jumlah Ruang</th>
                        <th class="px-2 py-2 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody id="rekap-ruang">
                    <!-- Program Studi dengan Daftar Ruang Kosong -->
                    <tr>
                        <td class="px-2 py-2 border-b border-gray-200 text-sm text-gray-800 text-center">1</td>
                        <td class="px-2 py-2 border-b border-gray-200 text-sm text-gray-800 text-center">Informatika</td>
                        <td class="px-2 py-2 border-b border-gray-200 text-sm text-gray-800 text-center" id="jumlah-Informatika">0</td>
                        <td class="px-2 py-2 border-b border-gray-200 text-center">
                            <button onclick="tampilkanDetail('Informatika')" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">Detail</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-2 py-2 border-b border-gray-200 text-sm text-gray-800 text-center">2</td>
                        <td class="px-2 py-2 border-b border-gray-200 text-sm text-gray-800 text-center">Sistem Informasi</td>
                        <td class="px-2 py-2 border-b border-gray-200 text-sm text-gray-800 text-center" id="jumlah-Sistem Informasi">0</td>
                        <td class="px-2 py-2 border-b border-gray-200 text-center">
                            <button onclick="tampilkanDetail('Sistem Informasi')" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">Detail</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-2 py-2 border-b border-gray-200 text-sm text-gray-800 text-center">3</td>
                        <td class="px-2 py-2 border-b border-gray-200 text-sm text-gray-800 text-center">Teknik Elektro</td>
                        <td class="px-2 py-2 border-b border-gray-200 text-sm text-gray-800 text-center" id="jumlah-Teknik Elektro">0</td>
                        <td class="px-2 py-2 border-b border-gray-200 text-center">
                            <button onclick="tampilkanDetail('Teknik Elektro')" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">Detail</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Tabel Detail Ruang Kuliah per Program Studi -->
            <div class="mt-6" id="detail-ruang-container" style="display: none;">
                <h3 class="text-xl font-bold mb-4" id="program-studi-judul"></h3>
                <table class="table-auto min-w-full bg-white border border-gray-200 text-sm">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="px-2 py-2 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">No</th>
                            <th class="px-2 py-2 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">Ruang Kuliah</th>
                            <th class="px-2 py-2 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="detail-ruang">
                        <!-- Daftar ruang akan ditampilkan di sini -->
                    </tbody>
                </table>
            </div>

            <!-- Tombol Simpan di Paling Bawah -->
            <div class="flex justify-end mt-6">
                <button onclick="simpanUsulan()" class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">Simpan Usulan</button>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4 absolute w-full">
        <hr>
        <p class="text-sm text-center">&copy; Siskara Inc. All rights reserved.</p>
    </footer>

    <script>
        const programStudiRuang = {};

        function tambahRuang() {
            const programStudi = document.getElementById('program-studi').value;
            const ruangKuliah = document.getElementById('ruang-kuliah').value;

            if (!programStudiRuang[programStudi]) {
                programStudiRuang[programStudi] = [];
            }

            if (programStudiRuang[programStudi].includes(ruangKuliah)) {
                alert('Ruang ini sudah ditambahkan untuk program studi ini.');
                return;
            }

            programStudiRuang[programStudi].push(ruangKuliah);
            updateJumlahRuang(programStudi);
            updateDetailTabel(programStudi);
        }

        function updateJumlahRuang(programStudi) {
            document.getElementById(`jumlah-${programStudi}`).textContent = programStudiRuang[programStudi].length;
        }

        function tampilkanDetail(programStudi) {
            document.getElementById('detail-ruang-container').style.display = 'block';
            document.getElementById('program-studi-judul').textContent = `Detail Ruang Kuliah untuk Program Studi ${programStudi}`;
            updateDetailTabel(programStudi);
        }

        function updateDetailTabel(programStudi) {
            const detailRuangContainer = document.getElementById('detail-ruang');
            detailRuangContainer.innerHTML = '';

            programStudiRuang[programStudi].forEach((ruang, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-2 py-2 border-b border-gray-200 text-sm text-gray-800 text-center">${index + 1}</td>
                    <td class="px-2 py-2 border-b border-gray-200 text-sm text-gray-800 text-center">${ruang}</td>
                    <td class="px-2 py-2 border-b border-gray-200 text-center">
                        <button onclick="hapusRuang('${programStudi}', '${ruang}')" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600">Hapus</button>
                    </td>
                `;
                detailRuangContainer.appendChild(row);
            });
        }

        function hapusRuang(programStudi, ruang) {
            const index = programStudiRuang[programStudi].indexOf(ruang);
            if (index !== -1) {
                programStudiRuang[programStudi].splice(index, 1);
                updateJumlahRuang(programStudi);
                updateDetailTabel(programStudi);
            }
        }

        function simpanUsulan() {
            console.log('Usulan berhasil disimpan:', programStudiRuang);
            alert('Usulan ruang kuliah berhasil disimpan.');
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('sidebar-closed');
        }
    </script>
</body>
</html>
