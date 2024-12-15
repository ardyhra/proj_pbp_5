
{{-- coba ajuin jadwal ke dekan --}}
@extends('layouts.app')
@section('title', 'SISKARA - View Jadwal')
@section('content')
<div class="container mx-auto mt-10">
    <div class="mb-8">
        @if($prodi)
        <h1 class="text-3xl font-semibold mb-4 text-center">
            Jadwal Kuliah {{$prodi->strata}} - {{ $prodi->nama_prodi }} {{ $tahun_ajaran->tahun_ajaran }}
        </h1>
        @else
            <p>Program Studi tidak ditemukan.</p>
        @endif
    </div>
    

    <!-- Tombol untuk menambah jadwal baru dan tombol ajukan -->
    <div class="flex justify-between mb-4">
        <!-- Tombol Tambah Jadwal Baru -->
        <div class="mb-2">
            <a href="{{ route('jadwal.create', ['id_tahun' => $id_tahun, 'id_prodi' => $id_prodi]) }}" class="inline-block bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600">Tambah Jadwal Baru</a>

        </div>
        <!-- Input Pencarian -->
        <div class="mb-2">
            <input type="text" id="search" placeholder="Cari Jadwal..." class="w-full p-2 border-2 border-black hover:border-gray-500 px-6 py-2 rounded-md" onkeyup="searchTable()">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a7 7 0 0114 14A7 7 0 0111 4zm0 0a7 7 0 10-14 14 7 7 0 0014-14z" />
            </svg>
        </div>
    </div>

    <!-- Tabel Jadwal -->
    <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-300">
        <table id="jadwalTable" class="min-w-full table-auto border-collapse">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold text-center">No</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Kode MK</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Nama MK</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Kelas</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Hari</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Waktu Mulai</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Waktu Selesai</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Ruang</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Kuota</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($jadwals as $jadwal)
                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                        <td class="px-4 py-3 text-sm text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-sm text-center">{{ $jadwal->kode_mk }}</td>
                        <td class="px-4 py-3 text-sm text-center">{{ $jadwal->nama_mk }}</td>
                        <td class="px-4 py-3 text-sm text-center">{{ $jadwal->kelas }}</td>
                        <td class="px-4 py-3 text-sm text-center">
                            @php
                                $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                            @endphp
                            {{ $hari[$jadwal->hari - 1] ?? 'Minggu' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-center">{{ $jadwal->waktu_mulai }}</td>
                        <td class="px-4 py-3 text-sm text-center">{{ $jadwal->waktu_selesai }}</td>
                        <td class="px-4 py-3 text-sm text-center">{{ $jadwal->id_ruang }}</td>
                        <td class="px-4 py-3 text-sm text-center">{{ $jadwal->kuota }}</td>
                        <td class="px-4 py-3 text-sm text-center">
                            <a href="{{ route('jadwal.edit', $jadwal->id_jadwal) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">Edit</a>
                            <!-- Tombol Delete -->
                            <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600" onclick="deleteJadwal({{ $jadwal->id_jadwal }})">Delete</button>
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
        const id_tahun = new URLSearchParams(window.location.search).get('id_tahun');
        const id_prodi = new URLSearchParams(window.location.search).get('id_prodi');

        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Jadwal ini akan dihapus secara permanen.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '/jadwal/' + id;

                let csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                let methodDelete = document.createElement('input');
                methodDelete.type = 'hidden';
                methodDelete.name = '_method';
                methodDelete.value = 'DELETE';
                form.appendChild(methodDelete);

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
    // Fungsi untuk mencari di tabel
    function searchTable() {
        let input = document.getElementById("search");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("jadwalTable");
        let trs = table.getElementsByTagName("tr");

        for (let i = 1; i < trs.length; i++) {
            let tds = trs[i].getElementsByTagName("td");
            let found = false;
            for (let j = 0; j < tds.length; j++) {
                if (tds[j]) {
                    let txtValue = tds[j].textContent || tds[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                    }
                }
            }
            trs[i].style.display = found ? "" : "none";
        }
    }
</script>
@endsection

