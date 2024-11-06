<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKARA</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-1/4 bg-blue-500 text-white p-4 min-h-screen">
            <h2 class="text-2xl font-semibold">SISKARA</h2>
            <div class="mt-8">
                <div class="text-lg mb-4">Adit Saputra, S.Kom</div>
                <button class="bg-gray-300 text-black p-2 w-full">Logout</button>
            </div>
            <nav class="mt-8">
                <ul>
                    <li><a href="{{ url('/dashboard-kaprodi') }}" class="block py-2 hover:bg-blue-600">Dashboard</a></li>
                    <li><a href="{{ url('/manajemen-jadwal') }}" class="block py-2 hover:bg-blue-600">Manajemen Jadwal</a></li>
                    <li><a href="{{ url('/monitoring') }}" class="block py-2 hover:bg-blue-600">Monitoring</a></li>
                    <li><a href="{{ url('/konsultasi') }}" class="block py-2 hover:bg-blue-600">Konsultasi</a></li>
                </ul>
            </nav>
        </div>

        <!-- Content -->
        <div class="w-3/4 p-8">
            @yield('content')
        </div>
    </div>
</body>
</html>