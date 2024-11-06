<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISKARA Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Main Container -->
    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside class="w-1/4 bg-blue-500 text-white flex flex-col p-4">
            <div class="flex items-center mb-8">
                <div class="bg-gray-300 rounded-full w-16 h-16 mr-4"></div>
                <div>
                    <h2 class="font-bold text-lg">Budi, S.Kom</h2>
                    <p class="text-sm">NIP: 123431431431415</p>
                    <button class="bg-blue-200 text-blue-900 py-1 px-4 mt-2 rounded">Bagian Akademik</button>
                </div>
            </div>
            <nav class="space-y-4">
                <a href="#" class="block text-gray-100 bg-gray-500 rounded-lg py-2 px-4">Dashboard</a>
                <a href="#" class="block text-gray-100 py-2 px-4">Buat Usulan</a>
                <a href="#" class="block text-gray-100 py-2 px-4">Daftar Usulan</a>
            </nav>
            <button class="mt-auto bg-white text-blue-500 py-2 px-4 rounded-lg">Logout</button>
        </aside>

        <!-- Main Content -->
        <main class="w-3/4 p-8">
            <!-- Header -->
            <header class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <nav class="space-x-4 text-gray-600">
                    <a href="#">Home</a>
                    <a href="#">About</a>
                    <a href="#">Profile</a>
                </nav>
            </header>

            <!-- Academic Year Card -->
            <div class="bg-gray-200 p-4 rounded-lg mb-8">
                <h2 class="text-lg font-semibold">Tahun Ajaran</h2>
                <p class="text-2xl font-bold">2024/2025 Ganjil</p>
            </div>

            <!-- Statistics Section -->
            <div class="grid grid-cols-2 gap-8 mb-8">
                <!-- Classroom Usage Stats -->
                <div class="bg-gray-200 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold">Jumlah Ruang Kuliah Terpakai</h2>
                    <p class="text-4xl font-bold">15</p>
                </div>
                <div class="bg-gray-200 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold">Jumlah Ruang Kuliah Tidak Terpakai</h2>
                    <p class="text-4xl font-bold">3</p>
                </div>
                <div class="bg-gray-200 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold">Persentase Ruang Kuliah Terpakai</h2>
                    <p class="text-4xl font-bold">83%</p>
                </div>

                <!-- Classroom Capacity Stats -->
                <div class="bg-gray-200 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold">Total Kapasitas Ruang</h2>
                    <p class="text-4xl font-bold">675</p>
                </div>
                <div class="bg-gray-200 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold">Rerata Kapasitas Tiap Ruang</h2>
                    <p class="text-4xl font-bold">45</p>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-500 text-white text-center py-4">
        <p>&copy; 2024 SISKARA</p>
        <p>Don't Forget To Follow Diponegoro University Social Media!</p>
        <div class="flex justify-center space-x-4 mt-2">
            <a href="#" class="text-white">Facebook</a>
            <a href="#" class="text-white">YouTube</a>
            <a href="#" class="text-white">Instagram</a>
        </div>
    </footer>

</body>
</html>
