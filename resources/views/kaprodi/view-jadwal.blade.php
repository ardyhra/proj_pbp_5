@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Detail Jadwal</h2>
        
        <!-- Tampilkan data jadwal -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p><strong>Mata Kuliah:</strong> {{ $jadwal->kode_mk }}</p>
            <p><strong>Kelas:</strong> {{ $jadwal->kelas }}</p>
            <p><strong>Hari:</strong> {{ $jadwal->hari }}</p>
            <p><strong>Waktu:</strong> {{ $jadwal->waktu_mulai }} s.d. {{ $jadwal->waktu_selesai }}</p>
            <p><strong>Ruang:</strong> {{ $jadwal->id_ruang }}</p>
            <p><strong>Prodi:</strong> {{ $jadwal->id_prodi }}</p>

            <!-- Menampilkan Tahun Ajaran -->
            <p><strong>Tahun Ajaran:</strong> {{ $jadwal->tahunAjaran->tahun_ajaran }}</p>
        </div>
        
        <!-- Tombol Kembali -->
        <a href="{{ route('manajemen-jadwal-kaprodi.index', ['id_tahun' => request('id_tahun')]) }}" class="mt-4 inline-block px-6 py-3 bg-gray-800 text-white rounded-lg">Kembali ke Jadwal</a>
    </div>
@endsection
