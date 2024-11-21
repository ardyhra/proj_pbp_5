
{{-- @extends('layouts.app')

@section('title', 'Manajemen Jadwal Kaprodi')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Manajemen Jadwal Tahun Ajaran: {{ $tahun }}</h1>

    <div class="grid gap-4">
        @foreach($jadwals as $jadwal)
        <div class="flex justify-between items-center bg-gray-100 p-6 rounded-lg shadow-md">
            <span class="text-xl font-semibold">{{ $jadwal->nama_mk }} - {{ $jadwal->kelas }}</span>
            <div class="flex space-x-4">
                <a href="{{ route('jadwal.view', ['id' => $jadwal->id]) }}" class="text-blue-500 hover:underline">Lihat</a>
                <a href="{{ route('jadwal.edit', ['id' => $jadwal->id]) }}" class="text-yellow-500 hover:underline">Edit</a>
                <a href="{{ route('jadwal.apply', ['id' => $jadwal->id]) }}" class="text-green-500 hover:underline">Apply</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection --}}

@extends('layouts.app')

@section('title', 'Manajemen Jadwal Kaprodi')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Manajemen Jadwal</h1>

    <!-- Tabs Tahun Ajaran -->
    <div class="flex space-x-4 mb-8">
        <a href="{{ route('manajemen-jadwal-kaprodi', ['id_tahun' => '2023G']) }}" 
           class="px-6 py-3 rounded-lg text-lg font-semibold {{ $selected_tahun == '2023G' ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-800' }}">
            2023/2024 Ganjil
        </a>
        <a href="{{ route('manajemen-jadwal-kaprodi', ['id_tahun' => '2023N']) }}" 
           class="px-6 py-3 rounded-lg text-lg font-semibold {{ $selected_tahun == '2023N' ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-800' }}">
            2023/2024 Genap
        </a>
    </div>

    <!-- Daftar Semester -->
    <div class="grid gap-4">
        @foreach($semesters as $semester)
        <div class="flex justify-between items-center bg-gray-100 p-6 rounded-lg shadow-md">
            <span class="text-xl font-semibold">Semester {{ $semester }}</span>
            <div class="flex space-x-4">
                <a href="{{ route('jadwal.view', ['id_tahun' => $selected_tahun, 'semester' => $semester]) }}" 
                   class="text-blue-500 hover:underline">Lihat</a>
                <a href="{{ route('jadwal.edit', ['id_tahun' => $selected_tahun, 'semester' => $semester]) }}" 
                   class="text-yellow-500 hover:underline">Edit</a>
                <a href="{{ route('jadwal.apply', ['id_tahun' => $selected_tahun, 'semester' => $semester]) }}" 
                   class="text-green-500 hover:underline">Apply</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection


