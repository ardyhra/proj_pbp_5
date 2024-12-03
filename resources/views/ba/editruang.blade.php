<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>SISKARA - Edit Ruang Kuliah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
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

    <div class="flex flex-container">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar w-1/5 bg-sky-500 p-4 text-white sidebar fixed lg:static">
            <!-- Profil -->
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
                <a href="/editruang" class="block py-2 px-3 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">Edit Ruang Kuliah</a>
                <a href="/buatusulan" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Buat Usulan</a>
                <a href="/daftarusulan" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Daftar Usulan</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main id="main-content" class="w-full lg:w-4/5 lg:ml-auto p-8 main-content main-content-expanded">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif
            <h1 class="text-3xl font-bold mb-6">Edit Ruang Kuliah</h1>

            <!-- Tombol Tambah -->
            <div class="mb-6">
                <button onclick="openModal('add')" class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700">Tambah Ruang Kuliah</button>
            </div>

            <!-- Tabel Daftar Ruang Kuliah -->
            <table class="table-auto min-w-full bg-white border border-gray-200 text-sm">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="px-2 py-2 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">No</th>
                        <th class="px-2 py-2 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">Kode Ruang</th>
                        <th class="px-2 py-2 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">Blok Gedung</th>
                        <th class="px-2 py-2 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">Lantai</th>
                        <th class="px-2 py-2 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">Kapasitas</th>
                        <th class="px-2 py-2 border-b border-gray-200 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody id="ruangTableBody">
                    @foreach($ruang as $index => $data)
                        <tr>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">{{ $index + 1 }}</td>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">{{ $data->id_ruang }}</td>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">{{ $data->blok_gedung }}</td>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">{{ $data->lantai }}</td>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">{{ $data->kapasitas }}</td>
                            <td class="px-2 py-2 border-b border-gray-200 text-center">
                                <button onclick="openModal('edit', {{ $index }})" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">Edit</button>
                                <button onclick="deleteRuang('{{ $data->id_ruang }}')" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
    </div>

    <!-- Modal -->
    <div id="ruangModal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle" class="text-xl font-bold mb-4">Tambah/Edit Ruang Kuliah</h2>
            <form id="ruangForm">
                <div class="mb-4">
                    <label for="kode-ruang" class="block text-gray-700 font-semibold mb-2">Kode Ruang</label>
                    <input type="text" id="kode-ruang" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none" required>
                </div>
                <div class="mb-4">
                    <label for="blok-gedung" class="block text-gray-700 font-semibold mb-2">Blok Gedung</label>
                    <input type="text" id="blok-gedung" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none" required>
                </div>
                <div class="mb-4">
                    <label for="lantai" class="block text-gray-700 font-semibold mb-2">Lantai</label>
                    <input type="number" id="lantai" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none" required>
                </div>
                <div class="mb-4">
                    <label for="kapasitas" class="block text-gray-700 font-semibold mb-2">Kapasitas</label>
                    <input type="number" id="kapasitas" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none" required>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4">
        <hr>
        <p class="text-sm text-center">&copy; Siskara Inc. All rights reserved.</p>
    </footer>

    <script>
        let ruangData = [];
        let editIndex = null;
        let originalIdRuang = null;

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('sidebar-closed');
        }

        function openModal(mode, index = null) {
            document.getElementById('ruangModal').style.display = 'block';

            if (mode === 'add') {
                document.getElementById('modalTitle').textContent = 'Tambah Ruang Kuliah';
                document.getElementById('kode-ruang').value = '';
                document.getElementById('blok-gedung').value = '';
                document.getElementById('lantai').value = '';
                document.getElementById('kapasitas').value = '';
                editIndex = null;
                originalIdRuang = null;
            } else if (mode === 'edit') {
                if (index === null || index < 0 || index >= ruangData.length) {
                    console.error(`Data ruang tidak ditemukan untuk index: ${index}`);
                    alert('Data ruang tidak ditemukan!');
                    closeModal(); // Close the modal if data not found
                    return;
                }

                document.getElementById('modalTitle').textContent = 'Edit Ruang Kuliah';
                const ruang = ruangData[index];
                console.log('Data ruang yang di-edit:', ruang); // Debugging
                document.getElementById('kode-ruang').value = ruang.id_ruang;
                document.getElementById('blok-gedung').value = ruang.blok_gedung;
                document.getElementById('lantai').value = ruang.lantai;
                document.getElementById('kapasitas').value = ruang.kapasitas;
                editIndex = index;
                originalIdRuang = ruang.id_ruang;
            }
        }







        function closeModal() {
            document.getElementById('ruangModal').style.display = 'none';
        }

        document.getElementById('ruangForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const id_ruang = document.getElementById('kode-ruang').value;
            const blok_gedung = document.getElementById('blok-gedung').value;
            const lantai = document.getElementById('lantai').value;
            const kapasitas = document.getElementById('kapasitas').value;

            const url = editIndex !== null ? `/editruang/${originalIdRuang}` : '/editruang';
            const method = editIndex !== null ? 'PUT' : 'POST';

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch(url, {
                    method,
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ id_ruang, blok_gedung, lantai, kapasitas })
                });

                if (response.ok) {
                    const data = await response.json();
                    alert(data.message);
                    fetchData(); // Refresh tabel
                    closeModal(); // Tutup modal
                } else if (response.status === 422) {
                    const errors = await response.json();
                    let errorMessage = '';
                    for (const key in errors.errors) {
                        if (errors.errors.hasOwnProperty(key)) {
                            errorMessage += errors.errors[key].join('\n') + '\n';
                        }
                    }
                    alert('Terjadi kesalahan:\n' + errorMessage);
                } else {
                    const error = await response.json();
                    alert('Gagal menyimpan ruang: ' + error.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });

        async function fetchData() {
            try {
                const response = await fetch('/editruang', {
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                if (response.ok) {
                    ruangData = await response.json();
                    console.log('Data ruang berhasil diambil:', ruangData); // Log data
                    renderTable(ruangData); // Render table
                } else {
                    console.error('Gagal mengambil data ruang:', response.statusText);
                }
            } catch (error) {
                console.error('Error saat fetch data ruang:', error);
            }
        }





        function renderTable(ruangData) {
            const tableBody = document.getElementById('ruangTableBody');
            tableBody.innerHTML = ''; // Clear the table

            ruangData.forEach((ruang, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-2 py-2 border-b border-gray-200 text-center">${index + 1}</td>
                    <td class="px-2 py-2 border-b border-gray-200 text-center">${ruang.id_ruang}</td>
                    <td class="px-2 py-2 border-b border-gray-200 text-center">${ruang.blok_gedung}</td>
                    <td class="px-2 py-2 border-b border-gray-200 text-center">${ruang.lantai}</td>
                    <td class="px-2 py-2 border-b border-gray-200 text-center">${ruang.kapasitas}</td>
                    <td class="px-2 py-2 border-b border-gray-200 text-center">
                        <button onclick="openModal('edit', ${index})" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">Edit</button>
                        <button onclick="deleteRuang('${ruang.id_ruang}')" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600">Hapus</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }



        async function deleteRuang(id) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const confirmDelete = confirm('Apakah Anda yakin ingin menghapus ruang ini?');
            if (!confirmDelete) return;

            const response = await fetch(`/editruang/${id}`, { 
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });
            if (response.ok) {
                const data = await response.json();
                alert(data.message);
                fetchData();
            } else {
                const error = await response.json();
                alert('Gagal menghapus ruang: ' + error.message);
            }
        }

        // Inisialisasi data saat halaman dimuat
        window.onload = fetchData;
    </script>

</body>
</html>
