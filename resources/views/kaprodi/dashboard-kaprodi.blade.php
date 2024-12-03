<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKARA - Dashboard Kaprodi</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .flex-container { display: flex; min-height: 100vh; }
        .sidebar { transition: transform 0.3s ease; width: 20%; background-color: #0284c7; color: white; }
        .sidebar-closed { transform: translateX(-100%); }
        .main-content { flex: 1; padding: 2rem; background-color: #f3f4f6; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 font-sans">
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

    <div class="flex-container">
        <aside id="sidebar" class="sidebar p-4 sidebar-closed fixed lg:static">
            <div class="p-3 bg-gray-300 rounded-3xl text-center mb-6">
                <div class="w-24 h-24 mx-auto bg-gray-400 rounded-full mb-3"></div>
                <h2 class="text-lg text-black font-bold">Adit Saputra, S.Kom</h2>
                <p class="text-xs text-gray-800">NIP: 123431431431415</p>
                <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Kaprodi</p>
                <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
            </div>
            
            <nav class="space-y-4">
                <a href="{{ url('/dashboard-kaprodi') }}"
                    class="flex items-center space-x-2 p-2 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">
                    <span>Dashboard</span>
                </a>
                <a href="{{ url('/manajemen-jadwal-kaprodi') }}"
                    class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                    <span>Manajemen Jadwal</span>
                </a>
                <a href="{{ url('/monitoring-kaprodi') }}"
                    class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                    <span>Monitoring</span>
                </a>
                <a href="{{ url('/konsultasi-kaprodi') }}"
                    class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                    <span>Konsultasi</span>
                </a>
                @if(Auth::user()->pembimbing_akademik)
                <div class="mt-6">
                    <a href="{{ route('switch.role') }}" class="flex items-center justify-center space-x-2 p-2 bg-green-500 rounded-xl text-white hover:bg-green-600">Switch Role</a>
                </div>
                @endif
            </nav>
        </aside>

        <main class="main-content">
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

            <section class="bg-gray-200 p-6 rounded-lg mb-6">
                <h2 class="text-xl font-semibold mb-2">Tahun Ajaran</h2>
                <p class="text-2xl font-bold">2024/2025 Ganjil</p>
            </section>

            <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="p-6 bg-gray-300 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">Jumlah Ruang</h3>
                    {{-- <p class="text-4xl font-bold">{{ $jumlahRuang }}</p> --}}
                    <p class="text-4xl font-bold">10</p>
                </div>
                <div class="p-6 bg-gray-300 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">Jumlah Dosen</h3>
                    <p class="text-4xl font-bold">19</p>
                    {{-- <p class="text-4xl font-bold">{{ $jumlahDosen }}</p> --}}
                </div>
                <div class="p-6 bg-gray-300 rounded-lg text-center">
                    <h3 class="text-lg font-semibold">Jumlah Mata Kuliah</h3>
                    <p class="text-4xl font-bold">9</p>
                </div>
            </section>

            <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 bg-gray-200 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-center">Jumlah Mahasiswa</h3>
                    <canvas id="jumlahMahasiswaChart"></canvas>
                </div>
                <div class="p-6 bg-gray-200 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-center">Status Penyusunan Mata Kuliah</h3>
                    <canvas id="statusPenyusunanChart"></canvas>
                </div>
            </section>
        </main>
    </div>

    <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4 w-full">
        <hr class="mb-2">
        <p class="text-sm">&copy;2024 SISKARA</p>
        <p class="text-xs">Don't Forget Follow Diponegoro University Social Media!</p>
    </footer>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('sidebar-closed');
        }

        const jumlahMahasiswaChart = new Chart(document.getElementById('jumlahMahasiswaChart'), {
            type: 'bar',
            data: {
                labels: ['2021', '2022', '2023', '2024'],
                datasets: [{
                    label: 'Jumlah Mahasiswa',
                    data: [120, 150, 100, 200],
                    backgroundColor: ['#0284c7', '#034b6c', '#82c8e0', '#a1d6e2']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        const statusPenyusunanChart = new Chart(document.getElementById('statusPenyusunanChart'), {
            type: 'doughnut',
            data: {
                labels: ['Scheduled', 'Not Scheduled'],
                datasets: [{
                    data: [52, 48],
                    backgroundColor: ['#0284c7', '#f5b700']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    </script>
</body>
</html>


