<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKARA - Pengisian IRS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
        }
        .container {
            display: flex;
            padding-left: 250px; /* Untuk menyesuaikan dengan posisi sidebar */
            transition: padding-left 0.3s ease;
        }
        .container.fullwidth {
            padding-left: 0;
        }

        /* Sidebar styling */
        .sidebar {
            background-color: #3a86ff;
            color: white;
            width: 250px;
            height: 100vh;
            padding: 20px;
            position: fixed;
            transition: transform 0.3s ease;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .sidebar h2 {
            font-size: 24px;
            margin-bottom: 40px;
        }

        .profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-pic {
            width: 70px;
            height: 70px;
            background-color: #cfcfcf;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .profile-info h3 {
            margin-bottom: 5px;
        }

        .role {
            background-color: #6ca0ff;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
        }

        .logout {
            background-color: #ffffff;
            color: #4285f4;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            margin-top: 15px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 20px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            display: block;
            padding: 10px;
            border-radius: 5px;
        }

        .sidebar ul li a.active,
        .sidebar ul li a:hover {
            background-color: #3278cc;
        }

        /* Sidebar Toggle Button */
        .toggle-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #3a86ff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            z-index: 100;
        }

        .course-list-container {
            width: 25%;
            padding: 20px;
        }

        .content {
            width: 75%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        .content.fullwidth {
            margin-left: 0;
            width: 100%;
        }

        .header {
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .course-list {
            margin-top: 20px;
        }

        .course-list h3 {
            font-size: 1.2em;
            font-weight: bold;
            color: #555;
            margin-bottom: 10px;
        }

        .course-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #e9e9e9;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .course-option.selected {
            background-color: #c4e2ff;
        }

        .schedule-table h3 {
            font-size: 1.2em;
            font-weight: bold;
            color: #555;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sks-count {
            font-size: 1em;
            font-weight: bold;
            color: #333;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #f0f0f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            height: 60px;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
        }

        .schedule-item {
            background-color: #f0c4c4;
            border-radius: 5px;
            padding: 5px;
            margin: 5px 0;
            font-size: 0.9em;
            color: #333;
            cursor: pointer;
        }

        .disabled {
            background-color: #ddd;
            color: #888;
            pointer-events: none;
        }

        .blue {
            background-color: #c4e2ff !important;
            color: #333;
        }

        .footer {
            background-color: #3a86ff;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            left: 0;
        }

        .footer p {
            margin: 5px;
        }
    </style>
</head>
<body>

    <!-- Sidebar Toggle Button -->
    <button class="toggle-button" onclick="toggleSidebar()">☰</button>

    <!-- Sidebar -->
    <div class="sidebar hidden" id="sidebar">
        <h2>SISKARA</h2>
        <div class="profile">
            <div class="profile-pic"></div>
            <div class="profile-info">
                <h3>Budi Setiawan</h3>
                <p>NIM 24060122100102</p>
                <p class="role">Mahasiswa</p>
            </div>
            <a href="{{ url('/') }}" class="logout">Logout</a>
        </div>
        <ul>
            <li><a href="dashboard-mhs">Dashboard</a></li>
            <li><a href="pengisianirs-mhs" class="active">Pengisian IRS</a></li>
            <li><a href="irs-mhs">IRS</a></li>
        </ul>
    </div>

    <div class="container" id="mainContainer">
        <!-- Sidebar Course List -->
        <div class="course-list-container">
            <h3>Mata Kuliah Tersedia</h3>
            <div id="courseList" class="course-list">
                <div class="course-option" onclick="toggleCourse('Sistem Cerdas', 3, this)">
                    Sistem Cerdas (3 SKS)
                </div>
                <div class="course-option" onclick="toggleCourse('Grafika Komputasi Visual', 3, this)">
                    Grafika Komputasi Visual (3 SKS)
                </div>
                <div class="course-option" onclick="toggleCourse('Manajemen Basis Data', 3, this)">
                    Manajemen Basis Data (3 SKS)
                </div>
                <div class="course-option" onclick="toggleCourse('Jaringan Komputer', 3, this)">
                    Jaringan Komputer (3 SKS)
                </div>
                <div class="course-option" onclick="toggleCourse('Pemrograman Lanjut', 3, this)">
                    Pemrograman Lanjut (3 SKS)
                </div>
                <div class="course-option" onclick="toggleCourse('Keamanan Jaringan', 3, this)">
                    Keamanan Jaringan (3 SKS)
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content" id="mainContent">
            <div class="schedule-table">
                <h3>Informasi Jadwal IRS <span id="sksCount" class="sks-count">0 / 24 SKS</span></h3>
                <table>
                    <tr>
                        <th>Waktu</th>
                        <th>Senin</th>
                        <th>Selasa</th>
                        <th>Rabu</th>
                        <th>Kamis</th>
                        <th>Jumat</th>
                    </tr>
                    <tbody id="timeSlots">
                        <!-- Generate time slots dynamically from 07:00 to 18:00 -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy;2024 SISKARA</p>
        <p>Don’t Forget To Follow Diponegoro University Social Media!</p>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const container = document.getElementById("mainContainer");
            const content = document.getElementById("mainContent");

            sidebar.classList.toggle("hidden");
            container.classList.toggle("fullwidth");
            content.classList.toggle("fullwidth");
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
            element.classList.add('selected');

            courseSchedules[courseName].forEach(schedule => {
                const cell = document.getElementById(`${schedule.day}-${schedule.time}`);
                const classElement = document.createElement('div');
                classElement.className = 'schedule-item';
                classElement.innerText = `${courseName} - Kelas ${schedule.class} (${sks} SKS, ${schedule.time})`;
                classElement.onclick = () => selectClass(courseName, sks, classElement, schedule);
                cell.appendChild(classElement);
            });
        }

        function selectClass(courseName, sks, element, schedule) {
            if (selectedCourses[courseName].selectedClass) {
                const { day, time } = selectedCourses[courseName].selectedClass;
                document.getElementById(`${day}-${time}`).querySelectorAll('.schedule-item').forEach(el => {
                    if (el.innerText.includes(courseName)) {
                        el.classList.remove('blue');
                    }
                });
            }

            selectedCourses[courseName].selectedClass = schedule;
            element.classList.add('blue');
            disableConflictingClasses();
        }

        function disableConflictingClasses() {
            Object.keys(courseSchedules).forEach(course => {
                courseSchedules[course].forEach(schedule => {
                    const cell = document.getElementById(`${schedule.day}-${schedule.time}`);
                    Array.from(cell.children).forEach(el => el.classList.remove('disabled'));
                });
            });

            Object.keys(selectedCourses).forEach(courseName => {
                const selection = selectedCourses[courseName].selectedClass;
                if (selection) {
                    Object.keys(courseSchedules).forEach(course => {
                        courseSchedules[course].forEach(schedule => {
                            if (course !== courseName && schedule.day === selection.day && schedule.time === selection.time) {
                                const cell = document.getElementById(`${schedule.day}-${schedule.time}`);
                                Array.from(cell.children).forEach(el => el.classList.add('disabled'));
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
            element.classList.remove('selected');

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
                row.innerHTML = `<td>${time}</td>`;
                ["senin", "selasa", "rabu", "kamis", "jumat"].forEach(day => {
                    const cell = document.createElement('td');
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
