<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKARA - Manajemen Jadwal Kaprodi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Sidebar animation and responsive behavior */
        .sidebar {
            transition: transform 0.3s ease, width 0.3s ease;
            width: 250px; /* Width when visible */
        }
        
        /* When sidebar is closed */
        .sidebar-closed {
            transform: translateX(-100%); /* Slide off screen */
            width: 0; /* Collapse sidebar width */
        }
        
        /* Make main content fill width when sidebar is hidden */
        .content-expanded {
            margin-left: 0; /* Remove left margin when sidebar is hidden */
            width: 100%; /* Full width */
        }
        
        /* Full-width main content by default on smaller screens */
        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
                width: 100%;
            }
        }

        /* Hover effect for semester buttons */
        .semester-button:hover {
            background-color: rgba(29, 78, 216, 0.7); /* Dark blue hover effect */
            color: white;
        }

        /* Apply transition for hover effect on schedule items */
        .schedule-item:hover {
            background-color: rgba(107, 114, 128, 0.3); /* Light gray hover effect */
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Header -->
    <header class="bg-gradient-to-r from-sky-500 to-blue-600 text-white p-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <button onclick="toggleSidebar()" class="focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <h1 class="text-xl font-bold">SISKARA</h1>
        </div>
    </header>

    <!-- Main container with sidebar and content -->
    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar bg-sky-500 h-screen p-4 text-white fixed lg:static">
            <div class="p-3 bg-gray-300 rounded-3xl text-center mb-6">
                <div class="w-24 h-24 mx-auto bg-gray-400 rounded-full mb-3"></div>
                <h2 class="text-lg text-black font-bold">Adit Saputra, S.Kom</h2>
                <p class="text-xs text-gray-800">NIP: 123431431431415</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Kaprodi</p>
                <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
            </div>
            <nav class="space-y-4">
                <a href="/dashboard-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('dashboard-kaprodi') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">Dashboard</a>
                <a href="/manajemen-jadwal-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('manajemen-jadwal-kaprodi') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">Manajemen Jadwal</a>
                <a href="/monitoring-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('monitoring-kaprodi') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">Monitoring</a>
                <a href="/konsultasi-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('konsultasi-kaprodi') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">Konsultasi</a></nav>
        </aside>

        <!-- Main Content -->
        <main id="main-content" class="flex-1 p-6 content lg:ml-[250px] transition-all duration-300">
            <h1 class="text-2xl font-bold mb-4">Manajemen Jadwal</h1>
            <div class="flex space-x-4 mb-4">
                <button id="ganjilBtn" onclick="showOddSemesters()" class="semester-button active px-4 py-2 rounded">2023/2024 Ganjil</button>
                <button id="genapBtn" onclick="showEvenSemesters()" class="semester-button px-4 py-2 rounded">2023/2024 Genap</button>
            </div>
            <div id="odd-semesters" class="space-y-4">
                <h2 class="text-lg font-semibold">Semester Ganjil</h2>
                <ul class="space-y-2">
                    <li class="schedule-item bg-gray-200 p-3 rounded-lg">Semester 1</li>
                    <li class="schedule-item bg-gray-200 p-3 rounded-lg">Semester 3</li>
                    <li class="schedule-item bg-gray-200 p-3 rounded-lg">Semester 5</li>
                    <li class="schedule-item bg-gray-200 p-3 rounded-lg">Semester 7</li>
                </ul>
            </div>
            <div id="even-semesters" class="space-y-4 hidden">
                <h2 class="text-lg font-semibold">Semester Genap</h2>
                <ul class="space-y-2">
                    <li class="schedule-item bg-gray-200 p-3 rounded-lg">Semester 2</li>
                    <li class="schedule-item bg-gray-200 p-3 rounded-lg">Semester 4</li>
                    <li class="schedule-item bg-gray-200 p-3 rounded-lg">Semester 6</li>
                    <li class="schedule-item bg-gray-200 p-3 rounded-lg">Semester 8</li>
                </ul>
            </div>
        </main>
    </div>
    
    <script>
        // Function to toggle sidebar visibility
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('sidebar-closed');
            mainContent.classList.toggle('content-expanded');
        }

        // Function to toggle semester views
        function showOddSemesters() {
            document.getElementById('odd-semesters').classList.remove('hidden');
            document.getElementById('even-semesters').classList.add('hidden');
            document.getElementById('ganjilBtn').classList.add('active');
            document.getElementById('genapBtn').classList.remove('active');
        }

        function showEvenSemesters() {
            document.getElementById('odd-semesters').classList.add('hidden');
            document.getElementById('even-semesters').classList.remove('hidden');
            document.getElementById('ganjilBtn').classList.remove('active');
            document.getElementById('genapBtn').classList.add('active');
        }
    </script>
</body>
</html>
