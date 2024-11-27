<div class="w-1/4 bg-blue-300 h-screen p-5">
    <div class="flex flex-col items-center">
        <!-- Profile Section -->
        <div class="w-24 h-24 bg-gray-200 rounded-full mb-4"></div>
        <h2 class="text-xl font-bold text-center">Adit Saputra, S.Kom</h2>
        <p class="text-sm text-gray-600 text-center">NIP: 1234343413413415</p>
        <button class="bg-blue-600 text-white px-4 py-2 mt-3 rounded">Kaprodi</button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 mt-2 rounded">Logout</button>
        </form>
    </div>
    <!-- Navigation -->
    <nav class="mt-10">
        <a href="{{ route('dashboard-kaprodi') }}" class="block text-lg py-2 px-4 hover:bg-blue-400 rounded {{ request()->routeIs('dashboard-kaprodi') ? 'bg-blue-400' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('manajemen-jadwal-kaprodi.index') }}" class="block text-lg py-2 px-4 hover:bg-blue-400 rounded {{ request()->routeIs('manajemen-jadwal-kaprodi.index') ? 'bg-blue-400' : '' }}">
            Manajemen Jadwal
        </a>
        <a href="{{ route('monitoring-kaprodi') }}" class="block text-lg py-2 px-4 hover:bg-blue-400 rounded {{ request()->routeIs('monitoring-kaprodi') ? 'bg-blue-400' : '' }}">
            Monitoring
        </a>
        <a href="{{ route('konsultasi-kaprodi') }}" class="block text-lg py-2 px-4 hover:bg-blue-400 rounded {{ request()->routeIs('konsultasi-kaprodi') ? 'bg-blue-400' : '' }}">
            Konsultasi
        </a>
    </nav>
</div>
