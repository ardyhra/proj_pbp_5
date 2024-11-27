{{-- @extends('layouts.app')

@section('title', 'Edit Jadwal')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Jadwal</h1>

    <!-- Form Edit Jadwal -->
    <form action="{{ route('manajemen-jadwal.update', $jadwal->id_jadwal) }}" method="POST">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="kode_mk" class="block font-semibold">Kode MK</label>
                <select name="kode_mk" id="kode_mk" class="w-full border rounded p-2">
                    @foreach($matakuliahs as $matakuliah)
                        <option value="{{ $matakuliah->kode_mk }}" {{ $jadwal->kode_mk == $matakuliah->kode_mk ? 'selected' : '' }}>
                            {{ $matakuliah->kode_mk }} - {{ $matakuliah->nama_mk }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="kelas" class="block font-semibold">Kelas</label>
                <input type="text" name="kelas" id="kelas" value="{{ $jadwal->kelas }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label for="hari" class="block font-semibold">Hari</label>
                <select name="hari" id="hari" class="w-full border rounded p-2">
                    <option value="Senin" {{ $jadwal->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                    <option value="Selasa" {{ $jadwal->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                    <option value="Rabu" {{ $jadwal->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                    <option value="Kamis" {{ $jadwal->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                    <option value="Jumat" {{ $jadwal->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                </select>
            </div>
            <div>
                <label for="waktu_mulai" class="block font-semibold">Waktu Mulai</label>
                <input type="time" name="waktu_mulai" id="waktu_mulai" value="{{ $jadwal->waktu_mulai }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label for="waktu_selesai" class="block font-semibold">Waktu Selesai</label>
                <input type="time" name="waktu_selesai" id="waktu_selesai" value="{{ $jadwal->waktu_selesai }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label for="id_ruang" class="block font-semibold">Ruang</label>
                <select name="id_ruang" id="id_ruang" class="w-full border rounded p-2">
                    @foreach($ruangs as $ruang)
                        <option value="{{ $ruang->id }}" {{ $jadwal->id_ruang == $ruang->id ? 'selected' : '' }}>
                            {{ $ruang->nama_ruang }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="dosen_pengampu" class="block font-semibold">Dosen Pengampu</label>
                <select name="dosen_pengampu" id="dosen_pengampu" class="w-full border rounded p-2">
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->nind }}" {{ $jadwal->nind == $dosen->nind ? 'selected' : '' }}>
                            {{ $dosen->nama_dosen }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('manajemen-jadwal-kaprodi.index') }}" class="ml-2 bg-red-500 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection --}}

{{-- 
@extends('layouts.app')

@section('title', 'Edit Jadwal')

@section('content')
<div class="p-8">
    <!-- Header -->
    <h1 class="text-3xl font-bold mb-6">Edit Jadwal</h1>

    <!-- Informasi Semester -->
    <p class="text-lg mb-4">Mengedit jadwal untuk <strong>Semester {{ $section }}</strong> ({{ ucfirst($semester) }})</p>

    <!-- Form Edit Jadwal -->
    <form action="{{ route('update-jadwal') }}" method="POST">
        @csrf
        @foreach($jadwal as $item)
            <div class="mb-4">
                <label class="block text-lg font-medium mb-2">Nama Mata Kuliah</label>
                <input type="text" name="mata_kuliah[]" value="{{ $item->nama_mata_kuliah }}" class="w-full p-3 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-lg font-medium mb-2">Waktu Mulai</label>
                <input type="time" name="waktu_mulai[]" value="{{ $item->waktu_mulai }}" class="w-full p-3 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-lg font-medium mb-2">Waktu Selesai</label>
                <input type="time" name="waktu_selesai[]" value="{{ $item->waktu_selesai }}" class="w-full p-3 border border-gray-300 rounded-lg">
            </div>
        @endforeach
        <button type="submit" class="px-6 py-3 bg-blue-500 text-white rounded-lg">Simpan</button>
    </form>
</div>
@endsection --}}


{{-- @extends('layouts.app')

@section('title', 'Edit Jadwal')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Edit Jadwal - Semester {{ $section }}</h1>

    <form action="{{ route('jadwal.update') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $jadwal->id }}">
        <input type="hidden" name="semester" value="{{ $semester }}">
        <input type="hidden" name="section" value="{{ $section }}">

        <div class="mb-4">
            <label for="kode_mk" class="block font-semibold">Kode MK</label>
            <input type="text" id="kode_mk" name="kode_mk" value="{{ $jadwal->kode_mk }}" class="w-full p-2 border rounded">
        </div>
        <!-- Add other fields as necessary -->
        <div class="flex space-x-4">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded">Simpan</button>
            <a href="{{ route('manajemen-jadwal-kaprodi', ['semester' => $semester]) }}" class="px-6 py-2 bg-gray-500 text-white rounded">Batal</a>
        </div>
    </form>
</div>
@endsection --}}


{{-- @extends('layouts.app')

@section('title', 'Edit Jadwal')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Edit Jadwal Semester {{ $section }} ({{ $semester }})</h1>

    <table class="w-full border-collapse border border-gray-400">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">Kode MK</th>
                <th class="border border-gray-300 px-4 py-2">Nama MK</th>
                <th class="border border-gray-300 px-4 py-2">Kelas</th>
                <th class="border border-gray-300 px-4 py-2">Hari</th>
                <th class="border border-gray-300 px-4 py-2">Waktu</th>
                <th class="border border-gray-300 px-4 py-2">Ruang</th>
                <th class="border border-gray-300 px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwal as $item)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $item->kode_mk }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $item->nama_mk }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $item->kelas }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $item->hari }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $item->ruang }}</td>
                <td class="border border-gray-300 px-4 py-2">
                    <a href="#" class="text-yellow-500 hover:underline">Edit</a>
                    <a href="#" class="text-red-500 hover:underline">Hapus</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        <button class="bg-green-500 text-white px-6 py-3 rounded-lg">Simpan</button>
        <button class="bg-red-500 text-white px-6 py-3 rounded-lg">Batal</button>
    </div>
</div>
@endsection --}}

{{-- AAAAAA --}}
@extends('layouts.app')

@section('title', 'Edit Jadwal')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Edit Jadwal: {{ $jadwal->nama_mk }}</h1>

    <form action="{{ route('jadwal.update', ['id' => $jadwal->id]) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="kelas" class="block text-sm font-medium">Kelas</label>
            <input type="text" id="kelas" name="kelas" value="{{ $jadwal->kelas }}" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label for="hari" class="block text-sm font-medium">Hari</label>
            <input type="text" id="hari" name="hari" value="{{ $jadwal->hari }}" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label for="waktu" class="block text-sm font-medium">Waktu</label>
            <input type="text" id="waktu" name="waktu" value="{{ $jadwal->waktu }}" class="w-full p-2 border rounded-lg">
        </div>

        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg">Simpan</button>
    </form>
</div>
@endsection