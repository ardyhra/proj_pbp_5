<!-- resources/views/dekan/usulanjadwal.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKARA - Usulan Jadwal Kuliah</title>
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
                <a href="/dashboard-dekan" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Dashboard</a>
                <a href="/usulanruang" class="block py-2 px-3 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">Usulan Ruang Kuliah</a>
                <a href="/usulanjadwal" class="block py-2 px-3 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">Usulan Jadwal Kuliah</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main id="main-content" class="w-full lg:w-4/5 lg:ml-auto p-8">
            <h1 class="text-3xl font-bold mb-6">Usulan Jadwal Kuliah</h1>

            <!-- Daftar Tahun Ajaran -->
            <div class="space-y-4">
                @foreach($tahunajarans as $tahun)
                    <!-- Setiap tahun ajaran jika ada usulan jadwal, maka bisa ditampilkan -->
                    <!-- Di sini kita asumsikan semua tahunAjaran ada, user bisa klik untuk melihat usulan jadwal -->
                    <div onclick="tampilkanRekap('{{ $tahun->id_tahun }}')" 
                         class="bg-white p-4 rounded-lg shadow cursor-pointer hover:bg-gray-100">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-semibold">{{ $tahun->tahun_ajaran }}</h2>
                            </div>
                            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Lihat</button>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Container Rekap Jadwal Kuliah -->
            <div id="rekap-jadwal-container" class="hidden mt-6">
                <h2 id="judul-rekap" class="text-2xl font-bold mb-4"></h2>
                <table class="min-w-full bg-white border border-gray-200 text-sm">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">No</th>
                            <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">Program Studi</th>
                            <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">Status</th>
                            <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="rekap-jadwal">
                        <!-- Data akan di-load dari server -->
                    </tbody>
                </table>
            </div>

            <!-- Tabel Detail Jadwal Kuliah -->
            <div id="detail-jadwal-container" class="mt-6 hidden">
                <h3 class="text-xl font-bold mb-2" id="judul-detail-jadwal"></h3>
                <div class="table-container">
                    <table class="min-w-full bg-white border border-gray-200 text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">No</th>
                                <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">Kode MK</th>
                                <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">Nama MK</th>
                                <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">Hari</th>
                                <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">Waktu</th>
                                <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">Ruang</th>
                                <th class="px-2 py-2 border-b border-gray-200 text-center font-semibold text-gray-700">Kelas</th>
                            </tr>
                        </thead>
                        <tbody id="detail-jadwal">
                            <!-- Data akan di-load dari server -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Container Aksi Detail Prodi (Setujui/Tolak/Batalkan) -->
            <div id="detail-prodi-action-container" class="mt-4 flex space-x-4 justify-end hidden"></div>

        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4 absolute w-full">
        <hr>
        <p class="text-sm text-center">&copy; Siskara Inc. All rights reserved.</p>
    </footer>

    <script>
        let currentIdTahun = null;
        let currentIdProdi = null; 

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

        function formatTahunAjaran(id_tahun) {
            if (!id_tahun || id_tahun.length !== 5) {
                console.error('Format id_tahun tidak valid:', id_tahun);
                return 'Tahun Ajaran Tidak Diketahui';
            }

            // Ambil tahun mulai (empat digit pertama)
            const tahunMulai = id_tahun.slice(0, 4); // Misalnya "2024"
            const semester = id_tahun.endsWith('1') ? 'Gasal' : 'Genap'; // Semester berdasarkan digit terakhir
            const tahunAkhir = parseInt(tahunMulai) + 1; // Tahun akhir adalah tahun mulai + 1

            return `${semester} ${tahunMulai}/${tahunAkhir}`;
        }


        function tampilkanRekap(id_tahun) {
            currentIdTahun = id_tahun;

            const rekapJadwalContainer = document.getElementById('rekap-jadwal-container');
            const judulRekap = document.getElementById('judul-rekap');

            rekapJadwalContainer.classList.remove('hidden');
            document.getElementById('detail-jadwal-container').classList.add('hidden');
            document.getElementById('detail-prodi-action-container').classList.add('hidden');

            judulRekap.innerText = `Rekap Jadwal Kuliah - ${formatTahunAjaran(id_tahun)}`;

            // Ambil data dari server
            fetch(`/get-usulan-jadwal-by-tahun/${id_tahun}`)
                .then(response => response.json())
                .then(data => {
                    const rekapJadwalTabel = document.getElementById('rekap-jadwal');
                    rekapJadwalTabel.innerHTML = '';

                    data.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${index + 1}</td>
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.nama_prodi}</td>
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.status}</td>
                            <td class="px-2 py-1 border-b border-gray-200 text-center">
                                <button onclick="lihatDetailJadwal('${item.id_prodi}', '${id_tahun}', '${item.status}')" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">Detail</button>
                            </td>
                        `;
                        rekapJadwalTabel.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert('Terjadi kesalahan saat mengambil data.');
                });
        }

        function lihatDetailJadwal(id_prodi, id_tahun, status) {
            currentIdProdi = id_prodi;

            const detailJadwalContainer = document.getElementById('detail-jadwal-container');
            const judulDetailJadwal = document.getElementById('judul-detail-jadwal');
            const detailJadwalTabel = document.getElementById('detail-jadwal');

            detailJadwalContainer.classList.remove('hidden');
            document.getElementById('detail-prodi-action-container').classList.remove('hidden');

            // Ambil data detail dari server
            fetch(`/get-usulan-jadwal-detail/${id_tahun}/${id_prodi}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    judulDetailJadwal.innerText = `Detail Jadwal - ${data.program_studi}`;

                    detailJadwalTabel.innerHTML = '';
                    data.jadwal.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${index + 1}</td>
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.kode_mk}</td>
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.nama_mk}</td>
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.hari}</td>
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.waktu}</td>
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.ruang}</td>
                            <td class="px-2 py-1 border-b border-gray-200 text-sm text-gray-800 text-center">${item.kelas}</td>
                        `;
                        detailJadwalTabel.appendChild(row);
                    });

                    showProdiActionsDekan(id_tahun, id_prodi, data.status);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert('Terjadi kesalahan saat mengambil data.');
                });
        }

        function showProdiActionsDekan(id_tahun, id_prodi, status) {
            const actionContainer = document.getElementById('detail-prodi-action-container');
            actionContainer.classList.remove('hidden');
            actionContainer.innerHTML = '';

            // Status pada usulanjadwal adalah: Belum Diajukan, Diajukan, Disetujui, Ditolak
            if (status === 'Diajukan') {
                actionContainer.innerHTML = `
                    <button onclick="updateStatusUsulanProdiDekan('${id_tahun}', '${id_prodi}', 'Disetujui')" class="bg-green-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-600">Setujui</button>
                    <button onclick="updateStatusUsulanProdiDekan('${id_tahun}', '${id_prodi}', 'Ditolak')" class="bg-red-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-600">Tolak</button>
                `;
            } else if (status === 'Disetujui' || status === 'Ditolak') {
                // Jika sudah disetujui/ditolak, sediakan tombol untuk membatalkan (kembali ke Belum Diajukan)
                actionContainer.innerHTML = `
                    <button onclick="updateStatusUsulanProdiDekan('${id_tahun}', '${id_prodi}', 'Diajukan')" class="bg-yellow-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-yellow-600">Batalkan</button>
                `;
            } else {
                // Belum Diajukan atau status lain
                actionContainer.innerHTML = `<span class="text-gray-700 font-semibold">Usulan belum diajukan.</span>`;
            }
        }

        function updateStatusUsulanProdiDekan(id_tahun, id_prodi, status) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/usulanjadwal/${id_tahun}/${id_prodi}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ status })
            })
            .then(response => {
                if (response.ok) return response.json();
                throw new Error('Error updating status');
            })
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memperbarui status usulan prodi');
            });
        }

    </script>
</body>
</html>
