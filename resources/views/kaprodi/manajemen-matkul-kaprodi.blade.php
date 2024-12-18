@extends('layouts.app')

@section('title', 'Manajemen Mata Kuliah')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-center">Manajemen Mata Kuliah</h1>

    <!-- Tombol Tambah Mata Kuliah -->
    <a href="{{ route('matkul.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-4 inline-block">
        Tambah Mata Kuliah
    </a>

    <!-- Tabel Mata Kuliah -->
    <table class="w-full border-collapse border border-blue-300">
        <thead>
            <tr class="bg-blue-600 text-white">
                <th class="border p-2">No</th>
                <th class="border p-2">Kode MK</th>
                <th class="border p-2">Nama MK</th>
                <th class="border p-2">SKS</th>
                <th class="border p-2">Semester</th>
                <th class="border p-2">Jenis</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matkuls as $mk)
                <tr class="hover:bg-gray-100">
                    <td class="border p-2 text-center">{{ $loop->iteration }}</td>
                    <td class="border p-2 text-center">{{ $mk->kode_mk }}</td>
                    <td class="border p-2 ">{{ $mk->nama_mk }}</td>
                    <td class="border p-2 text-center">{{ $mk->sks }}</td>
                    <td class="border p-2 text-center">{{ $mk->plot_semester }}</td>
                    <td class="border p-2 text-center">{{ $mk->jenis }}</td>
                    <td class="border p-2 text-center">
                        <a href="{{ route('matkul.edit', $mk->kode_mk) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">Edit</a>
                        <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600" onclick="deleteMatkul('{{ $mk->kode_mk }}')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteMatkul(kodeMk) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Mata kuliah ini akan dihapus secara permanen.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                // Buat form dinamis untuk penghapusan
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '/matkul/' + kodeMk;

                // Tambahkan CSRF token
                let csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Tambahkan metode DELETE
                let methodDelete = document.createElement('input');
                methodDelete.type = 'hidden';
                methodDelete.name = '_method';
                methodDelete.value = 'DELETE';
                form.appendChild(methodDelete);

                // Tambahkan form ke dokumen
                document.body.appendChild(form);

                // Submit form
                form.submit();

                // Tampilkan notifikasi sukses setelah submit
                Swal.fire(
                    'Terhapus!',
                    'Mata kuliah telah dihapus.',
                    'success'
                );
            }
        });
    }
</script>

@endsection
