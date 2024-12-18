@extends('layouts.app')

@section('title', 'Tambah Mata Kuliah')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-semibold mb-4">Tambah Mata Kuliah</h1>

    <!-- Form Tambah Mata Kuliah -->
    <form id="createForm" action="{{ route('matkul.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="kode_mk" class="block font-medium">Kode Mata Kuliah</label>
            <input type="text" id="kode_mk" name="kode_mk" class="w-full p-2 border rounded" placeholder="Masukkan Kode Mata Kuliah" required>
        </div>

        <div class="mb-4">
            <label for="nama_mk" class="block font-medium">Nama Mata Kuliah</label>
            <input type="text" id="nama_mk" name="nama_mk" class="w-full p-2 border rounded" placeholder="Masukkan Nama Mata Kuliah" required>
        </div>

        <div class="mb-4">
            <label for="sks" class="block font-medium">SKS</label>
            <input type="number" id="sks" name="sks" class="w-full p-2 border rounded" placeholder="Masukkan Jumlah SKS" min="1" max="6" required>
        </div>

        <div class="mb-4">
            <label for="plot_semester" class="block font-medium">Semester</label>
            <input type="number" id="plot_semester" name="plot_semester" class="w-full p-2 border rounded" placeholder="Masukkan Semester" min="1" max="8" required>
        </div>

        <div class="mb-4">
            <label for="jenis" class="block font-medium">Jenis</label>
            <select id="jenis" name="jenis" class="w-full p-2 border rounded" required>
                <option value="" disabled selected>-- Pilih Jenis --</option>
                <option value="W">Wajib</option>
                <option value="P">Pilihan</option>
            </select>
        </div>

        <div class="mb-4 flex items-center">
            <button type="button" id="submitButton" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                Tambah Mata Kuliah
            </button>
            <a href="{{ route('manajemen-matkul-kaprodi') }}" id="cancelButton" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 ml-2">
                Cancel
            </a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('submitButton').addEventListener('click', function (event) {
        event.preventDefault(); // Mencegah form submission otomatis

        const kodeMk = document.getElementById('kode_mk').value.trim();
        const namaMk = document.getElementById('nama_mk').value.trim();
        const sks = document.getElementById('sks').value.trim();
        const semester = document.getElementById('plot_semester').value.trim();
        const jenis = document.getElementById('jenis').value.trim();

        let errors = [];

        // Validasi input di sisi client
        if (!kodeMk) {
            errors.push('Kode Mata Kuliah wajib diisi.');
        } else {
            if (typeof kodeMk !== 'string') errors.push('Kode Mata Kuliah harus berupa teks.');
            if (kodeMk.length > 10) errors.push('Kode Mata Kuliah maksimal 10 karakter.');
        }

        if (!namaMk) {
            errors.push('Nama Mata Kuliah wajib diisi.');
        } else {
            if (typeof namaMk !== 'string') errors.push('Nama Mata Kuliah harus berupa teks.');
            if (namaMk.length > 255) errors.push('Nama Mata Kuliah maksimal 255 karakter.');
        }

        if (!sks || isNaN(sks) || sks < 1 || sks > 6) errors.push('SKS harus berada dalam range 1 sampai 6.');
        if (!semester || isNaN(semester) || semester < 1 || semester > 8) errors.push('Semester harus berada dalam range 1 sampai 8.');
        if (!jenis || (jenis !== 'W' && jenis !== 'P')) errors.push('Jenis Mata Kuliah hanya dapat berupa "Wajib" atau "Pilihan".');

        if (errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `<ul>${errors.map(error => `<li>${error}</li>`).join('')}</ul>`,
            });
            return;
        }

        // Validasi `unique` di sisi server menggunakan AJAX
        $.ajax({
            url: "{{ route('matkul.check-unique') }}", // Route untuk validasi `unique`
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "kode_mk": kodeMk,
                "nama_mk": namaMk
            },
            success: function (response) {
                if (response.exists) {
                    // Jika data sudah ada
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message, // Pesan dari server
                    });
                } else {
                    // Jika tidak ada masalah, konfirmasi sebelum submit
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data mata kuliah akan disimpan.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, simpan!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Tersimpan!',
                                text: 'Mata kuliah berhasil ditambahkan.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                document.getElementById('createForm').submit(); // Submit form
                            });
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("Error AJAX:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat memvalidasi data. Coba lagi.',
                });
            }
        });
    });

    // Tombol Cancel
    document.getElementById('cancelButton').addEventListener('click', function (event) {
        event.preventDefault(); // Mencegah aksi default
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Perubahan yang belum disimpan akan hilang.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, keluar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('manajemen-matkul-kaprodi') }}";
            }
        });
    });

    // Tombol Cancel
    document.getElementById('cancelButton').addEventListener('click', function (event) {
        event.preventDefault(); // Mencegah aksi default
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Perubahan yang belum disimpan akan hilang.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, keluar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('manajemen-matkul-kaprodi') }}";
            }
        });
    });
});

</script>

@endsection
