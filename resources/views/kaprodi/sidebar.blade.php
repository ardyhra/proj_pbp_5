<!-- resources/views/components/sidebar.blade.php -->

<nav class="space-y-4">
    <a href="/dashboard-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('dashboard-kaprodi') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">Dashboard</a>
    <a href="/manajemen-jadwal-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('manajemen-jadwal-kaprodi') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">Manajemen Jadwal</a>
    <a href="/monitoring-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('monitoring-kaprodi') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">Monitoring</a>
    <a href="/konsultasi-kaprodi" class="block py-2 px-3 rounded-xl hover:bg-opacity-70 {{ request()->is('konsultasi-kaprodi') ? 'bg-sky-800 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-700 hover:text-white' }}">Konsultasi</a>
</nav>
