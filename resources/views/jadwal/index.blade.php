<!-- resources/views/jadwal/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Jadwal Kuliah</h1>

    <a href="{{ route('jadwal.create') }}" class="btn btn-primary mb-3">Tambah Jadwal Baru</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode MK</th>
                <th>Nama MK</th>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Ruang</th>
                <th>Kuota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwals as $jadwal)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $jadwal->kode_mk }}</td>
                <td>{{ $jadwal->matakuliah->nama_mk }}</td>
                <td>{{ $jadwal->kelas }}</td>
                <td>{{ $jadwal->hari }}</td>
                <td>{{ $jadwal->waktu_mulai }}</td>
                <td>{{ $jadwal->waktu_selesai }}</td>
                <td>{{ $jadwal->ruang->nama_ruang }}</td>
                <td>{{ $jadwal->kuota }}</td>
                <td>
                    <a href="{{ route('jadwal.edit', $jadwal->id_jadwal) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('jadwal.destroy', $jadwal->id_jadwal) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
