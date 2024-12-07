{{-- FIX DATA DUMMY --}}
{{-- @extends('layouts.app')

@section('title', 'Monitoring Kaprodi')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4">Monitoring</h1>

    <!-- Dropdown untuk Menampilkan Angkatan -->
    <div class="mb-6">
        <label for="angkatan" class="block font-semibold mb-2">Pilih Angkatan</label>
        <select id="angkatan" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="handleChange()">
            <option value="2024">Angkatan 2024</option>
            <option value="2023">Angkatan 2023</option>
            <option value="2022">Angkatan 2022</option>
            <option value="2021">Angkatan 2021</option>
        </select>
    </div>

    <!-- Tabel Data berdasarkan Angkatan -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Nama Pembimbing Akademik</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Jumlah Mahasiswa yang sudah mengisi IRS</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Persentase</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="data-tbody">
                <!-- Data monitoring akan ditampilkan di sini berdasarkan pilihan angkatan -->
                <tr>
                    <td colspan="5" class="text-center py-4">Pilih angkatan untuk melihat data.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Fungsi untuk menangani perubahan pilihan angkatan
    function handleChange() {
        const angkatan = document.getElementById('angkatan').value;

        // Data dummy berdasarkan angkatan yang dipilih
        const data = {
            '2024': [
                { nama_pembimbing: 'Udin Saripudin', jumlah_isi: 20, total_mahasiswa: 40, persentase: 50, id: 1 },
                { nama_pembimbing: 'Adi Wibowo', jumlah_isi: 40, total_mahasiswa: 40, persentase: 100, id: 2 },
            ],
            '2023': [
                { nama_pembimbing: 'Budi Santoso', jumlah_isi: 30, total_mahasiswa: 40, persentase: 75, id: 3 },
                { nama_pembimbing: 'Sari Agustin', jumlah_isi: 20, total_mahasiswa: 40, persentase: 50, id: 4 },
            ],
            '2022': [
                { nama_pembimbing: 'Rudi Susanto', jumlah_isi: 25, total_mahasiswa: 40, persentase: 62, id: 5 },
                { nama_pembimbing: 'Lina Wijaya', jumlah_isi: 15, total_mahasiswa: 40, persentase: 37, id: 6 },
            ],
            '2021': [
                { nama_pembimbing: 'Joko Widodo', jumlah_isi: 10, total_mahasiswa: 40, persentase: 25, id: 7 },
                { nama_pembimbing: 'Rina Agustina', jumlah_isi: 35, total_mahasiswa: 40, persentase: 87, id: 8 },
            ],
        };

        // Ambil data berdasarkan angkatan yang dipilih
        const selectedData = data[angkatan] || [];

        // Temukan tbody untuk menampilkan data
        const tbody = document.getElementById('data-tbody');
        tbody.innerHTML = ''; // Kosongkan isi tbody

        if (selectedData.length > 0) {
            selectedData.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = index % 2 === 0 ? 'bg-gray-100' : '';
                row.innerHTML = `
                    <td class="border border-gray-300 px-4 py-2 text-center">${index + 1}</td>
                    <td class="border border-gray-300 px-4 py-2">${item.nama_pembimbing}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">${item.jumlah_isi}/${item.total_mahasiswa}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <span class="font-bold ${item.persentase == 100 ? 'text-green-500' : 'text-red-500'}">
                            ${item.persentase}%
                        </span>
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <!-- Lihat -->
                        <a href="/monitoring/view/${item.id}" class="text-blue-500 hover:underline">Lihat</a>
                        <!-- Edit -->
                        <a href="/monitoring/edit/${item.id}" class="text-yellow-500 hover:underline mx-2">Edit</a>
                    </td>
                `;
                tbody.appendChild(row);
            });
        } else {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center py-4">Data tidak tersedia untuk angkatan ini.</td></tr>`;
        }
    }
</script>

@endsection  --}}


{{-- FIX SLIDE 2 --}}
{{-- @extends('layouts.app')

@section('content')
    <!-- Tampilkan pesan error jika ada -->
    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-8">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Monitoring Pembimbing Akademik</h1>

        <!-- Tabel Monitoring Pembimbing Akademik -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Nama Pembimbing Akademik</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Jumlah Mahasiswa yang sudah mengisi IRS</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Persentase</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data rows -->
                    @foreach($data as $index => $item)
                        <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $item['nama_pembimbing'] }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $item['jumlah_isi'] }}/{{ $item['total_mahasiswa'] }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <span class="font-bold {{ $item['persentase'] == 100 ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $item['persentase'] }}%
                                </span>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <!-- Lihat -->
                                <a href="{{ route('monitoring.view', $item['id']) }}" class="text-blue-500 hover:underline flex items-center justify-center">
                                    <img src="https://cdn-icons-png.flaticon.com/512/709/709699.png" alt="Lihat" class="w-5 h-5 inline">
                                    <span class="ml-1">Lihat</span>
                                </a>
                            
                                <!-- Edit -->
                                <a href="{{ route('monitoring.edit', $item['id']) }}" class="text-yellow-500 hover:underline flex items-center justify-center mx-2">
                                    <img src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png" alt="Edit" class="w-5 h-5 inline">
                                    <span class="ml-1">Edit</span>
                                </a>
                            
                                <!-- Hapus -->
                                <a href="{{ route('monitoring.delete', $item['id']) }}" class="text-red-500 hover:underline flex items-center justify-center">
                                    <img src="https://cdn-icons-png.flaticon.com/512/6861/6861362.png" alt="Hapus" class="w-5 h-5 inline">
                                    <span class="ml-1">Hapus</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-4">
            <button class="px-4 py-2 bg-gray-300 rounded shadow">Prev</button>
            <span class="font-semibold">1</span>
            <button class="px-4 py-2 bg-blue-500 text-white rounded shadow">Next</button>
        </div>
    </div>
@endsection --}}

@extends('layouts.app')

@section('content')
    <!-- Tampilkan pesan error jika ada -->
    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-8">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Monitoring Pembimbing Akademik</h1>

        <!-- Grid Angkatan -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($angkatan as $ang)
                <div class="bg-gray-100 p-6 rounded-lg shadow-md flex flex-col items-center">
                    <span class="text-xl font-semibold mb-4">{{ $ang->tahun_ajaran }}</span>
                    <div class="flex flex-col space-y-4 w-full">
                        <a href="{{ route('monitoring.view', $ang->id) }}" class="text-blue-500 hover:underline text-center">Lihat</a>
                        <a href="{{ route('monitoring.edit', $ang->id) }}" class="text-yellow-500 hover:underline text-center">Edit</a>
                        <a href="{{ route('monitoring.delete', $ang->id) }}" class="text-red-500 hover:underline text-center">Hapus</a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination (if necessary) -->
        <div class="flex justify-between items-center mt-4">
            <button class="px-4 py-2 bg-gray-300 rounded shadow">Prev</button>
            <span class="font-semibold">1</span>
            <button class="px-4 py-2 bg-blue-500 text-white rounded shadow">Next</button>
        </div>
    </div>
@endsection
