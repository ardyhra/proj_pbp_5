@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-semibold mb-4">Edit Jadwal Kuliah</h1>

    <!-- Form Edit Jadwal -->
    <form id="updateForm" action="{{ route('jadwal.update', $jadwal->id_jadwal) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="kode_mk" class="block">Kode MK</label>
            <input type="text" id="kode_mk" name="kode_mk" value="{{ $jadwal->kode_mk }}" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="kelas" class="block">Kelas</label>
            <input type="text" id="kelas" name="kelas" value="{{ $jadwal->kelas }}" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="hari" class="block">Hari</label>
            <select name="hari" id="hari" class="w-full p-2 border rounded">
                <option value="1" {{ $jadwal->hari == 1 ? 'selected' : '' }}>Senin</option>
                <option value="2" {{ $jadwal->hari == 2 ? 'selected' : '' }}>Selasa</option>
                <option value="3" {{ $jadwal->hari == 3 ? 'selected' : '' }}>Rabu</option>
                <option value="4" {{ $jadwal->hari == 4 ? 'selected' : '' }}>Kamis</option>
                <option value="5" {{ $jadwal->hari == 5 ? 'selected' : '' }}>Jumat</option>
                <option value="6" {{ $jadwal->hari == 6 ? 'selected' : '' }}>Sabtu</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="waktu_mulai" class="block">Waktu Mulai</label>
            <input type="time" id="waktu_mulai" name="waktu_mulai" value="{{ $jadwal->waktu_mulai }}" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="waktu_selesai" class="block">Waktu Selesai</label>
            <input type="time" id="waktu_selesai" name="waktu_selesai" value="{{ $jadwal->waktu_selesai }}" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="id_ruang" class="block">Ruang</label>
            <select name="id_ruang" id="id_ruang" class="w-full p-2 border rounded">
                @foreach($ruang as $r)
                    <option value="{{ $r->id_ruang }}" {{ $jadwal->id_ruang == $r->id_ruang ? 'selected' : '' }}>
                        {{ $r->id_ruang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="kuota" class="block">Kuota</label>
            <input type="number" id="kuota" name="kuota" value="{{ $jadwal->kuota }}" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4 flex items-center">
            <!-- Tombol Update -->
            <button type="button" id="updateButton" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                Update Jadwal
            </button>
            
            <!-- Tombol Cancel -->
            <!-- Tombol Cancel -->
<a href="#" id="cancelButton" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 ml-2">
    Cancel
</a>

        </div>
        
        
        
    </form>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Menambahkan event listener untuk tombol update
    document.getElementById('updateButton').addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah form langsung disubmit

        // Menampilkan SweetAlert2 untuk konfirmasi
        Swal.fire({
            title: "Apakah Anda Yakin?",
            icon: 'warning',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            denyButtonText: "Don't save"
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                // Menampilkan SweetAlert sukses setelah data disubmit
                Swal.fire({
                    title: 'Saved!',
                    text: 'Jadwal telah berhasil diperbarui.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    document.getElementById('updateForm').submit(); // Submit form setelah konfirmasi
                });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    });

    // Menambahkan event listener untuk tombol cancel
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
</script>

@endsection
