


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKARA - Dashboard Kaprodi</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Reset margin dan padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Flex container untuk layout */
        .flex-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 20%; /* Lebar sidebar */
            background-color: #0284c7;
            color: white;
            transition: width 0.5s ease;
            overflow: hidden; /* Sembunyikan konten saat lebar 0 */
            flex-shrink: 0; /* Sidebar tidak mengecil */
        }

        .sidebar-closed {
            width: 0; /* Sidebar tertutup sempurna */
            padding: 0; /* Hapus padding */
            margin: 0; /* Hapus margin */
            transform: translateX(-100%); 
        }

        /* Main content */
        .main-content {
            flex: 1; /* Mengisi seluruh ruang sisa */
            background-color: #f3f4f6;
            padding: 1rem; /* Tambahkan padding */
            transition: all 0.5s ease;
            margin-left: 0; /* Pastikan tidak ada margin kiri */
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: linear-gradient(to right, #0284c7, #027bb5);
            color: white;
        }

        /* Tombol toggle */
        .toggle-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <header class="bg-gradient-to-r from-sky-500 to-blue-600 text-white p-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <button onclick="toggleSidebar()" class="toogle-btn">
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
            <!-- Profil -->
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
            <nav class="space-y-4">
                <a href="{{ url('/dashboard-kaprodi') }}" class="flex items-center space-x-2 p-2 bg-sky-800 text-white rounded hover:bg-sky-600">
                    Dashboard
                </a>
                <a href="{{ url('/manajemen-jadwal-kaprodi') }}" class="flex items-center space-x-2 p-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-700 hover:text-white">
                    Manajemen Jadwal
                </a>
                <a href="{{ url('/rekapjadwal') }}" class="flex items-center space-x-2 p-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-700 hover:text-white">
                    Rekap Jadwal
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <h1 class="text-3xl font-bold mb-6">Dashboard Kaprodi</h1>
            <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="p-4 bg-gray-200 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">Jumlah Ruang</h3>
                    <p class="text-2xl font-bold">26</p>
                </div>
                <div class="p-4 bg-gray-200 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">Jumlah Dosen</h3>
                    <p class="text-2xl font-bold">39</p>
                </div>
                <div class="p-4 bg-gray-200 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">Jumlah Mata Kuliah</h3>
                    <p class="text-2xl font-bold">79</p>
                </div>
            </section>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4">
        <p class="text-sm">&copy;2024 SISKARA</p>
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
