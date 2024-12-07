@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    {{-- <h1 class="text-3xl font-semibold mb-4 text-center"> --}}
        @if($prodi)
        <h1 class="text-3xl font-semibold mb-4 text-center">
            Jadwal Kuliah {{ $prodi->nama_prodi }} {{ $tahun_ajaran->tahun_ajaran }}
        </h1>
        @else
            <p>Program Studi tidak ditemukan.</p>
        @endif
    

    <!-- Tombol untuk menambah jadwal baru -->
    <a href="{{ route('jadwal.create') }}" class="inline-block bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 mb-4">Tambah Jadwal Baru</a>

    <!-- Tabel Jadwal -->
    <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-300">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-3  text-sm font-semibold text-center">No</th>
                    <th class="px-4 py-3  text-sm font-semibold text-center">Kode MK</th>
                    <th class="px-4 py-3  text-sm font-semibold text-center">Nama MK</th>
                    <th class="px-4 py-3  text-sm font-semibold text-center">Kelas</th>
                    <th class="px-4 py-3  text-sm font-semibold text-center">Hari</th>
                    <th class="px-4 py-3  text-sm font-semibold text-center">Waktu Mulai</th>
                    <th class="px-4 py-3  text-sm font-semibold text-center">Waktu Selesai</th>
                    <th class="px-4 py-3  text-sm font-semibold text-center">Ruang</th>
                    <th class="px-4 py-3  text-sm font-semibold text-center">Kuota</th>
                    <th class="px-4 py-3  text-sm font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($jadwals as $jadwal)
                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                        <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-sm">{{ $jadwal->kode_mk }}</td>
                        <!-- Menampilkan Nama MK dengan pengecekan null -->
                        <td class="px-4 py-3 text-sm"> {{$jadwal->nama_mk }}</td>
                        <td class="px-4 py-3 text-sm">{{ $jadwal->kelas }}</td>
                        <td class="px-4 py-3 text-sm">
                            @php
                                $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                            @endphp
                        
                            {{ $hari[$jadwal->hari - 1] ?? 'Minggu' }}
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $jadwal->waktu_mulai }}</td>
                        <td class="px-4 py-3 text-sm">{{ $jadwal->waktu_selesai }}</td>
                        <!-- Menampilkan Nama Ruang dengan pengecekan null -->
                        <td class="px-4 py-3 text-sm">{{ $jadwal->id_ruang }}</td>
                        <td class="px-4 py-3 text-sm">{{ $jadwal->kuota }}</td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('jadwal.edit', $jadwal->id_jadwal) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">Edit</a>
                            <!-- Tombol Delete -->
                            <button class="bg-red-500  text-white px-4 py-2 rounded-md hover:bg-red-600" onclick="deleteJadwal({{ $jadwal->id_jadwal }})">Delete</button>
                            {{-- <button class="bg-red-500  text-white px-4 py-2 rounded-md hover:bg-red-600" onclick="deleteJadwal({{ $jadwal->id_jadwal }})">Delete</button> --}}

                        </td>
                    </tr>
                @empty
                    <!-- Tampilkan pesan jika tidak ada jadwal -->
                    <tr>
                        <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada jadwal yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function deleteJadwal(id) {
        // Ambil parameter id_tahun dan id_prodi dari query string
        const id_tahun = new URLSearchParams(window.location.search).get('id_tahun');
        const id_prodi = new URLSearchParams(window.location.search).get('id_prodi');

        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data ini akan dihapus secara permanen.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                // Membuat form delete secara dinamis dan menambahkan parameter query
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '/jadwal/' + id;

                // Tambahkan csrf token
                let csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Tambahkan method DELETE
                let methodDelete = document.createElement('input');
                methodDelete.type = 'hidden';
                methodDelete.name = '_method';
                methodDelete.value = 'DELETE';
                form.appendChild(methodDelete);

                // Tambahkan parameter id_tahun dan id_prodi
                let idTahunInput = document.createElement('input');
                idTahunInput.type = 'hidden';
                idTahunInput.name = 'id_tahun';
                idTahunInput.value = id_tahun;
                form.appendChild(idTahunInput);

                let idProdiInput = document.createElement('input');
                idProdiInput.type = 'hidden';
                idProdiInput.name = 'id_prodi';
                idProdiInput.value = id_prodi;
                form.appendChild(idProdiInput);

                // Tambahkan form ke body dan submit
                document.body.appendChild(form);
                form.submit();

                Swal.fire(
                    'Terhapus!',
                    'Jadwal telah dihapus.',
                    'success'
                );
            }
        });
    }
</script>



@endsection
