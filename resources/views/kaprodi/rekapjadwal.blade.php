
@extends('layouts.app')
@section('title', 'Rekap Jadwal Kuliah Kaprodi')
@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-semibold mb-4 text-center">Rekap Jadwal Kuliah Kaprodi</h1>

    <!-- Form untuk memilih Tahun Ajaran dan Program Studi -->
    <form id="ajukan-jadwal-form" action="{{ route('usulanjadwal.ajukan') }}" method="POST" class="mb-5">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Tahun Ajaran -->
            <div class="mb-4">
                <label for="id_tahun" class="block">Tahun Ajaran</label>
                <select name="id_tahun" id="id_tahun" class="w-full p-2 border rounded">
                    <option value="" disabled selected>Pilih Tahun Ajaran</option>
                    @foreach($tahunajarans as $tahun)
                        <option value="{{ $tahun->id_tahun }}" {{ request('id_tahun') == $tahun->id_tahun ? 'selected' : '' }}>
                            {{ $tahun->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <!-- Program Studi -->
            <div class="mb-4">
                <label for="id_prodi" class="block">Program Studi</label>
                <select name="id_prodi" id="id_prodi" class="w-full p-2 border rounded">
                    <option value="" disabled selected>Pilih Program Studi</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id_prodi }}" {{ request('id_prodi') == $prodi->id_prodi ? 'selected' : '' }}>
                            {{ $prodi->strata }} - {{ $prodi->nama_prodi }} 
                        </option>
                    @endforeach
                </select>
                
            </div>
        </div>
        
        <div class="mb-2">
            <button type="button" id="ajukan-jadwal-button" class="mt-4 bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                Ajukan Jadwal
            </button>
                    <!-- Tombol Detail untuk melihat rekapan jadwal -->
            <a href="javascript:void(0);" id="detail-jadwal-button" class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition">
                Detail Jadwal
            </a>
        </div>
        
    </form>

    

    <!-- Tabel Usulan Jadwal -->
    <div id="usulanJadwalTable" class="overflow-x-auto shadow-lg rounded-lg border border-gray-300  hidden">
        <h2 class="text-2xl font-semibold mb-4 text-center">Tabel Usulan Jadwal</h2>
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold text-center">No</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">ID Tahun</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">ID Prodi</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($usulanJadwals as $jadwal)
                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                        <td class="px-4 py-3 text-sm  text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-sm  text-center">{{ $jadwal->tahun_ajaran }}</td>
                        <td class="px-4 py-3 text-sm  text-center">{{ $jadwal->prodi->strata }} - {{ $jadwal->nama_prodi }}</td>
                        <td class="px-4 py-3 text-sm  text-center">
                            @if($jadwal->status == 'Diajukan')
                                <span class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">Diajukan</span>
                            @elseif($jadwal->status == 'Disetujui')
                                <span class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Disetujui</span>
                            @else
                                <span class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada jadwal yang diajukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('ajukan-jadwal-button').addEventListener('click', function () {
        Swal.fire({
            title: 'Yakin?',
            text: "Anda akan mengajukan jadwal ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ajukan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form jika pengguna yakin
                document.getElementById('ajukan-jadwal-form').submit();
            }
        });
    });
    // Menampilkan atau menyembunyikan tabel usulan jadwal saat tombol Detail diklik
    document.getElementById('detail-jadwal-button').addEventListener('click', function () {
        const table = document.getElementById('usulanJadwalTable');
        
        // Toggle visibility of the table
        table.classList.toggle('hidden');
    });

    // Notifikasi jika jadwal berhasil diajukan (Flash Message)
    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @elseif(session('error'))
        Swal.fire({
            title: 'Gagal!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @endif
</script>
@endsection


