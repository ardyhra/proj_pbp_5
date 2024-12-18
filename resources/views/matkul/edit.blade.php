@extends('layouts.app')

@section('title', 'Edit Mata Kuliah')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-semibold mb-4">Edit Mata Kuliah</h1>

    <form id="editForm" action="{{ route('matkul.update', $matkul->kode_mk) }}" method="POST" id="editForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="old_kode_mk" value="{{ $matkul->kode_mk }}">

        <div class="mb-4">
            <label for="kode_mk" class="block font-medium">Kode Mata Kuliah</label>
            <input type="text" id="kode_mk" name="kode_mk" value="{{ old('kode_mk', $matkul->kode_mk) }}"
                   class="w-full p-2 border rounded" placeholder="Masukkan Kode MK Baru" required>
        </div>

        <div class="mb-4">
            <label for="nama_mk" class="block font-medium">Nama Mata Kuliah</label>
            <input type="text" id="nama_mk" name="nama_mk" value="{{ old('nama_mk', $matkul->nama_mk) }}"
                   class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="sks" class="block font-medium">SKS</label>
            <input type="number" id="sks" name="sks" value="{{ old('sks', $matkul->sks) }}"
                   class="w-full p-2 border rounded" min="1" max="6" required>
        </div>

        <div class="mb-4">
            <label for="plot_semester" class="block font-medium">Semester</label>
            <input type="number" id="plot_semester" name="plot_semester" value="{{ old('plot_semester', $matkul->plot_semester) }}"
                   class="w-full p-2 border rounded" min="1" max="8" required>
        </div>

        <div class="mb-4">
            <label for="jenis" class="block font-medium">Jenis</label>
            <select id="jenis" name="jenis" class="w-full p-2 border rounded" required>
                <option value="" disabled selected>-- Pilih Jenis --</option>
                <option value="W" {{ old('jenis', $matkul->jenis) === 'W' ? 'selected' : '' }}>Wajib</option>
                <option value="P" {{ old('jenis', $matkul->jenis) === 'P' ? 'selected' : '' }}>Pilihan</option>
            </select>
        </div>

        <div class="mb-4 flex items-center">
            <button type="submit" id="updateButton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Update Matkul
            </button>
            <a href="#" id="cancelButton" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 ml-2">
                Batal
            </a>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('updateButton').addEventListener('click', function (event) {
            event.preventDefault(); // Mencegah form submission otomatis

            // Ambil nilai dari form
            const kodeMk = document.getElementById('kode_mk').value;
            const namaMk = document.getElementById('nama_mk').value;
            const sks = document.getElementById('sks').value;
            const plotSemester = document.getElementById('plot_semester').value;
            const jenis = document.getElementById('jenis').value;

            // Validasi data secara sederhana di sisi klien
            let errors = [];
            if (!kodeMk) errors.push('Kode Mata Kuliah wajib diisi.');
            if (kodeMk.length > 10) errors.push('Kode Mata Kuliah maksimal 10 karakter.');
            if (!namaMk) errors.push('Nama Mata Kuliah wajib diisi.');
            if (!sks || sks < 1 || sks > 6) errors.push('SKS harus berada dalam rentang 1-6.');
            if (!plotSemester || plotSemester < 1 || plotSemester > 8) errors.push('Semester harus berada dalam rentang 1-8.');
            if (!jenis || (jenis !== 'W' && jenis !== 'P')) errors.push('Jenis Mata Kuliah harus Wajib (W) atau Pilihan (P).');

            if (errors.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: `<ul>${errors.map(error => `<li>${error}</li>`).join('')}</ul>`
                });
                return;
            }

            // Konfirmasi dengan SweetAlert
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Perubahan pada data mata kuliah akan disimpan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Tersimpan!',
                        text: 'Data mata kuliah berhasil diperbarui.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        document.getElementById('editForm').submit(); // Submit form setelah konfirmasi
                    });
                }
            });
        });
        document.getElementById('cancelButton').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah aksi default

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Semua perubahan yang belum disimpan akan hilang.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, keluar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kembali ke halaman sebelumnya dengan parameter yang sesuai
                    window.history.back(); // Menggunakan back agar kembali ke halaman sebelumnya
                }
            });
        });
    });
</script>
@endsection
