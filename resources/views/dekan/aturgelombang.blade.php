{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>SISKARA - Atur Gelombang IRS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animasi untuk sidebar */
        .sidebar {
            transition: transform 0.3s ease;
        }

        .sidebar-closed {
            transform: translateX(-100%);
        }

        /* Modal styling */
        .modal-edit {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
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

    <div class="flex">
        <aside id="sidebar" class="sidebar w-1/5 bg-sky-500 h-screen p-4 text-white sidebar-closed fixed lg:static">
            <div class="p-3 pb-1 bg-gray-300 rounded-3xl text-center mb-6">
                <div class="w-24 h-24 mx-auto bg-gray-400 rounded-full mb-3 bg-center bg-contain bg-no-repeat"
                     style="background-image: url(img/fsm.jpg)">
                </div>
                <h2 class="text-lg text-black font-bold">Budi, S.Kom</h2>
                <p class="text-xs text-gray-800">NIP 123431431431415</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Dekan</p>
                <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
            </div>
            <nav class="space-y-4">
                <a href="/dashboard-dekan" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Dashboard</a>
                <a href="/usulanruang" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Usulan Ruang Kuliah</a>
                <a href="/usulanjadwal" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Usulan Jadwal Kuliah</a>
                <a href="/aturgelombang" class="block py-2 px-3 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">Atur Gelombang IRS</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-full lg:w-4/5 lg:ml-auto p-8">
            <!-- Header Halaman -->
            <h1 class="text-3xl font-bold mb-6">Atur Gelombang IRS</h1>

            <!-- Tombol Tambah -->
            <a href="#" class="bg-blue-600 text-white py-2 px-4 rounded-lg inline-block mb-6">Tambah Gelombang</a>

            <!-- Tabel Gelombang IRS -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold mb-4">Ganjil 2024/2025</h3>
                <table class="w-full border border-gray-300">
                    <thead class="bg-sky-500 text-white">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Tahun Ajaran</th>
                            <th class="px-4 py-2 border">Tanggal Mulai</th>
                            <th class="px-4 py-2 border">Tanggal Pergantian Gelombang</th>
                            <th class="px-4 py-2 border">Tanggal Selesai</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="px-4 py-2 text-center">1</td>
                            <td class="px-4 py-2 text-center">2024/2025 Ganjil</td>
                            <td class="px-4 py-2 text-center">2/7/2024</td>
                            <td class="px-4 py-2 text-center">19/7/2024</td>
                            <td class="px-4 py-2 text-center">11/8/2024</td>
                            <td class="px-4 py-2 text-center text-green-600 font-semibold">Sudah Diatur</td>
                            <td class="px-4 py-2 text-center">
                                <button class="bg-blue-500 text-white px-3 py-1 rounded-lg" onclick="openEditModal()">Edit</button>
                                <button class="bg-green-500 text-white px-3 py-1 rounded-lg" onclick="alert('Tanggal pergantian telah diatur')">Atur</button>
                                <button class="bg-red-500 text-white px-3 py-1 rounded-lg" onclick="alert('Tanggal pergantian dibatalkan')">Batalkan</button>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-4 py-2 text-center">2</td>
                            <td class="px-4 py-2 text-center">2023/2024 Genap</td>
                            <td class="px-4 py-2 text-center">31/12/2023</td>
                            <td class="px-4 py-2 text-center">-</td>
                            <td class="px-4 py-2 text-center">21/1/2024</td>
                            <td class="px-4 py-2 text-center text-gray-600 font-semibold">Belum Diatur</td>
                            <td class="px-4 py-2 text-center">
                                <button class="bg-blue-500 text-white px-3 py-1 rounded-lg" onclick="openEditModal()">Edit</button>
                                <button class="bg-green-500 text-white px-3 py-1 rounded-lg" onclick="alert('Tanggal pergantian telah diatur')">Atur</button>
                                <button class="bg-red-500 text-white px-3 py-1 rounded-lg" onclick="alert('Tanggal pergantian dibatalkan')">Batalkan</button>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-4 py-2 text-center">3</td>
                            <td class="px-4 py-2 text-center">2022/2023 Genap</td>
                            <td class="px-4 py-2 text-center">31/12/2022</td>
                            <td class="px-4 py-2 text-center">13/1/2023</td>
                            <td class="px-4 py-2 text-center">21/1/2023</td>
                            <td class="px-4 py-2 text-center text-gray-600 font-semibold">Selesai</td>
                            <td class="px-4 py-2 text-center">
                                <span class="text-gray-500">Tidak Tersedia</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal Edit Tanggal -->
    <div id="editModal" class="modal-edit">
        <div class="modal-content">
            <h2 class="text-xl font-semibold mb-4">Atur Tanggal Pergantian</h2>
            <input type="date" id="editDate" class="border p-2 rounded w-full mb-4">
            <button onclick="saveEdit()" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">Simpan</button>
            <button onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4 absolute w-full">
        <hr>
        <p class="text-sm text-center">&copy; Siskara Inc. All rights reserved.</p>
    </footer>

    <!-- Script -->
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('sidebar-closed');
        }

        function openEditModal() {
            document.getElementById('editModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function saveEdit() {
            const editDate = document.getElementById('editDate').value;
            if (editDate) {
                alert('Tanggal pergantian berhasil disimpan: ' + editDate);
                closeEditModal();
            } else {
                alert('Silakan pilih tanggal terlebih dahulu.');
            }
        }
    </script>
</body>
</html> --}}
