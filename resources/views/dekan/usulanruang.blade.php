<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKARA - Usulan Ruang Kuliah</title>
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
        /* Konten Utama */
        .table-container {
            max-height: 300px;
            overflow-y: auto;
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
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
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
            <!-- profil -->
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
                <a href="/usulanruang" class="block py-2 px-3 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">Usulan Ruang Kuliah</a>
                <a href="/usulanjadwal" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Usulan Jadwal Kuliah</a>
                <a href="/aturgelombang" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Atur Gelombang IRS</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-full lg:w-4/5 lg:ml-auto p-8">
            <!-- Judul Halaman -->
            <h1 class="text-3xl font-bold mb-6">Usulan Ruang Kuliah</h1>

            <div class="space-y-4">
                @foreach($tahunAjaranList as $tahunAjaran)
                    @php
                        $usulanTahun = $usulanStatuses->get($tahunAjaran->id_tahun);
                        $status = $usulanTahun ? $usulanTahun->first()->status : 'belum_diajukan';
            
                        $statusText = [
                            'belum_diajukan' => '⏳ Belum diajukan',
                            'diajukan' => '🚀 Diajukan',
                            'disetujui' => '✅ Disetujui',
                            'ditolak' => '❌ Ditolak'
                        ][$status];
            
                        $statusColor = [
                            'belum_diajukan' => 'text-gray-600',
                            'diajukan' => 'text-blue-600',
                            'disetujui' => 'text-green-600',
                            'ditolak' => 'text-red-600'
                        ][$status];
                    @endphp
                    <div onclick="tampilkanRekap('{{ $tahunAjaran->id_tahun }}', '{{ $status }}')" class="bg-white p-4 rounded-lg shadow cursor-pointer hover:bg-gray-100">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-semibold">{{ $tahunAjaran->tahun_ajaran }}</h2>
                                <p class="text-gray-600">Status: <span class="{{ $statusColor }}">{{ $statusText }}</span></p>
                            </div>
                            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Lihat</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Container for Rekap Ruang Kuliah -->
            <div id="rekap-ruang-container" class="hidden mt-6">
                <h2 id="judul-rekap" class="text-2xl font-bold mb-4"></h2>
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
                        <!-- Daftar rekap ruang kuliah akan dimuat di sini -->
                    </tbody>
                </table>

                <!-- Tombol Aksi -->
                <div id="tombol-aksi-container" class="mt-6 flex space-x-4 justify-end hidden">
                    <button onclick="setujuiUsulan(currentIdTahun)" class="bg-green-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-600">
                        Setujui Usulan
                    </button>
                    <button onclick="tolakUsulan(currentIdTahun)" class="bg-red-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-600">
                        Tolak Usulan
                    </button>
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

        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4 absolute w-full">
        <hr>
        <p class="text-sm text-center">&copy; Siskara Inc. All rights reserved.</p>
    </footer>

    <script>
        let currentIdTahun = null; // Variabel global untuk menyimpan id_tahun yang dipilih

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('sidebar-closed');
        }

        function formatTahunAjaran(id_tahun) {
            if (!id_tahun || id_tahun.length !== 5) {
                console.error('Format id_tahun tidak valid:', id_tahun);
                return 'Tahun Ajaran Tidak Diketahui';
            }

            const semester = id_tahun.endsWith('1') ? 'Gasal' : 'Genap';
            const tahunMulai = `20${id_tahun.slice(0, 2)}`;
            const tahunAkhir = parseInt(tahunMulai) + 1;
            return `${semester} ${tahunMulai}/${tahunAkhir}`;
        }

        function tampilkanRekap(id_tahun, status) {
            currentIdTahun = id_tahun; // Simpan id_tahun yang dipilih

            const rekapRuangContainer = document.getElementById('rekap-ruang-container');
            const tombolAksiContainer = document.getElementById('tombol-aksi-container');
            const judulRekap = document.getElementById('judul-rekap');

            if (!rekapRuangContainer || !tombolAksiContainer || !judulRekap) {
                console.error('Elemen tidak ditemukan. Pastikan elemen dengan ID yang sesuai ada di HTML.');
                return;
            }

            rekapRuangContainer.classList.remove('hidden');
            document.getElementById('detail-ruang-container').classList.add('hidden');

            // Update judul rekap
            judulRekap.innerText = `Rekap Ruang Kuliah - ${formatTahunAjaran(id_tahun)}`;

            // Fetch data dari server
            fetch(`/get-usulan/${id_tahun}`)
                .then(response => response.json())
                .then(data => {
                    const rekapRuangTabel = document.getElementById('rekap-ruang');
                    if (!rekapRuangTabel) {
                        console.error('Elemen rekap-ruang tidak ditemukan.');
                        return;
                    }
                    rekapRuangTabel.innerHTML = ''; // Clear the table

                    data.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${index + 1}</td>
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.program_studi}</td>
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.jumlah_ruang}</td>
                            <td class="px-2 py-1 border-b border-gray-200 text-center">
                                <button onclick="lihatDetail('${item.id_prodi}', '${id_tahun}')" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">Detail</button>
                            </td>
                        `;
                        rekapRuangTabel.appendChild(row);
                    });

                    // Tampilkan tombol aksi jika statusnya 'diajukan'
                    if (status === 'diajukan') {
                        tombolAksiContainer.classList.remove('hidden');
                    } else {
                        tombolAksiContainer.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert('Terjadi kesalahan saat mengambil data.');
                });
        }

        function lihatDetail(id_prodi, id_tahun) {
            const detailRuangContainer = document.getElementById('detail-ruang-container');
            const judulDetailRuang = document.getElementById('judul-detail-ruang');
            const detailRuangTabel = document.getElementById('detail-ruang');

            if (!detailRuangContainer || !judulDetailRuang || !detailRuangTabel) {
                console.error('Elemen detail ruang tidak ditemukan.');
                return;
            }

            detailRuangContainer.classList.remove('hidden');

            // Fetch data dari server
            fetch(`/get-usulan-detail/${id_tahun}/${id_prodi}`)
                .then(response => response.json())
                .then(data => {
                    judulDetailRuang.innerText = `Daftar Ruang Kuliah - ${data.program_studi}`;

                    detailRuangTabel.innerHTML = ''; // Clear the table
                    data.ruang.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${index + 1}</td>
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.id_ruang}</td>
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.kapasitas}</td>
                        `;
                        detailRuangTabel.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert('Terjadi kesalahan saat mengambil data.');
                });
        }

        function updateStatusUsulan(idTahun, status) {
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            if (!csrfMeta) {
                console.error('Token CSRF tidak ditemukan. Pastikan elemen <meta name="csrf-token"> ada di HTML.');
                return;
            }
            
            const csrfToken = csrfMeta.getAttribute('content');

            fetch(`/usulanruang/${idTahun}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ status })
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Gagal memperbarui status usulan');
                    });
                }
            })
            .then(data => {
                alert(data.message);
                location.reload(); // Refresh halaman untuk memperbarui status
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memperbarui status usulan.');
            });
        }

        function setujuiUsulan(idTahun) {
            updateStatusUsulan(idTahun, 'disetujui');
        }

        function tolakUsulan(idTahun) {
            updateStatusUsulan(idTahun, 'ditolak');
        }
    </script>

</body>
</html>
