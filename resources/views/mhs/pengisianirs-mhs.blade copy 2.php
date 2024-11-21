<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
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

        /* Tambahan styling khusus jika diperlukan */
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
            <a href="{{ url('/dashboard-mhs') }}"
                class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                <span>Transkrip</span>
            </a>
            <a href="{{ url('/dashboard-mhs') }}"
                class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                <span>Konsultasi</span>
            </a>
        </nav>
      </aside>

        <!-- Main Content -->
        <main class="w-full lg:w-4/5 lg:ml-auto p-8" id="mainContent">
            <!-- Header Halaman -->
            <h1 class="text-3xl font-bold mb-6">Pengisian IRS</h1>

            <!-- Konten Pengisian IRS -->
            <div class="flex flex-col lg:flex-row">
                <!-- Sidebar Mata Kuliah -->
                <div class="w-full lg:w-1/4 mb-6 lg:mb-0 lg:mr-6">
                    <h3 class="text-xl font-semibold mb-4">Mata Kuliah Tersedia</h3>
                    <div id="courseList" class="space-y-2">
                        <div class="course-option bg-gray-200 p-3 rounded-lg cursor-pointer hover:bg-blue-200"
                             onclick="toggleCourse('Sistem Cerdas', 3, this)">
                            Sistem Cerdas (3 SKS)
                        </div>
                        <div class="course-option bg-gray-200 p-3 rounded-lg cursor-pointer hover:bg-blue-200"
                             onclick="toggleCourse('Grafika Komputasi Visual', 3, this)">
                            Grafika Komputasi Visual (3 SKS)
                        </div>
                        <div class="course-option bg-gray-200 p-3 rounded-lg cursor-pointer hover:bg-blue-200"
                             onclick="toggleCourse('Manajemen Basis Data', 3, this)">
                            Manajemen Basis Data (3 SKS)
                        </div>
                        <div class="course-option bg-gray-200 p-3 rounded-lg cursor-pointer hover:bg-blue-200"
                             onclick="toggleCourse('Jaringan Komputer', 3, this)">
                            Jaringan Komputer (3 SKS)
                        </div>
                        <div class="course-option bg-gray-200 p-3 rounded-lg cursor-pointer hover:bg-blue-200"
                             onclick="toggleCourse('Pemrograman Lanjut', 3, this)">
                            Pemrograman Lanjut (3 SKS)
                        </div>
                        <div class="course-option bg-gray-200 p-3 rounded-lg cursor-pointer hover:bg-blue-200"
                             onclick="toggleCourse('Keamanan Jaringan', 3, this)">
                            Keamanan Jaringan (3 SKS)
                        </div>
                    </div>
                </div>

                <!-- Tabel Jadwal -->
                <div class="w-full lg:w-3/4">
                    <h3 class="text-2xl font-semibold mb-4 flex justify-between items-center">
                        Informasi Jadwal IRS
                        <span id="sksCount" class="text-blue-600 font-bold">0 / 24 SKS</span>
                    </h3>
                    <table class="w-full bg-gray-50 rounded-lg shadow-md">
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
                </div>
            </div>
        </main>
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
                classElement.className = 'schedule-item bg-red-200 rounded-md p-2 mb-2 cursor-pointer';
                classElement.innerText = `${courseName} - Kelas ${schedule.class}`;
                classElement.onclick = () => selectClass(courseName, sks, classElement, schedule);
                cell.appendChild(classElement);
            });
        }

        function selectClass(courseName, sks, element, schedule) {
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

        function disableConflictingClasses() {
            Object.keys(courseSchedules).forEach(course => {
                courseSchedules[course].forEach(schedule => {
                    const cell = document.getElementById(`${schedule.day}-${schedule.time}`);
                    Array.from(cell.children).forEach(el => el.classList.remove('opacity-50', 'pointer-events-none'));
                });
            });

            Object.keys(selectedCourses).forEach(courseName => {
                const selection = selectedCourses[courseName].selectedClass;
                if (selection) {
                    Object.keys(courseSchedules).forEach(course => {
                        courseSchedules[course].forEach(schedule => {
                            if (course !== courseName && schedule.day === selection.day && schedule.time === selection.time) {
                                const cell = document.getElementById(`${schedule.day}-${schedule.time}`);
                                Array.from(cell.children).forEach(el => {
                                    el.classList.add('opacity-50', 'pointer-events-none');
                                });
                            }
                        });
                    });
                }
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

        initializeScheduleTable();
    </script>

</body>
</html>
