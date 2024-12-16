<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKARA - Pengisian IRS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animasi untuk sidebar */
        .sidebar {
            transition: transform 0.3s ease;
        }

        .sidebar-closed {
            transform: translateX(-100%);
        }

        /* Menyesuaikan konten utama saat sidebar dibuka/tutup */
        .main-content {
            transition: margin-left 0.3s ease;
        }

        .main-content-shifted {
            margin-left: 0;
        }

        /* Memastikan sidebar dan konten utama memenuhi tinggi layar */
        .flex-container {
            min-height: 100vh;
        }

        /* Mengatur lebar sidebar saat ditutup */
        .sidebar-closed {
            width: 0;
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

        .course-selected {
            background-color: #e2e8f0; /* Warna abu-abu terang */
            border-color: #0090FF;    /* Warna border gelap */
        }
        /* Tambahan styling khusus jika diperlukan */
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
                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                           d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <!-- Logo dan judul aplikasi -->
            <h1 class="text-xl font-bold">SISKARA</h1>
        </div>
        <!-- Tanggal dan Waktu Server -->
        <div id="serverDateTimeHeader" class="text-right text-sm"></div>
    </header>

    <div class="flex flex-container">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar w-1/5 bg-sky-500 h-screen p-4 text-white sidebar-closed fixed lg:static">
            <!-- Profil -->
            <div class="p-3 pb-1 bg-gray-300 rounded-3xl text-center mb-6">
                <div class="w-24 h-24 mx-auto bg-gray-400 rounded-full mb-3 bg-center bg-contain bg-no-repeat"
                    style="background-image: url(img/fsm.jpg)">
                </div>
                <h2 class="text-lg text-black font-bold">{{ $mhs->nama }}</h2>
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
        <main class="w-full lg:w-8/5 lg:ml-auto p-8" id="mainContent">
            <!-- Header Halaman -->
            <h1 class="text-4xl font-bold mb-6">Pengisian IRS</h1>

            <!-- Tanggal dan Waktu Server di Main Content (Hapus jika tidak diperlukan) -->
            <!-- <div id="serverDateTimeMain" class="text-right mb-4 text-gray-600"></div> -->

            <!-- Konten Pengisian IRS -->
            <div id="irsContent">
                <div class="flex flex-col lg:flex-row">
                    <!-- Sidebar Mata Kuliah -->
                    <div class="w-full lg:w-1/4 mb-6 lg:mb-0 lg:mr-6">
                        <h3 class="text-xl font-semibold mb-4">Informasi Mahasiswa</h3>
                        <!-- Informasi Mahasiswa -->
                        <div class="grid grid-cols-1 gap-4 mb-2">
                            <div class="bg-white p-4 rounded-lg shadow-none">
                                <p class="text-sm font-normal">Nama: <span class="font-normal">{{ $mhs->nama ?? 'Unknown' }}</span></p>
                                <p class="text-sm font-normal">NIM: <span class="font-normal">{{ $mhs->nim ?? 'Unknown' }}</span></p>
                                <p class="text-sm font-normal">Tahun Ajaran: <span class="font-normal">{{ $ta_skrg->tahun_ajaran ?? 'Unknown' }}</span></p>
                                <p class="text-sm font-normal">Semester: <span class="font-normal">{{ $mhs->semester ?? 'Unknown' }}</span></p>
                                <p class="text-sm font-normal">Status Semester Lalu: <span class="font-normal">{{ $status_lalu ?? 'Unknown' }}</span></p>
                                <p class="text-sm font-normal">IP Semester Lalu: <span class="font-normal">{{ number_format($ipslalu, 2) ?? 'Unknown' }}</span></p>
                                <p class="text-sm font-normal">Max. SKS: <span class="font-normal">{{ $maxsks ?? 'Unknown' }}</span></p>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold mb-4">Daftar Mata Kuliah</h3>
                        <!-- Pencarian Mata Kuliah -->
                        <div class="mb-4">
                            <input 
                                type="text" 
                                id="searchCourse" 
                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-200" 
                                placeholder="Cari mata kuliah..." 
                                oninput="filterCourses()">
                        </div>
                        <!-- Daftar Mata Kuliah -->
                        <div id="courseList" class="grid gap-4 overflow-y-auto bg-white p-4 rounded-lg" style="max-height: 420px;">
                            <!-- Mata kuliah akan diisi melalui JavaScript -->
                        </div>
                    </div>

                    <!-- Tabel Jadwal -->
                    <div class="w-full lg:w-3/4">
                        <h3 class="text-2xl font-semibold mb-4 flex justify-between items-center">
                            Informasi Jadwal IRS
                            <span id="sksCount" class="text-blue-600 font-bold">0 / {{ $maxsks }} SKS</span>
                        </h3>
                        <table id="scheduleTable" class="table-fixed w-full border-collapse border">
                            <!-- Konten tabel akan diisi oleh JavaScript -->
                            <thead id="timeSlots"></thead>
                            <tbody></tbody>
                        </table>
                        <div class="mt-6">
                            <button id="lockButton" onclick="lockIRS()" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Izin Perbaikan IRS -->
            <div id="requestFixButton" style="display: none;" class="text-center">
                <p class="mb-4">Masa pengisian IRS telah berakhir. Anda dapat meminta izin perbaikan IRS kepada Dosen Wali.</p>
                <button onclick="requestFix()" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">Minta Izin Perbaikan IRS</button>
            </div>

            <!-- Tombol Izin Pembatalan IRS -->
            <div id="requestCancellationButton" style="display: none;" class="text-center">
                <p class="mb-4">Masa perbaikan IRS telah berakhir. Anda dapat meminta izin pembatalan IRS kepada Dosen Wali.</p>
                <button onclick="requestCancellation()" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600">Minta Izin Pembatalan IRS</button>
            </div>

            <!-- Pesan Masa Berakhir -->
            <div id="periodOverMessage" style="display: none;" class="text-center">
                <p class="mb-4 text-red-600">Masa pengisian dan perbaikan IRS telah berakhir.</p>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4">
        <hr>
        <p class="text-sm text-center">&copy; Siskara Inc. All rights reserved.</p>
    </footer>

    <!-- Modal Popup -->
    <div id="courseModal" class="modal">
        <div class="modal-content">
            <h2 id="modalCourseName" class="text-xl font-bold mb-4">Nama Mata Kuliah</h2>
            <p id="modalCourseDetails" class="mb-4">Detail mata kuliah akan ditampilkan di sini.</p>
            <div id="modalInfoMessage" style="display: none; color: red; margin-top: 10px; font-weight: bold;"></div>
            <br>
            <div class="flex justify-end space-x-4">
                <button id="modalActionButton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Daftar</button>
                <button id="modalCancelButton" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 hidden">Keluar</button>
                <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</button>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script>
        // Simulasi Tanggal Server (untuk keperluan demo)
        let serverDate = new Date(); // Gunakan tanggal saat ini
        // Untuk pengujian, Anda bisa mengatur tanggal server secara manual
        // Contoh: let serverDate = new Date('2023-11-10');

        // Tanggal Mulai dan Berakhir Pengisian IRS
        let fillingStartDate = new Date('2024-11-01');
        let fillingEndDate = new Date('2024-12-31');

        // Tanggal untuk periode perbaikan dan pembatalan
        let twoWeeksAfterEnd = new Date(fillingEndDate.getTime() + (14 * 24 * 60 * 60 * 1000));
        let fourWeeksAfterEnd = new Date(fillingEndDate.getTime() + (28 * 24 * 60 * 60 * 1000));

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('sidebar-closed');
            // Jika Anda ingin menyesuaikan margin, tambahkan logika di sini
        }

        // Fungsi untuk menampilkan Tanggal dan Waktu Server
        function displayServerDateTime() {
            const dateTimeElement = document.getElementById('serverDateTimeHeader');
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateStr = serverDate.toLocaleDateString('id-ID', options);
            const timeStr = serverDate.toLocaleTimeString('id-ID');
            dateTimeElement.innerText = `Tanggal Server: ${dateStr}, ${timeStr}`;
        }

        // Fungsi untuk mengecek periode pengisian IRS
        function checkIRSPeriod() {
            if (serverDate <= fillingEndDate) {
                // Masa pengisian IRS masih berlangsung
                document.getElementById('irsContent').style.display = 'block';
                document.getElementById('requestFixButton').style.display = 'none';
                document.getElementById('requestCancellationButton').style.display = 'none';
                document.getElementById('periodOverMessage').style.display = 'none';
            } else if (serverDate <= twoWeeksAfterEnd) {
                // Dalam 2 minggu setelah masa pengisian berakhir
                document.getElementById('irsContent').style.display = 'none';
                document.getElementById('requestFixButton').style.display = 'block';
                document.getElementById('requestCancellationButton').style.display = 'none';
                document.getElementById('periodOverMessage').style.display = 'none';
            } else if (serverDate <= fourWeeksAfterEnd) {
                // Antara 2 hingga 4 minggu setelah masa pengisian berakhir
                document.getElementById('irsContent').style.display = 'none';
                document.getElementById('requestFixButton').style.display = 'none';
                document.getElementById('requestCancellationButton').style.display = 'block';
                document.getElementById('periodOverMessage').style.display = 'none';
            } else {
                // Lebih dari 4 minggu setelah masa pengisian berakhir
                document.getElementById('irsContent').style.display = 'none';
                document.getElementById('requestFixButton').style.display = 'none';
                document.getElementById('requestCancellationButton').style.display = 'none';
                document.getElementById('periodOverMessage').style.display = 'block';
            }
        }

        // Fungsi untuk meminta izin perbaikan IRS
        function requestFix() {
            alert('Permintaan perbaikan IRS telah dikirim ke Dosen Wali.');
            // Di sini Anda bisa menambahkan logika untuk mengirim permintaan ke server
        }

        // Fungsi untuk meminta izin pembatalan IRS
        function requestCancellation() {
            alert('Permintaan pembatalan IRS telah dikirim ke Dosen Wali.');
            // Di sini Anda bisa menambahkan logika untuk mengirim permintaan ke server
        }

        // Fungsi untuk menampilkan tanggal dan waktu secara real-time
        function startDateTimeUpdater() {
            setInterval(() => {
                serverDate = new Date(); // Update tanggal server setiap detik
                displayServerDateTime();
                checkIRSPeriod();
            }, 1000);
        }

        // Inisialisasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            displayServerDateTime();
            checkIRSPeriod();
            initializeScheduleTable();
            populateCourseList();
            startDateTimeUpdater();
        });

        // Inisialisasi SKS dan Mata Kuliah
        let locked = false;
        const maxSKS = {{ $maxsks }};
        const idTahun = {{ $ta_skrg->id_tahun }}
        const mahasiswa = @json($mhs);
        const listMatkul = @json($listmk);
        const jadwalMatkul = @json($jadwalmk);
        let currentSKS = 0;
        const selectedCourses = {};
        let matakuliah_terdaftar = [];
        let selectedCourseItem = null;
        let selectedMatkul = null;

        let schedulesByKodeMK = {};

        Object.values(jadwalMatkul).forEach(jadwal => {
            if (!schedulesByKodeMK[jadwal.kode_mk]) {
                schedulesByKodeMK[jadwal.kode_mk] = [];
            }
            schedulesByKodeMK[jadwal.kode_mk].push(jadwal);
        });
        
        function initializeScheduleTable() {
            const timeSlots = ["06:00", "07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00"];
            const days = ["senin", "selasa", "rabu", "kamis", "jumat", "sabtu"];
            const timeSlotsContainer = document.getElementById('timeSlots');

            // Tambahkan class 'table-fixed' ke tabel
            const table = document.getElementById('scheduleTable'); // Asumsikan tabel memiliki ID ini
            table.classList.add('table-fixed', 'w-full', 'border-collapse', 'border');

            // Header tabel
            const header = document.createElement('thead');
            header.className = 'bg-gray-100';

            const headerRow = document.createElement('tr');
            headerRow.innerHTML = `
                <th class="w-20 border px-4 py-2 text-center bg-blue-200">Waktu</th>
                ${days.map(day => `<th class="border px-4 py-2 text-center bg-blue-200">${day.charAt(0).toUpperCase() + day.slice(1)}</th>`).join('')}
            `;
            header.appendChild(headerRow);
            table.appendChild(header);

            // Body tabel
            const body = document.createElement('tbody');

            timeSlots.forEach((time) => {
                const row = document.createElement('tr');
                
                // Kolom pertama adalah waktu, lebih kecil dari kolom lainnya
                const timeCell = document.createElement('td');
                timeCell.className = 'border px-2 py-2 text-center font-semibold w-20';
                timeCell.textContent = time;
                row.appendChild(timeCell);

                // Kolom berikutnya adalah jadwal per hari
                days.forEach(day => {
                    const cell = document.createElement('td');
                    cell.className = 'border px-4 py-2 align-top w-auto';
                    cell.id = `${day}-${time.replace(':', '')}`; // Gunakan format 'senin-0600'
                    row.appendChild(cell);
                });

                body.appendChild(row);
            });

            table.appendChild(body);
        }

        // Fungsi untuk mengisi daftar mata kuliah
        function populateCourseList(filterQuery = '') {
            // Versi 3
            const courseList = document.getElementById('courseList');
            courseList.innerHTML = ''; // Bersihkan daftar sebelum diisi ulang

            // Jika sedang mencari, hanya tampilkan mata kuliah yang cocok
            const isSearching = filterQuery.trim() !== '';

            // Buat array yang berisi mata kuliah untuk diurutkan dan ditampilkan
            const filteredMatkul = Object.keys(listMatkul)
                .map((kode_mk) => {
                    const matkul = listMatkul[kode_mk];
                    const isSameSemester = matkul.plot_semester === mahasiswa.semester;
                    
                    const matchesQuery =
                        matkul.nama_mk.toLowerCase().includes(filterQuery.toLowerCase()) ||
                        kode_mk.toLowerCase().includes(filterQuery.toLowerCase());
                    const isRelevant = isSameSemester || selectedCourses[kode_mk] || (isSearching && matchesQuery);

                    if (!isRelevant) return null; // Abaikan jika tidak relevan

                    return {
                        kode_mk,
                        matkul,
                        isSameSemester,
                        isSelected: !!selectedCourses[kode_mk],
                        matchesQuery,
                    };
                })
                .filter((item) => item !== null) // Hapus item yang tidak relevan
                .sort((a, b) => {
                    // Urutkan hasil
                    if (isSearching) {
                        // Saat mencari, prioritaskan yang cocok dengan query
                        return b.matchesQuery - a.matchesQuery;
                    }
                    // Prioritaskan mata kuliah pada semester mahasiswa
                    return b.isSameSemester - a.isSameSemester;
                });

            // Iterasi array yang sudah difilter dan diurutkan
            filteredMatkul.forEach(({ kode_mk, matkul, isSameSemester, isSelected }) => {
                const isEnrolled = matakuliah_terdaftar.some(item => item.kode_mk === kode_mk);

                // Tentukan warna latar berdasarkan kondisi
                const bgColor = isEnrolled
                    ? 'bg-blue-300'
                    : isSelected
                    ? 'bg-gray-100'
                    : isSameSemester
                    ? 'bg-white'
                    : 'bg-gray-200';

                const courseItem = document.createElement('div');
                courseItem.className = `p-2 border rounded-lg shadow-none cursor-pointer ${bgColor} hover:bg-gray-200`;

                courseItem.dataset.kode_mk = kode_mk;
                courseItem.dataset.nama = matkul.nama_mk;

                courseItem.innerHTML = `
                    <p class="font-bold">${matkul.nama_mk} (${matkul.sks} SKS)</p>
                    <p class="text-sm text-gray-500">Kode MK: ${kode_mk}</p>
                `;

                courseItem.onclick = () => toggleCourseSelection(courseItem, matkul);

                courseList.appendChild(courseItem);
            });

            // Versi 2
            // const courseList = document.getElementById('courseList');
            // courseList.innerHTML = '';

            // Object.keys(listMatkul).forEach((kode_mk) => {
            //     const matkul = listMatkul[kode_mk];
            //     const isSameSemester = matkul.plot_semester === mahasiswa.semester;

            //     // Filter berdasarkan pencarian (query)
            //     const isMatchedByQuery = filterQuery && (matkul.nama_mk.toLowerCase().includes(filterQuery) || kode_mk.toLowerCase().includes(filterQuery));
            //     if (!isSameSemester && !isMatchedByQuery && !selectedCourses[kode_mk]) {
            //         // Jika bukan semester mahasiswa, tidak cocok dengan pencarian, dan belum dipilih, abaikan
            //         return;
            //     }

            //     const courseItem = document.createElement('div');
            //     const isEnrolled = matakuliah_terdaftar.some(item => item.kode_mk === kode_mk);
            //     const isOutsideSemester = !isSameSemester && !selectedCourses[kode_mk];

            //     courseItem.className = `p-2 border rounded-lg shadow-none cursor-pointer' ${
            //         isEnrolled ? 'bg-blue-300' : isOutsideSemester ? 'bg-gray-100'  : 'bg-white'
            //     } hover:bg-gray-200`;

            //     courseItem.dataset.kode_mk = kode_mk;
            //     courseItem.dataset.nama = matkul.nama_mk;

            //     courseItem.innerHTML = `
            //         <p class="font-bold">${matkul.nama_mk} (${matkul.sks} SKS)</p>
            //         <p class="text-sm text-gray-500">Kode MK: ${kode_mk}</p>
            //     `;

            //     courseItem.onclick = () => toggleCourseSelection(courseItem, matkul);

            //     courseList.appendChild(courseItem);
            // });

            // Versi 1
            // const courseList = document.getElementById('courseList');
            // courseList.innerHTML = ''; // Kosongkan daftar sebelum diisi ulang

            // // Iterasi mata kuliah dari data PHP (listMatkul)
            // Object.keys(listMatkul).forEach((kode_mk) => {
            //     const matkul = listMatkul[kode_mk];

            //     // Hanya tampilkan mata kuliah dengan plot semester yang sesuai dengan semester mahasiswa
            //     if (matkul.plot_semester !== {{ $mhs->semester }}) {
            //         return; // Lewati mata kuliah yang tidak sesuai plot semester
            //     }

            //     const courseItem = document.createElement('div');
            //     const isEnrolled = matakuliah_terdaftar.some(item => item.kode_mk === kode_mk);
            //     courseItem.className = `p-2 border rounded-lg shadow-none cursor-pointer ${
            //         isEnrolled ? 'bg-blue-300' : 'bg-white hover:bg-gray-100'
            //     }`;
            //     // courseItem.className = 'p-2 border rounded-lg bg-white shadow-none hover:bg-gray-100 cursor-pointer';
            //     courseItem.dataset.kode_mk = kode_mk;
            //     courseItem.dataset.nama = matkul.nama_mk;

            //     // Konten mata kuliah
            //     courseItem.innerHTML = `
            //         <p class="font-bold">${matkul.nama_mk} (${matkul.sks} SKS)</p>
            //         <p class="text-sm text-gray-500">Kode MK: ${kode_mk}</p>
            //     `;

            //     // Event saat diklik
            //     courseItem.onclick = () => toggleCourseSelection(courseItem, matkul);

            //     courseList.appendChild(courseItem);
            // });
        }

        function toggleCourseSelection(courseItem, matkul) {
            const kodeMK = courseItem.dataset.kode_mk;

            if (selectedCourses[kodeMK]) {
                // Jika sudah dipilih, hapus dari tabel dan daftar
                delete selectedCourses[kodeMK];
                courseItem.classList.remove('course-selected');
                removeCourseFromSchedule(matkul);

                // Hapus dari daftar jika bukan semester mahasiswa
                if (matkul.plot_semester !== mahasiswa.semester) {
                    courseItem.remove();
                }
            } else {
                // Jika belum dipilih, tambahkan ke tabel dan daftar
                selectedCourses[kodeMK] = matkul;
                courseItem.classList.add('course-selected');
                addCourseToSchedule(matkul);
            }
            // const kodeMK = courseItem.dataset.kode_mk;

            // if (selectedCourses[kodeMK]) {
            //     // Jika sudah dipilih, hapus dari tabel dan batalkan pemilihan
            //     delete selectedCourses[kodeMK];
            //     courseItem.classList.remove('course-selected');
            //     removeCourseFromSchedule(matkul);
            // } else {
            //     // Jika belum dipilih, tambahkan ke tabel dan tandai sebagai dipilih
            //     selectedCourses[kodeMK] = matkul;
            //     courseItem.classList.add('course-selected');
            //     addCourseToSchedule(matkul);
            // }
        }

        function addCourseToSchedule(matkul) {
            const schedules = schedulesByKodeMK[matkul.kode_mk];
            if (!schedules || schedules.length === 0) {
                alert(`Tidak ada jadwal untuk mata kuliah ${matkul.nama_mk}`);
                return;
            }

            schedules.forEach(schedule => {
                // const { hari, waktu_mulai, waktu_selesai } = schedule; 
                const cell = document.getElementById(`${schedule.hari.toLowerCase()}-${schedule.waktu_mulai.substring(0, 2) + '00'}`);
                if (cell) {
                    // Periksa apakah jadwal ini sudah terdaftar di `matakuliah_terdaftar`
                    const isRegistered = matakuliah_terdaftar.some(item => item.id_jadwal === schedule.id_jadwal);
                    const isSameClass = matakuliah_terdaftar.some(item => item.kelas !== schedule.kelas && item.kode_mk === schedule.kode_mk);

                    // Tentukan warna berdasarkan status pendaftaran
                    const bgColor = isRegistered ? 'bg-blue-300' : isSameClass ? 'bg-blue-100' : 'bg-gray-200';
                    const courseInfo = `
                        <div class="${bgColor} text-sm rounded p-1 my-1 course-item" 
                            data-id-jadwal="${schedule.id_jadwal}" data-kode-mk="${matkul.kode_mk}" 
                            data-nama="${matkul.nama_mk}" data-sks="${matkul.sks}" data-kelas="${schedule.kelas}" 
                            data-hari="${schedule.hari}" data-waktu="${schedule.waktu_mulai} - ${schedule.waktu_selesai}" 
                            data-ruang="${schedule.id_ruang}" data-kuota="${schedule.kuota}">
                            ${matkul.nama_mk} (${schedule.kelas})<br>
                            ${schedule.waktu_mulai} - ${schedule.waktu_selesai}<br>
                            Ruang: ${schedule.id_ruang}
                        </div>
                    `;
                    cell.innerHTML += courseInfo;

                    // Tambahkan event listener untuk membuka modal saat klik pada course item
                    const courseItems = cell.querySelectorAll('.course-item');
                    courseItems.forEach(courseItem => {
                        courseItem.onclick = () => openModal(courseItem);
                    });
                }
            });
        }

        function removeCourseFromSchedule(matkul) {
            const schedules = schedulesByKodeMK[matkul.kode_mk];
            if (!schedules || schedules.length === 0) return;

            schedules.forEach(schedule => {
                // const { hari, waktu_mulai } = schedule;
                const cell = document.getElementById(`${schedule.hari.toLowerCase()}-${schedule.waktu_mulai.substring(0, 2) + '00'}`);
                if (cell) {
                    // Hapus elemen terkait jadwal
                    const matkulElements = cell.querySelectorAll('div');
                    matkulElements.forEach(el => {
                        if (el.textContent.includes(matkul.nama_mk)) {
                            el.remove();
                        }
                    });
                }
            });
        }

        // Fungsi untuk memfilter daftar mata kuliah
        function filterCourses() {
            const query = document.getElementById('searchCourse').value.toLowerCase();
            populateCourseList(query);
            // const query = document.getElementById('searchCourse').value.toLowerCase();
            // const courses = document.querySelectorAll('#courseList > div');

            // courses.forEach(course => {
            //     const name = course.dataset.nama.toLowerCase();
            //     const kode = course.dataset.kode_mk.toLowerCase();
            //     if (name.includes(query) || kode.includes(query)) {
            //         course.style.display = 'block';
            //     } else {
            //         course.style.display = 'none';
            //     }
            // });
        }

        function openModal(courseItem) {
            // Ambil data dari elemen yang diklik
            const idJadwal = courseItem.dataset.idJadwal;
            const kodeMK = courseItem.dataset.kodeMk;
            const namaMK = courseItem.dataset.nama;
            const sks = parseInt(courseItem.dataset.sks, 10);
            const kelas = courseItem.dataset.kelas;
            const hari = courseItem.dataset.hari;
            const waktu = courseItem.dataset.waktu;
            const ruang = courseItem.dataset.ruang;
            const kuota = courseItem.dataset.kuota;

            // Set data ke modal
            document.getElementById('modalCourseName').innerText = `${namaMK} (${kelas})`;
            document.getElementById('modalCourseDetails').innerHTML = `
                <strong>Kode MK:</strong> ${kodeMK}<br>
                <strong>SKS:</strong> ${sks}<br>
                <strong>Hari:</strong> ${hari}<br>
                <strong>Waktu:</strong> ${waktu}<br>
                <strong>Ruang:</strong> ${ruang}<br>
                <strong>Jumlah Mahasiswa:</strong> ${kuota}
            `;

            // Set elemen yang diklik untuk menyimpan mata kuliah yang dipilih
            selectedCourseItem = courseItem;
            selectedMatkul = { id_jadwal: idJadwal, kode_mk: kodeMK, nama: namaMK, sks, kelas, hari, waktu, ruang, kuota };

            // Perbarui tampilan tombol di modal
            const modalActionButton = document.getElementById('modalActionButton');
            const cancelButton = document.getElementById('modalCancelButton');
            const modalInfoMessage = document.getElementById('modalInfoMessage');
            modalActionButton.style.display = 'none';
            cancelButton.style.display = 'none';
            modalInfoMessage.style.display = 'none';

            // Fungsi untuk memeriksa bentrok jadwal
            const schedules = schedulesByKodeMK[selectedMatkul.kode_mk].filter(schedule => 
                schedule.kelas === selectedMatkul.kelas
            );

            const isTimeConflict = (newSchedule, existingSchedule) => {
                const [newStart, newEnd] = [newSchedule.waktu_mulai, newSchedule.waktu_selesai].map(time => {
                    const [hours, minutes] = time.split(':').map(Number);
                    return hours * 60 + minutes; // Waktu dalam menit
                });

                const [existingStart, existingEnd] = [existingSchedule.waktu_mulai, existingSchedule.waktu_selesai].map(time => {
                    const [hours, minutes] = time.split(':').map(Number);
                    return hours * 60 + minutes;
                });

                return (
                    newSchedule.hari === existingSchedule.hari && // Hari yang sama
                    newStart < existingEnd && newEnd > existingStart // Ada tumpang tindih waktu
                );
            };

            // Periksa apakah salah satu jadwal dari mata kuliah yang dipilih bentrok
            const hasConflict = schedules.some(newSchedule =>
                matakuliah_terdaftar.some(existingSchedule =>
                    isTimeConflict(newSchedule, existingSchedule) && existingSchedule.kode_mk !== selectedMatkul.kode_mk
                )
            );

            // Cek apakah mahasiswa sudah terdaftar di kelas lain untuk mata kuliah ini
            const isEnrolledInSameMK = matakuliah_terdaftar.some((item) => item.kelas !== kelas && item.kode_mk === kodeMK);

            // console.log(waktu);
            console.log(matakuliah_terdaftar);

            if (hasConflict) {
                modalInfoMessage.style.display = 'block';
                modalInfoMessage.innerText = `Jadwal kelas mata kuliah bentrok dengan jadwal lain.`;
            } else if (isEnrolledInSameMK) {
                modalInfoMessage.style.display = 'block';
                modalInfoMessage.innerText = `Anda sudah terdaftar di kelas lain untuk mata kuliah ini`;
            } else {
                // Jika belum terdaftar di kelas lain, lanjutkan seperti biasa
                const isEnrolled = matakuliah_terdaftar.some((item) => item.id_jadwal == idJadwal);

                if (isEnrolled) {
                    // Jika mata kuliah sudah terdaftar, tampilkan tombol "Keluar"
                    cancelButton.style.display = 'block';
                } else if (sks > maxSKS - currentSKS) {
                    modalInfoMessage.style.display = 'block';
                    modalInfoMessage.innerText = `SKS Mata Kuliah melebih sisa batas SKS yang tersedia`;
                } else {
                    // Jika belum terdaftar, tampilkan tombol "Daftar"
                    modalActionButton.style.display = 'block';
                }
            }

            if (locked){
                modalActionButton.style.display = 'none';
                cancelButton.style.display = 'none';
                modalInfoMessage.style.display = 'none';
            }
            // Tampilkan modal
            document.getElementById('courseModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('courseModal').style.display = 'none';
        }

        function enrollCourse() {
            // Ambil semua jadwal untuk kode mata kuliah dan kelas yang sama
            const schedules = schedulesByKodeMK[selectedMatkul.kode_mk];
            const selectedSchedules = schedules.filter(schedule => schedule.kelas === selectedMatkul.kelas);

            if (selectedSchedules.length === 0) {
                alert('Jadwal mata kuliah tidak ditemukan.');
                return;
            }

            // Kirim data ke back-end menggunakan AJAX
            $.ajax({
                url: '{{ route('tambah-matkul-irs') }}',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}", // CSRF Token Laravel
                    nim: mahasiswa.nim,
                    id_Tahun: idTahun,
                    id_jadwal_list: selectedSchedules.map(schedule => schedule.id_jadwal), // Kirim semua ID jadwal
                },
                success: function (response) {
                    // Tambahkan semua jadwal ke daftar matakuliah_terdaftar
                    selectedSchedules.forEach(schedule => {
                        matakuliah_terdaftar.push({
                            nim: mahasiswa.nim,
                            id_jadwal: schedule.id_jadwal,
                            hari: schedule.hari,
                            waktu_mulai: schedule.waktu_mulai.substring(0, 5),
                            waktu_selesai: schedule.waktu_selesai.substring(0, 5),
                            kode_mk: selectedMatkul.kode_mk,
                            kelas: selectedMatkul.kelas
                        });
                    });

                    currentSKS += selectedMatkul.sks;
                    updateSKS();

                    const allCourseItems = document.querySelectorAll('[data-kode-mk="' + selectedMatkul.kode_mk + '"]');
                    allCourseItems.forEach(item => {
                        item.classList.remove('bg-gray-200');
                        if (item.dataset.kelas === selectedMatkul.kelas) {
                            item.classList.add('bg-blue-300');
                        } else {
                            item.classList.add('bg-blue-100');
                        }
                    });

                    alert(`Mata kuliah ${selectedMatkul.nama} berhasil didaftarkan.`);
                    populateCourseList();
                    closeModal();
                },
                error: function (xhr) {
                    alert(xhr.responseJSON.message || 'Gagal mendaftarkan mata kuliah.');
                    // Jika kuota penuh, berikan pesan berbeda
                    if (xhr.status === 400 && errorMessage.includes('penuh')) {
                        alert('Mata kuliah penuh. Prioritas tidak mencukupi.');
                    }
                }
            });
        }

        function disenrollCourse() {
            // Cari semua jadwal untuk kode mata kuliah dan kelas yang sama
            const schedules = schedulesByKodeMK[selectedMatkul.kode_mk];
            const selectedSchedules = schedules.filter(schedule => schedule.kelas === selectedMatkul.kelas);

            if (selectedSchedules.length === 0) {
                alert('Jadwal mata kuliah tidak ditemukan.');
                return;
            }

            // Kirim data ke back-end menggunakan AJAX
            $.ajax({
                url: '{{ route('hapus-matkul-irs') }}',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}", // CSRF Token Laravel
                    nim: mahasiswa.nim,
                    id_jadwal_list: selectedSchedules.map(schedule => schedule.id_jadwal), // Kirim semua ID jadwal
                },
                success: function (response) {
                    // Hapus jadwal dari daftar matakuliah_terdaftar
                    selectedSchedules.forEach(schedule => {
                        matakuliah_terdaftar = matakuliah_terdaftar.filter(item => item.id_jadwal !== schedule.id_jadwal);
                    });

                    currentSKS -= selectedMatkul.sks;
                    updateSKS();

                    const allCourseItems = document.querySelectorAll('[data-kode-mk="' + selectedMatkul.kode_mk + '"]');
                    allCourseItems.forEach(item => {
                        item.classList.remove('bg-blue-300');
                        item.classList.remove('bg-blue-100');
                        item.classList.add('bg-gray-200');
                    });

                    alert(`Pendaftaran mata kuliah ${selectedMatkul.nama} dibatalkan.`);
                    populateCourseList();
                    closeModal();
                },
                error: function (xhr) {
                    alert(xhr.responseJSON.message || 'Gagal membatalkan pendaftaran mata kuliah.');
                }
            });
        }

        // Menghubungkan tombol dengan fungsi
        document.getElementById('modalActionButton').onclick = enrollCourse;
        document.getElementById('modalCancelButton').onclick = disenrollCourse;

        function updateSKS() {
            document.getElementById('sksCount').innerText = `${currentSKS} / ${maxSKS} SKS`;
        }

        function lockIRS() {
            const button = document.getElementById("lockButton");

            if (locked) {
                locked = false;
                button.classList.remove("bg-red-500", "hover:bg-red-600");
                button.classList.add("bg-green-500", "hover:bg-green-600");
                button.innerText = 'Simpan';
            } else {
                locked = true;
                button.classList.remove("bg-green-500", "hover:bg-green-600");
                button.classList.add("bg-red-500", "hover:bg-red-600");
                button.innerText = 'Buka IRS';
            }
        }
    </script>

</body>
</html>
