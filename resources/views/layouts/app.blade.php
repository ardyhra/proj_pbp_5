<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SISKARA - Dashboard Kaprodi')</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .flex-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            transition: width 0.3s ease;
            background-color: #0284c7;
            color: white;
            overflow: hidden;
        }

        .sidebar-closed {
            width: 0;
            padding: 0;
            transform: translateX(-100%); 
            transition: width 1s ease;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            background-color: #f3f4f6;
            transition: margin 0.3s ease;
        }

        .toggle-btn {
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <header class="bg-gradient-to-r from-sky-500 to-blue-600 text-white p-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <button onclick="toggleSidebar()" class="toggle-btn">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <h1 class="text-xl font-bold">SISKARA</h1>
        </div>
    </header>

    <!-- Container Utama -->
    <div class="flex-container">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar p-4">
            <div class="p-3 pb-1 bg-gray-300 rounded-3xl text-center mb-6">
                <div class="w-24 h-24 mx-auto bg-gray-400 rounded-full mb-3 bg-center bg-contain bg-no-repeat"
                     style="background-image: url({{ asset('img/fsm.jpg') }})"></div>
                <h2 class="text-lg text-black font-bold">Dr. Aris Sugiharto, S.Si., M.Kom.</h2>
                <p class="text-xs text-gray-800">NIDN 0011087104</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Kaprodi</p>
                <a href="{{ route('login') }}" 
                   class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">
                   Logout
                </a>
            </div>

            <!-- Navigation -->
            <!-- Navigation -->
            <nav class="space-y-4">
                <a href="{{ url('/dashboard-kaprodi') }}"
                   class="flex items-center space-x-2 p-2 rounded-xl 
                   {{ request()->is('dashboard-kaprodi') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">
                    <span>Dashboard</span>
                </a>
                <a href="{{ url('/manajemen-matkul-kaprodi') }}"
                   class="flex items-center space-x-2 p-2 rounded-xl 
                   {{ request()->is('manajemen-matkul-kaprodi*') || request()->is('matkul*') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">
                    <span>Manajemen Mata Kuliah</span>
                </a>
                <a href="{{ url('/manajemen-jadwal-kaprodi') }}"
                   class="flex items-center space-x-2 p-2 rounded-xl 
                   {{ request()->is('manajemen-jadwal-kaprodi*') || request()->is('jadwal*') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">
                    <span>Manajemen Jadwal</span>
                </a>
                <a href="{{ url('/rekapjadwal') }}"
                   class="flex items-center space-x-2 p-2 rounded-xl 
                   {{ request()->is('rekapjadwal*') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">
                    <span>Rekap Jadwal</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4">
        <hr class="mb-2">
        <p class="text-sm">&copy;2024 SISKARA</p>
        <p class="text-xs">Don't Forget Follow Diponegoro University Social Media!</p>
    </footer>

    <!-- Script Toggle Sidebar -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-closed');
        }
    </script>
</body>
</html>
