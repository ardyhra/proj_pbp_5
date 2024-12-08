
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SISKARA - Dashboard Kaprodi')</title>
    
    <!-- Vite CSS -->
    @vite('resources/css/app.css') <!-- Pastikan ini berfungsi dengan baik untuk menggabungkan file CSS -->
    
    <!-- CDN TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bisa menambahkan lebih banyak CSS atau JavaScript jika diperlukan -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex flex-col">
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

        <div class="flex flex-1">
            <!-- Sidebar -->
            <aside id="sidebar" class="sidebar w-64 bg-blue-600 text-white p-6 transition-transform transform lg:relative fixed">
                <div class="p-3 bg-gray-300 rounded-3xl text-center mb-6">
                    <div class="w-24 h-24 mx-auto bg-gray-400 rounded-full mb-3"></div>
                    <h2 class="text-lg text-black font-bold">Adit Saputra, S.Kom</h2>
                    <p class="text-xs text-gray-800">NIP: 123431431431415</p>
                    <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Kaprodi</p>
                    <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
                </div>

                <nav class="space-y-4">
                    <a href="{{ url('/dashboard-kaprodi') }}" class="flex items-center space-x-2 p-2 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ url('/manajemen-jadwal-kaprodi') }}" class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                        <span>Manajemen Jadwal</span>
                    </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-8">
                <!-- Page content will be injected here -->
                @yield('content')
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4 w-full">
            <hr class="mb-2">
            <p class="text-sm">&copy;2024 SISKARA</p>
            <p class="text-xs">Don't Forget Follow Diponegoro University Social Media!</p>
        </footer>
    </div>

    <!-- JavaScript untuk Sidebar Toggle -->
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('sidebar-closed');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
