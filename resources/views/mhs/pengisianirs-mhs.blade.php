<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
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

        /* Tambahan styling khusus jika diperlukan */
    </style>
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
            <!-- Logo dan judul aplikasi -->
            <h1 class="text-xl font-bold">SISKARA</h1>
        </div>
        <!-- Tanggal dan Waktu Server -->
        <div id="serverDateTimeHeader" class="text-right text-sm"></div>
    </header>

    <div class="flex flex-container">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar w-1/5 bg-sky-500 p-4 text-white flex-none sidebar fixed lg:static">
            <!-- Profil -->
            <div class="p-3 pb-1 bg-gray-300 rounded-3xl text-center mb-6">
                <div class="w-24 h-24 mx-auto bg-gray-400 rounded-full mb-3 bg-center bg-contain bg-no-repeat"
                    style="background-image: url(img/fsm.jpg)">
                </div>
                <h2 class="text-lg text-black font-bold">Budi</h2>
                <p class="text-xs text-gray-800">NIM 24060122120033</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Mahasiswa</p>
                <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
            </div>
            <nav class="space-y-4">
                <a href="{{ url('/dashboard-mhs') }}"
                  class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                    <span>Dashboard</span>
                </a>
                <a href="{{ url('/pengisianirs-mhs') }}"
                  class="flex items-center space-x-2 p-2 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">
                    <span>Pengisian IRS</span>
                </a>
                <a href="{{ url('/irs-mhs') }}"
                  class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                    <span>IRS</span>
                </a>
                <a href="{{ url('/dashboard-mhs') }}"
                    class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                    <span>KHS</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content p-8 flex-1" id="mainContent">
            <!-- Header Halaman -->
            <h1 class="text-3xl font-bold mb-6">Pengisian IRS</h1>

            <!-- Tanggal dan Waktu Server di Main Content (Hapus jika tidak diperlukan) -->
            <!-- <div id="serverDateTimeMain" class="text-right mb-4 text-gray-600"></div> -->

            <!-- Konten Pengisian IRS -->
            <div id="irsContent">
                <div class="flex flex-col lg:flex-row">
                    <!-- Sidebar Mata Kuliah -->
                    <div class="w-full lg:w-1/4 mb-6 lg:mb-0 lg:mr-6">
                        <h3 class="text-xl font-semibold mb-4">Mata Kuliah Tersedia</h3>
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
                        <div id="courseList" class="space-y-2">
                            <!-- Mata kuliah akan diisi melalui JavaScript -->
                        </div>
                    </div>

                    <!-- Tabel Jadwal -->
                    <div class="w-full lg:w-3/4">
                        <h3 class="text-2xl font-semibold mb-4 flex justify-between items-center">
                            Informasi Jadwal IRS
                            <span id="sksCount" class="text-blue-600 font-bold">0 / 24 SKS</span>
                        </h3>
                        <table class="w-full bg-gray-50 rounded-lg shadow-md">
                            <!-- Konten tabel akan diisi oleh JavaScript -->
                            <thead>
                                <tr class="bg-blue-200">
                                    <th class="py-3 px-4 text-left">Waktu</th>
                                    <th class="py-3 px-4 text-left">Senin</th>
                                    <th class="py-3 px-4 text-left">Selasa</th>
                                    <th class="py-3 px-4 text-left">Rabu</th>
                                    <th class="py-3 px-4 text-left">Kamis</th>
                                    <th class="py-3 px-4 text-left">Jumat</th>
                                </tr>
                            </thead>
                            <tbody id="timeSlots">
                                <!-- Time slots akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                        <!-- Tombol Simpan -->
                        <div class="mt-6">
                            <button onclick="saveIRS()" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600">Simpan</button>
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
            <div class="flex justify-end space-x-4">
                <button id="modalActionButton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Daftar</button>
                <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</button>
            </div>
        </div>
    </div>

    <!-- Script -->
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
        const maxSKS = 24;
        let currentSKS = 0;
        const selectedCourses = {};
        const courseSchedules = {
            "Sistem Cerdas": [
                { day: "senin", time: "07:00 - 09:30", class: "A", sks: 3 },
                { day: "selasa", time: "09:30 - 12:00", class: "B", sks: 3 },
                { day: "rabu", time: "12:30 - 15:00", class: "C", sks: 3 },
                { day: "kamis", time: "15:00 - 17:30", class: "D", sks: 3 }
            ],
            "Grafika Komputasi Visual": [
                { day: "selasa", time: "07:00 - 09:30", class: "A", sks: 3 },
                { day: "rabu", time: "09:30 - 12:00", class: "B", sks: 3 },
                { day: "kamis", time: "12:30 - 15:00", class: "C", sks: 3 },
                { day: "jumat", time: "15:00 - 17:30", class: "D", sks: 3 }
            ],
            "Manajemen Basis Data": [
                { day: "rabu", time: "07:00 - 09:30", class: "A", sks: 3 },
                { day: "kamis", time: "09:30 - 12:00", class: "B", sks: 3 },
                { day: "jumat", time: "12:30 - 15:00", class: "C", sks: 3 },
                { day: "senin", time: "15:00 - 17:30", class: "D", sks: 3 }
            ],
            "Jaringan Komputer": [
                { day: "kamis", time: "07:00 - 09:30", class: "A", sks: 3 },
                { day: "jumat", time: "09:30 - 12:00", class: "B", sks: 3 },
                { day: "senin", time: "12:30 - 15:00", class: "C", sks: 3 },
                { day: "selasa", time: "15:00 - 17:30", class: "D", sks: 3 }
            ],
            "Pemrograman Lanjut": [
                { day: "senin", time: "07:00 - 09:30", class: "A", sks: 3 },
                { day: "selasa", time: "09:30 - 12:00", class: "B", sks: 3 },
                { day: "rabu", time: "12:30 - 15:00", class: "C", sks: 3 },
                { day: "jumat", time: "15:00 - 17:30", class: "D", sks: 3 }
            ],
            "Keamanan Jaringan": [
                { day: "rabu", time: "07:00 - 09:30", class: "A", sks: 3 },
                { day: "kamis", time: "09:30 - 12:00", class: "B", sks: 3 },
                { day: "jumat", time: "12:30 - 15:00", class: "C", sks: 3 },
                { day: "senin", time: "15:00 - 17:30", class: "D", sks: 3 }
            ]
        };

        function updateSKS() {
            document.getElementById('sksCount').innerText = `${currentSKS} / ${maxSKS} SKS`;
        }

        function toggleCourse(courseName, sks, element) {
            if (selectedCourses[courseName]) {
                removeCourse(courseName, element);
            } else if (currentSKS + sks <= maxSKS) {
                addCourse(courseName, sks, element);
            } else {
                alert('SKS maksimum tercapai.');
            }
        }

        function addCourse(courseName, sks, element) {
            selectedCourses[courseName] = { sks, selectedClass: null };
            currentSKS += sks;
            updateSKS();
            element.classList.add('bg-blue-200');

            courseSchedules[courseName].forEach(schedule => {
                const cell = document.getElementById(`${schedule.day}-${schedule.time}`);
                const classElement = document.createElement('div');
                classElement.className = 'schedule-item bg-red-200 rounded-md p-2 mb-2 cursor-pointer hover:bg-blue-200';
                classElement.innerText = `${courseName} - Kelas ${schedule.class}`;
                classElement.onclick = () => openCourseModal(courseName, sks, classElement, schedule);
                cell.appendChild(classElement);
            });
        }

        function removeCourse(courseName, element) {
            if (!selectedCourses[courseName]) return;
            const sks = selectedCourses[courseName].sks;
            currentSKS -= sks;
            updateSKS();
            element.classList.remove('bg-blue-200');

            courseSchedules[courseName].forEach(schedule => {
                const cell = document.getElementById(`${schedule.day}-${schedule.time}`);
                Array.from(cell.children).forEach(child => {
                    if (child.innerText.includes(courseName)) {
                        cell.removeChild(child);
                    }
                });
            });

            delete selectedCourses[courseName];
            disableConflictingClasses();
        }

        function openCourseModal(courseName, sks, element, schedule) {
            const modal = document.getElementById('courseModal');
            const modalCourseName = document.getElementById('modalCourseName');
            const modalCourseDetails = document.getElementById('modalCourseDetails');
            const modalActionButton = document.getElementById('modalActionButton');

            modalCourseName.innerText = `${courseName} - Kelas ${schedule.class}`;
            modalCourseDetails.innerText = `Detail mata kuliah ${courseName} akan ditampilkan di sini.\nWaktu: ${schedule.time}\nSKS: ${sks}`;

            if (selectedCourses[courseName].selectedClass && selectedCourses[courseName].selectedClass.class === schedule.class) {
                modalActionButton.innerText = 'Batal';
                modalActionButton.onclick = () => {
                    deselectClass(courseName, element, schedule);
                    closeModal();
                };
            } else {
                modalActionButton.innerText = 'Daftar';
                modalActionButton.onclick = () => {
                    selectClass(courseName, element, schedule);
                    closeModal();
                };
            }

            modal.style.display = 'block';
        }

        function closeModal() {
            document.getElementById('courseModal').style.display = 'none';
        }

        function selectClass(courseName, element, schedule) {
            if (selectedCourses[courseName].selectedClass) {
                const { day, time } = selectedCourses[courseName].selectedClass;
                document.getElementById(`${day}-${time}`).querySelectorAll('.schedule-item').forEach(el => {
                    if (el.innerText.includes(courseName)) {
                        el.classList.remove('bg-blue-400');
                    }
                });
            }

            selectedCourses[courseName].selectedClass = schedule;
            element.classList.add('bg-blue-400');
            disableConflictingClasses();
        }

        function deselectClass(courseName, element, schedule) {
            selectedCourses[courseName].selectedClass = null;
            element.classList.remove('bg-blue-400');
            disableConflictingClasses();
        }

        function disableConflictingClasses() {
            // Hapus semua state konflik sebelumnya
            Object.keys(courseSchedules).forEach(course => {
                courseSchedules[course].forEach(schedule => {
                    const cell = document.getElementById(`${schedule.day}-${schedule.time}`);
                    Array.from(cell.children).forEach(el => {
                        el.classList.remove('opacity-50', 'pointer-events-none');
                    });
                });
            });

            // Cek konflik untuk semua mata kuliah yang sudah dipilih
            Object.keys(selectedCourses).forEach(courseName => {
                const selection = selectedCourses[courseName].selectedClass;
                if (selection) {
                    Object.keys(courseSchedules).forEach(course => {
                        courseSchedules[course].forEach(schedule => {
                            // Jika ada bentrok, tambahkan state konflik kecuali untuk mata kuliah yang dipilih
                            if (course !== courseName && schedule.day === selection.day && schedule.time === selection.time) {
                                const cell = document.getElementById(`${schedule.day}-${schedule.time}`);
                                Array.from(cell.children).forEach(el => {
                                    // Hanya tambahkan pointer-events: none jika bukan mata kuliah yang dipilih
                                    if (!el.innerText.includes(courseName)) {
                                        el.classList.add('opacity-50', 'pointer-events-none');
                                    }
                                });
                            }
                        });
                    });
                }
            });
        }

        function initializeScheduleTable() {
            const timeSlots = ["07:00 - 09:30", "09:30 - 12:00", "12:30 - 15:00", "15:00 - 17:30"];
            const timeSlotsContainer = document.getElementById('timeSlots');
            timeSlots.forEach((time) => {
                const row = document.createElement('tr');
                row.innerHTML = `<td class="border px-4 py-2 font-semibold">${time}</td>`;
                ["senin", "selasa", "rabu", "kamis", "jumat"].forEach(day => {
                    const cell = document.createElement('td');
                    cell.className = 'border px-4 py-2 align-top';
                    cell.id = `${day}-${time}`;
                    row.appendChild(cell);
                });
                timeSlotsContainer.appendChild(row);
            });
        }

        function saveIRS() {
            // Di sini Anda dapat menambahkan logika untuk menyimpan IRS
            alert('IRS berhasil disimpan!');
        }

        function populateCourseList() {
            const courseList = document.getElementById('courseList');
            courseList.innerHTML = ''; // Pastikan daftar bersih sebelum mengisi ulang
            Object.keys(courseSchedules).forEach(courseName => {
                const sks = courseSchedules[courseName][0].sks; // Asumsi semua sks sama
                const courseElement = document.createElement('div');
                courseElement.className = 'course-option bg-gray-200 p-3 rounded-lg cursor-pointer hover:bg-blue-200 flex justify-between items-center';
                courseElement.innerHTML = `
                    <span>${courseName} (${sks} SKS)</span>
                    <button 
                        onclick="removeAvailableCourse(event, '${courseName}')" 
                        class="text-red-500 text-sm hover:underline">
                        Hapus
                    </button>
                `;
                courseElement.onclick = (e) => {
                    // Hindari memicu klik tombol hapus
                    if (e.target.tagName.toLowerCase() !== 'button') {
                        toggleCourse(courseName, sks, courseElement);
                    }
                };
                courseList.appendChild(courseElement);
            });
        }

        // Fungsi pencarian mata kuliah
        function filterCourses() {
            const searchTerm = document.getElementById("searchCourse").value.toLowerCase();
            const courseList = document.getElementById("courseList");
            const courses = courseList.getElementsByClassName("course-option");

            Array.from(courses).forEach(course => {
                const courseName = course.querySelector("span").innerText.toLowerCase();
                if (courseName.includes(searchTerm)) {
                    course.style.display = "";
                } else {
                    course.style.display = "none";
                }
            });
        }

        // Fungsi untuk menghapus mata kuliah dari daftar tersedia
        function removeAvailableCourse(event, courseName) {
            event.stopPropagation(); // Hindari memicu klik pada elemen induk
            const courseList = document.getElementById("courseList");
            const courses = courseList.getElementsByClassName("course-option");

            Array.from(courses).forEach(course => {
                const span = course.querySelector("span");
                if (span && span.innerText.includes(courseName)) {
                    course.remove();
                }
            });
        }

        // Fungsi untuk menambahkan mata kuliah secara dinamis
        // Anda bisa menambahkan ini jika ingin menambah mata kuliah dari pencarian
    </script>

</body>
</html>
