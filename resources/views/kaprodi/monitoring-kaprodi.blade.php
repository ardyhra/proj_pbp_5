{{-- 
@extends('layouts.app')

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

@endsection --}}

@extends('layouts.app')

@section('content')
    <!-- Tampilkan pesan error jika ada -->
    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-8">
            {{ session('error') }}
        </div>
    @endif

    <!-- Dropdown Tahun Ajaran -->
    <div class="mb-8">
        <label for="tahun_ajaran" class="block text-lg font-semibold">Pilih Tahun Ajaran</label>
        <select id="tahun_ajaran" name="id_tahun" onchange="window.location.href=this.value"
                class="px-6 py-3 rounded-lg text-lg font-semibold bg-gray-300 text-gray-800 w-full">
            <option value="" disabled selected>Pilih Tahun Ajaran</option>

            @foreach($tahunAjarans as $tahun)
                <option value="{{ route('manajemen-jadwal-kaprodi.index', ['semester' => $semester, 'id_tahun' => $tahun->id_tahun]) }}"
                    {{ request('id_tahun') == $tahun->id_tahun ? 'selected' : '' }}>
                    {{ $tahun->tahun_ajaran }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Menampilkan Daftar Semester Berdasarkan Tahun Ajaran -->
    <div class="grid gap-4">
        @if($semesterType === 'ganjil')
            <!-- Semester Ganji -->
            @foreach([1, 3, 5, 7] as $sem)
            <div class="flex justify-between items-center bg-gray-100 p-6 rounded-lg shadow-md">
                <span class="text-xl font-semibold">Semester {{ $sem }}</span>
                <div class="flex space-x-4">
                    <!-- Menampilkan Jadwal untuk Semester yang Dipilih -->
                    @foreach($jadwals as $item)
                        @if($item->matakuliah->plot_semester == 'ganjil' && in_array($sem, [1, 3, 5, 7]))
                            <a href="{{ route('jadwal.view', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-blue-500 hover:underline">Lihat</a> |

                            <a href="{{ route('jadwal.edit', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-yellow-500 hover:underline">Edit</a> |

                            <a href="{{ route('jadwal.apply', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-green-500 hover:underline">Apply</a>
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        @elseif($semesterType === 'genap')
            <!-- Semester Genap -->
            @foreach([2, 4, 6, 8] as $sem)
            <div class="flex justify-between items-center bg-gray-100 p-6 rounded-lg shadow-md">
                <span class="text-xl font-semibold">Semester {{ $sem }}</span>
                <div class="flex space-x-4">
                    <!-- Menampilkan Jadwal untuk Semester yang Dipilih -->
                    @foreach($jadwals as $item)
                        @if($item->matakuliah->plot_semester == 'genap' && in_array($sem, [2, 4, 6, 8]))
                            <a href="{{ route('jadwal.view', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-blue-500 hover:underline">Lihat</a> |

                            <a href="{{ route('jadwal.edit', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-yellow-500 hover:underline">Edit</a> |

                            <a href="{{ route('jadwal.apply', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-green-500 hover:underline">Apply</a>
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        @endif
    </div>

@endsection
