@extends('layouts.app')
@section('title', 'SISKARA - Edit Jadwal')
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
            <select name="kelas" id="kelas" class="w-full p-2 border rounded">
                <option value="" disabled selected>-- Pilih Kelas --</option>
                <option value="A" {{ old('kelas', $jadwal->kelas) == 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ old('kelas', $jadwal->kelas) == 'B' ? 'selected' : '' }}>B</option>
                <option value="C" {{ old('kelas', $jadwal->kelas) == 'C' ? 'selected' : '' }}>C</option>
                <option value="D" {{ old('kelas', $jadwal->kelas) == 'D' ? 'selected' : '' }}>D</option>
                <option value="E" {{ old('kelas', $jadwal->kelas) == 'E' ? 'selected' : '' }}>E</option>
            </select>
        </div>
        
        <div class="mb-4">
            <label for="id_ruang" class="block">Ruang</label>
            <select name="id_ruang" id="id_ruang" class="w-full p-2 border rounded">
                <option value="" disabled selected>-- Pilih Ruang --</option>
                @foreach($ruang as $r)
                    <option value="{{ $r->id_ruang }}" {{ $jadwal->id_ruang == $r->id_ruang ? 'selected' : '' }}>
                        {{ $r->id_ruang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="hari" class="block">Hari</label>
            <select name="hari" id="hari" class="w-full p-2 border rounded">
                <option value="" disabled selected>-- Pilih Hari --</option>
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
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('updateButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent form submission

            // Initialize an array to hold the names of the missing fields
            let missingFields = [];

            // Get field values
            const kodeMk = document.getElementById('kode_mk').value;
            const kelas = document.getElementById('kelas').value;
            const ruang = document.getElementById('id_ruang').value;
            const hari = document.getElementById('hari').value;
            const waktuMulai = document.getElementById('waktu_mulai').value;
            const waktuSelesai = document.getElementById('waktu_selesai').value;
            const kuota = document.getElementById('kuota').value;

            // Add missing fields to the array
            if (!kodeMk) missingFields.push("Kode MK");
            if (!kelas) missingFields.push("Kelas");
            if (!ruang) missingFields.push("Ruang");
            if (!hari) missingFields.push("Hari");
            if (!waktuMulai) missingFields.push("Waktu Mulai");
            if (!waktuSelesai) missingFields.push("Waktu Selesai");
            if (!kuota) missingFields.push("Kuota");

            // If there are any missing fields, show an alert
            if (missingFields.length > 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Field yang berikut wajib diisi: " + missingFields.join(', ') + ".",
                });
                return;
            }

            // Check if 'kode_mk' exists in the database via AJAX
            $.ajax({
                url: "{{ route('jadwal.check-kode-mk') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",  // Pastikan token CSRF disertakan
                    "kode_mk": kodeMk
                },
                success: function(response) {
                    if (!response.exists) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kode MK Tidak Valid',
                            text: 'Kode MK yang Anda masukkan tidak terdaftar.',
                        });
                    } else {
                        // Form is valid, proceed with confirmation and submission
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
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error AJAX: ", status, error);  // Log error if AJAX fails
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat memeriksa Kode MK. Coba lagi.',
                    });
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

            // Pastikan SKS sudah didapatkan pada saat halaman dimuat
        const kodeMk = document.getElementById('kode_mk').value;

        if (kodeMk) {
            // Cek kode MK ketika halaman pertama kali dimuat
            $.ajax({
                url: "{{ route('jadwal.check-kode-mk') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}", // Pastikan CSRF token disertakan
                    "kode_mk": kodeMk
                },
                success: function(response) {
                    window.sks = response.sks; // Menyimpan SKS
                    const waktuMulai = document.getElementById('waktu_mulai').value;
                    if (waktuMulai) {
                        hitungWaktuSelesai(waktuMulai); // Hitung waktu selesai jika waktu mulai sudah terisi
                    }
                }
            });
        }

        // Event listener untuk input 'kode_mk' ketika diubah
        document.getElementById('kode_mk').addEventListener('input', function() {
            const kodeMk = document.getElementById('kode_mk').value;

            if (!kodeMk) return; // Jika kode MK kosong, keluar

            $.ajax({
                url: "{{ route('jadwal.check-kode-mk') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}", // Pastikan CSRF token disertakan
                    "kode_mk": kodeMk
                },
                success: function(response) {
                    window.sks = response.sks; // Menyimpan SKS
                    const waktuMulai = document.getElementById('waktu_mulai').value;
                    if (waktuMulai) {
                        hitungWaktuSelesai(waktuMulai); // Hitung waktu selesai jika waktu mulai sudah terisi
                    }
                }
            });
        });

        // Event listener untuk input 'waktu_mulai' ketika diubah
        document.getElementById('waktu_mulai').addEventListener('input', function() {
            const waktuMulai = document.getElementById('waktu_mulai').value;

            if (!waktuMulai || !window.sks) return; // Pastikan waktu mulai dan SKS ada

            hitungWaktuSelesai(waktuMulai); // Hitung waktu selesai jika waktu mulai sudah ada dan SKS tersedia
        });

        // Fungsi untuk menghitung waktu selesai berdasarkan waktu mulai dan SKS
        function hitungWaktuSelesai(waktuMulai) {
            const sks = window.sks; // Mengambil SKS dari window.sks
            if (!sks) return; // Jika SKS tidak ada, keluar

            // Menghitung waktu selesai berdasarkan SKS (1 SKS = 50 menit)
            let [hours, minutes] = waktuMulai.split(':').map(num => parseInt(num));
            let startMinutes = (hours * 60) + minutes; // Konversi waktu mulai ke menit

            let duration = sks * 50; // Durasi berdasarkan SKS (1 SKS = 50 menit)

            // Hitung waktu selesai
            let endMinutes = startMinutes + duration;
            let endHours = Math.floor(endMinutes / 60); // Jam selesai
            let endMin = endMinutes % 60; // Menit selesai

            // Format waktu selesai menjadi HH:mm
            let endTime = `${String(endHours).padStart(2, '0')}:${String(endMin).padStart(2, '0')}`;

            // Set nilai waktu selesai di input form
            document.getElementById('waktu_selesai').value = endTime;
        }

    });

</script>
@endsection
