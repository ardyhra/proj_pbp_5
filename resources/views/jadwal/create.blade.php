@extends('layouts.app')
@section('title', 'SISKARA - Create Jadwal')
@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-semibold mb-4">Buat Jadwal Kuliah</h1>

    <!-- Form Create Jadwal -->
    <form id="createForm" action="{{ route('jadwal.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id_tahun" value="{{ $id_tahun }}">
        <input type="hidden" name="id_prodi" value="{{ $id_prodi }}">

        <div class="mb-4">
            <label for="kode_mk" class="block">Kode MK</label>
            <input type="text" id="kode_mk" name="kode_mk" class="w-full p-2 border rounded" placeholder="Masukkan Kode MK">
        </div>

        <div class="mb-4">
            <label for="kelas" class="block">Kelas</label>
            <select name="kelas" id="kelas" class="w-full p-2 border rounded">
                <option value="">Pilih Kelas</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="id_ruang" class="block">Ruang</label>
            <select name="id_ruang" id="id_ruang" class="w-full p-2 border rounded">
                <option value="">Pilih Ruang</option>
                @foreach($ruang as $r)
                    <option value="{{ $r->id_ruang }}">{{ $r->id_ruang }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="hari" class="block">Hari</label>
            <select name="hari" id="hari" class="w-full p-2 border rounded">
                <option value="">Pilih Hari</option>
                <option value="1">Senin</option>
                <option value="2">Selasa</option>
                <option value="3">Rabu</option>
                <option value="4">Kamis</option>
                <option value="5">Jumat</option>
                <option value="6">Sabtu</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="waktu_mulai" class="block">Waktu Mulai</label>
            <input type="time" id="waktu_mulai" name="waktu_mulai" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="waktu_selesai" class="block">Waktu Selesai</label>
            <input type="time" id="waktu_selesai" name="waktu_selesai" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="kuota" class="block">Kuota</label>
            <input type="number" id="kuota" name="kuota" class="w-full p-2 border rounded" placeholder="Masukkan Kuota">
        </div>

        <div class="mb-4 flex items-center">
            <button type="button" id="submitButton" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                Buat Jadwal
            </button>
            <a href="#" id="cancelButton" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 ml-2">
                Cancel
            </a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('submitButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent form submission

            let missingFields = [];

            // Get field values
            const kodeMk = document.getElementById('kode_mk').value;
            const kelas = document.getElementById('kelas').value;
            const ruang = document.getElementById('id_ruang').value;
            const hari = document.getElementById('hari').value;
            const waktuMulai = document.getElementById('waktu_mulai').value;
            const waktuSelesai = document.getElementById('waktu_selesai').value;
            const kuota = document.getElementById('kuota').value;

          
            if (!kodeMk) missingFields.push("Kode MK");
            if (!kelas) missingFields.push("Kelas");
            if (!ruang) missingFields.push("Ruang");
            if (!hari) missingFields.push("Hari");
            if (!waktuMulai) missingFields.push("Waktu Mulai");
            if (!waktuSelesai) missingFields.push("Waktu Selesai");
            if (!kuota) missingFields.push("Kuota");

            if (missingFields.length > 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Field yang berikut wajib diisi: " + missingFields.join(', ') + ".",
                });
                return;
            }

            // Setelah cek kode_mk valid
            $.ajax({
                url: "{{ route('jadwal.check-duplicate') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id_tahun": "{{ $id_tahun }}",
                    "id_prodi": "{{ $id_prodi }}",
                    "kode_mk": kodeMk,
                    "kelas": kelas
                },
                success: function(response) {
                    if (response.duplicate) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Jadwal Duplikat',
                            text: 'Kode MK dan Kelas tersebut sudah ada. Silakan pilih kelas lain atau matakuliah lain.',
                        });
                    } else {
                        // Tidak duplikat, lanjut cek jadwal bentrok
                        $.ajax({
                            url: "{{ route('jadwal.check-conflict') }}",
                            method: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id_tahun": "{{ $id_tahun }}",
                                "id_prodi": "{{ $id_prodi }}",
                                "hari": hari,
                                "id_ruang": ruang,
                                "waktu_mulai": waktuMulai,
                                "waktu_selesai": waktuSelesai,
                                "kode_mk": kodeMk // Ditambahkan
                            },
                            success: function(conflictResponse) {
                                if (conflictResponse.conflict) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Jadwal Bentrok',
                                        text: 'Jadwal yang Anda pilih bentrok dengan jadwal lain. Silakan pilih waktu atau ruang lain.',
                                    });
                                } else {
                                    // Tidak bentrok, konfirmasi akhir
                                    Swal.fire({
                                        title: "Apakah Anda Yakin?",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: "Buat Jadwal",
                                        cancelButtonText: "Batal"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            Swal.fire({
                                                title: 'Jadwal Tersimpan!',
                                                text: 'Jadwal kuliah berhasil dibuat.',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            }).then(() => {
                                                document.getElementById('createForm').submit(); // Submit form
                                            });
                                        }
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error AJAX check-conflict: ", status, error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan saat memeriksa jadwal bentrok. Coba lagi.',
                                });
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error AJAX check-duplicate: ", status, error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat memeriksa duplikasi jadwal. Coba lagi.',
                    });
                }
            });

            


        });
    
        document.getElementById('cancelButton').addEventListener('click', function(event) {
            event.preventDefault(); 

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Semua perubahan yang belum disimpan akan hilang.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, keluar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                  
                    window.history.back(); 
                }
            });
        });
    });
    // waktu selesai
    document.getElementById('kode_mk').addEventListener('input', function() {
    const kodeMk = document.getElementById('kode_mk').value;

    if (!kodeMk) return;

    // Lakukan AJAX untuk mendapatkan SKS berdasarkan kode MK
    $.ajax({
        url: "{{ route('jadwal.check-kode-mk') }}",
        method: "POST",
        data: {
            "_token": "{{ csrf_token() }}",
            "kode_mk": kodeMk
        },
        success: function(response) {

            // Simpan SKS dari response
            window.sks = response.sks;
            
            const waktuMulai = document.getElementById('waktu_mulai').value;
            if (waktuMulai) {
                hitungWaktuSelesai(waktuMulai);
            }
        }
    });

    // Event listener untuk waktu mulai
    document.getElementById('waktu_mulai').addEventListener('input', function() {
        const waktuMulai = document.getElementById('waktu_mulai').value;

        // Jika waktu mulai kosong, jangan lakukan apa-apa
        if (!waktuMulai || !window.sks) return;

        // Hitung waktu selesai jika SKS sudah tersedia
        hitungWaktuSelesai(waktuMulai);
    });

    // Fungsi untuk menghitung waktu selesai
    function hitungWaktuSelesai(waktuMulai) {
        const sks = window.sks; // Mengambil SKS yang sudah diset

        // Hitung waktu selesai berdasarkan SKS
        let [hours, minutes] = waktuMulai.split(':').map(num => parseInt(num));
        let startMinutes = (hours * 60) + minutes;

        // Durasi berdasarkan SKS (1 SKS = 50 menit)
        let duration = sks * 50;

        // Hitung waktu selesai
        let endMinutes = startMinutes + duration;
        let endHours = Math.floor(endMinutes / 60);
        let endMin = endMinutes % 60;

        // Format waktu selesai menjadi HH:mm
        let endTime = `${String(endHours).padStart(2, '0')}:${String(endMin).padStart(2, '0')}`;

        // Set nilai waktu selesai di input form
        document.getElementById('waktu_selesai').value = endTime;
    }

    
});
</script>

@endsection
