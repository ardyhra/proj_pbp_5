
<!-- resources/views/kaprodi/edit-jadwal.blade.php -->
@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold">Edit Jadwal Semester {{ ucfirst($semester) }} - {{ ucfirst($section) }}</h2>

    <form action="{{ route('jadwal.apply', ['semester' => $semester, 'section' => $section]) }}" method="POST">
        @csrf

        <div class="grid gap-4">
            @foreach($jadwal as $item)
                <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                    <label for="kode_mk_{{ $item->id_jadwal }}" class="block font-semibold">Kode Mata Kuliah:</label>
                    <input type="text" name="kode_mk[{{ $item->id_jadwal }}]" value="{{ $item->kode_mk }}" class="block w-full p-2 border border-gray-300 rounded-md" required>

                    <label for="id_prodi_{{ $item->id_jadwal }}" class="block font-semibold mt-2">Program Studi:</label>
                    <input type="text" name="id_prodi[{{ $item->id_jadwal }}]" value="{{ $item->id_prodi }}" class="block w-full p-2 border border-gray-300 rounded-md" required>

                    <label for="waktu_mulai_{{ $item->id_jadwal }}" class="block font-semibold mt-2">Waktu Mulai:</label>
                    <input type="time" name="waktu_mulai[{{ $item->id_jadwal }}]" value="{{ $item->waktu_mulai }}" class="block w-full p-2 border border-gray-300 rounded-md" required>

                    <label for="waktu_selesai_{{ $item->id_jadwal }}" class="block font-semibold mt-2">Waktu Selesai:</label>
                    <input type="time" name="waktu_selesai[{{ $item->id_jadwal }}]" value="{{ $item->waktu_selesai }}" class="block w-full p-2 border border-gray-300 rounded-md" required>
                </div>
            @endforeach
        </div>

        <button type="submit" class="mt-4 bg-green-500 text-white px-6 py-2 rounded-md">Apply Jadwal</button>
    </form>
@endsection

