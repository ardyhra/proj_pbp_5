{{-- @extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-semibold mb-4 text-center">Create Jadwal Kuliah</h1>

    <!-- Form Create Jadwal -->
    <form id="createForm" action="{{ route('jadwal.store') }}" method="POST">
        @csrf
        <!-- Dropdown dan input lainnya -->
        <div class="mb-4">
            <label for="kode_mk" class="block">Kode MK</label>
            <select name="kelas" id="kelas" class="w-full p-2 border rounded">
                @foreach($matakuliah as $mk)
                    <option value="{{ $mk->kode_mk }}">{{ $mk->kode_mk }} - {{ $mk->nama_mk }}</option>
                @endforeach
            </datalist>
        </div>
    
        <div class="mb-4">
            <label for="kelas" class="block">Kelas</label>
            <select name="kelas" id="kelas" class="w-full p-2 border rounded">
                <option value="">Pilih Kelas</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
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
            <input type="number" id="kuota" name="kuota" class="w-full p-2 border rounded" value="30">
        </div>
    
        <button type="button" id="createButton" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Create Jadwal
        </button>
    </form>
    
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Menambahkan event listener untuk tombol Create Jadwal
    document.getElementById('createButton').addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah form langsung disubmit

        // Menampilkan SweetAlert2 untuk konfirmasi
        Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Pastikan data yang Anda masukkan sudah benar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user klik 'Ya, simpan'
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Jadwal berhasil dibuat.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    document.getElementById('createForm').submit(); // Submit form setelah konfirmasi
                });
            } else {
                // Jika user klik 'Batal'
                Swal.fire({
                    title: 'Batal!',
                    text: 'Data tidak disimpan.',
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>

@endsection
 --}}

 @extends('layouts.app')

 @section('content')
 <div class="container mx-auto mt-10">
     <h1 class="text-3xl font-semibold mb-4">Buat Jadwal Kuliah</h1>
 
     <!-- Form Create Jadwal -->
     <form id="createForm" action="{{ route('jadwal.store') }}" method="POST">
         @csrf
 
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
        </div>
     </form>
 </div>
 
 @endsection
 
 @push('scripts')
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
    document.getElementById('submitButton').addEventListener('click', function(event) {
    event.preventDefault(); // Mencegah form langsung disubmit
    // console.log('Button clicked!'); // Menambah log untuk cek

    // Validasi form
    const kodeMk = document.getElementById('kode_mk').value;
    const kelas = document.getElementById('kelas').value;
    const ruang = document.getElementById('id_ruang').value;
    const hari = document.getElementById('hari').value;
    const waktuMulai = document.getElementById('waktu_mulai').value;
    const waktuSelesai = document.getElementById('waktu_selesai').value;
    const kuota = document.getElementById('kuota').value;

    console.log({kodeMk, kelas, ruang, hari, waktuMulai, waktuSelesai, kuota}); // Menambah log

    // if (!kodeMk || !kelas || !ruang || !hari || !waktuMulai || !waktuSelesai || !kuota) {
    //     Swal.fire({
    //         icon: "error",
    //         title: "Oops...",
    //         text: "Semua field wajib diisi.",
    //         footer: '<a href="#">Kenapa ini terjadi?</a>'
    //     });
    //     return; // Menghentikan eksekusi jika ada field yang kosong
    // }

    // Menampilkan SweetAlert2 untuk konfirmasi
    Swal.fire({
        title: "Apakah Anda Yakin?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Buat Jadwal",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            // Menampilkan SweetAlert sukses setelah data disubmit
            Swal.fire({
                title: 'Jadwal Tersimpan!',
                text: 'Jadwal kuliah berhasil dibuat.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Submit form setelah konfirmasi
                document.getElementById('createForm').submit();
            });
        } else if (result.isDenied) {
            Swal.fire("Changes are not saved", "", "info");
        }
    });
});

 </script>
 @endpush
 
