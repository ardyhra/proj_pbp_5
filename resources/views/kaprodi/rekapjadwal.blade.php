@extends('layouts.app')
@section('title', 'Rekap Jadwal Kuliah Kaprodi')
@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-semibold mb-4 text-center">Rekap Jadwal Kuliah Kaprodi</h1>

    <!-- Form untuk memilih Tahun Ajaran dan Program Studi -->
    <form id="filter-form" action="{{ route('rekapjadwal') }}" method="GET" class="mb-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Tahun Ajaran -->
            <div class="mb-4">
                <label for="id_tahun" class="block">Tahun Ajaran</label>
                <select name="id_tahun" id="id_tahun" class="w-full p-2 border rounded">
                    <option value="" disabled {{ !request('id_tahun') ? 'selected' : '' }}>Pilih Tahun Ajaran</option>
                    @foreach($tahunajarans as $tahun)
                        <option value="{{ $tahun->id_tahun }}" {{ request('id_tahun') == $tahun->id_tahun ? 'selected' : '' }}>
                            {{ $tahun->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <!-- Program Studi -->
            <div class="mb-4">
                <label for="id_prodi" class="block">Program Studi</label>
                <select name="id_prodi" id="id_prodi" class="w-full p-2 border rounded">
                    <option value="" disabled {{ !request('id_prodi') ? 'selected' : '' }}>Pilih Program Studi</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id_prodi }}" {{ request('id_prodi') == $prodi->id_prodi ? 'selected' : '' }}>
                            {{ $prodi->strata }} - {{ $prodi->nama_prodi }} 
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    
        <div class="mb-2 flex space-x-4">
            <!-- Tombol Filter akan reload halaman dengan parameter id_tahun & id_prodi -->
            <button type="submit" class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition">
                Filter
            </button>
        </div>
    </form>

    @php
        $statusUsulan = null;
        if(request('id_tahun') && request('id_prodi')) {
            $statusUsulan = \App\Models\UsulanJadwal::where('id_tahun', request('id_tahun'))
                ->where('id_prodi', request('id_prodi'))
                ->value('status') ?? 'Belum Diajukan';
        }
    @endphp

    <!-- Jika kedua pilihan (tahun ajaran & prodi) sudah dipilih, tampilkan tombol/tindakan terkait -->
    @if(request('id_tahun') && request('id_prodi'))
        <div class="mb-2 flex space-x-4">
            @if($statusUsulan == 'Diajukan')
                <!-- Jika diajukan, tampilkan tombol batalkan -->
                <form action="{{ route('usulanjadwal.batalkan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_tahun" value="{{ request('id_tahun') }}">
                    <input type="hidden" name="id_prodi" value="{{ request('id_prodi') }}">
                    <button type="button" id="batalkan-jadwal-button" class="mt-4 bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600 transition">
                        Batalkan Usulan
                    </button>
                </form>
            @elseif($statusUsulan == 'Disetujui')
                <!-- Jika disetujui, tampilkan keterangan -->
                <span class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded-md">Usulan jadwal sudah disetujui</span>
            @elseif($statusUsulan == 'Belum Diajukan' || $statusUsulan == 'Ditolak')
                <!-- Jika belum diajukan atau ditolak, tampilkan tombol ajukan -->
                <form action="{{ route('usulanjadwal.ajukan') }}" method="POST" id="ajukan-jadwal-form">
                    @csrf
                    <input type="hidden" name="id_tahun" value="{{ request('id_tahun') }}">
                    <input type="hidden" name="id_prodi" value="{{ request('id_prodi') }}">
                    <button type="button" id="ajukan-jadwal-button" class="mt-4 bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                        Ajukan Jadwal
                    </button>
                </form>
            @endif

            <!-- Tombol Detail untuk melihat rekapan jadwal (muncul jika tahun ajaran dan prodi dipilih) -->
            <a href="javascript:void(0);" id="detail-jadwal-button" class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition">
                Detail Jadwal
            </a>
        </div>
    @endif

    <!-- Tabel Usulan Jadwal -->
    <div id="usulanJadwalTable" class="overflow-x-auto shadow-lg rounded-lg border border-gray-300 hidden">
        <h2 class="text-2xl font-semibold mb-4 text-center">Tabel Usulan Jadwal</h2>
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold text-center">No</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">ID Tahun</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">ID Prodi</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($usulanJadwals as $jadwal)
                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                        <td class="px-4 py-3 text-sm text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-sm text-center">{{ $jadwal->tahunAjaran->tahun_ajaran }}</td>
                        <td class="px-4 py-3 text-sm text-center">{{ $jadwal->prodi->strata }} - {{ $jadwal->prodi->nama_prodi }}</td>
                        <td class="px-4 py-3 text-sm text-center">
                            @if($jadwal->status == 'Diajukan')
                                <span class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">Diajukan</span>
                            @elseif($jadwal->status == 'Disetujui')
                                <span class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Disetujui</span>
                            @elseif($jadwal->status == 'Ditolak')
                                <span class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Ditolak</span>
                            @else
                                <span class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Belum Diajukan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada jadwal yang diajukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tabel Detail Jadwal Usulan -->
    <div id="detailJadwalContainer" class="overflow-x-auto shadow-lg rounded-lg border border-gray-300 hidden mt-6">
        <h2 class="text-2xl font-semibold mb-4 text-center">Detail Jadwal Usulan</h2>
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold text-center">No</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Kode MK</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Nama MK</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Hari</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Waktu</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Ruang</th>
                    <th class="px-4 py-3 text-sm font-semibold text-center">Kelas</th>
                </tr>
            </thead>
            <tbody class="bg-white" id="detailJadwalTabelBody">
                <!-- Akan diisi oleh JavaScript -->
            </tbody>
        </table>
    </div>

</div>


<script>
    document.getElementById('ajukan-jadwal-button')?.addEventListener('click', function () {
        Swal.fire({
            title: 'Yakin?',
            text: "Anda akan mengajukan jadwal ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ajukan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('ajukan-jadwal-form').submit();
            }
        });
    });

    document.getElementById('batalkan-jadwal-button')?.addEventListener('click', function () {
        Swal.fire({
            title: 'Yakin?',
            text: "Anda akan membatalkan usulan jadwal ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Buat form dadakan untuk submit ke route batalkan
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('usulanjadwal.batalkan') }}";
                
                let token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = '{{ csrf_token() }}';
                form.appendChild(token);

                let tahun = document.createElement('input');
                tahun.type = 'hidden';
                tahun.name = 'id_tahun';
                tahun.value = '{{ request('id_tahun') }}';
                form.appendChild(tahun);

                let prodi = document.createElement('input');
                prodi.type = 'hidden';
                prodi.name = 'id_prodi';
                prodi.value = '{{ request('id_prodi') }}';
                form.appendChild(prodi);

                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    document.getElementById('detail-jadwal-button')?.addEventListener('click', function () {
        const id_tahun = document.getElementById('id_tahun').value;
        const id_prodi = document.getElementById('id_prodi').value;

        // Toggle tampilan tabel ringkasan usulan
        const table = document.getElementById('usulanJadwalTable');
        table.classList.toggle('hidden');

        // Jika detail jadwal sudah pernah dimuat, toggle saja
        const detailContainer = document.getElementById('detailJadwalContainer');
        if (!detailContainer.classList.contains('hidden')) {
            detailContainer.classList.add('hidden');
            return;
        }

        // Lakukan fetch detail jadwal
        fetch(`/get-usulan-jadwal-detail/${id_tahun}/${id_prodi}`)
            .then(response => response.json())
            .then(data => {
                // Tampilkan detail jadwal
                const detailBody = document.getElementById('detailJadwalTabelBody');
                detailBody.innerHTML = ''; // Kosongkan isi sebelumnya

                data.jadwal.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.classList.add('hover:bg-gray-100', 'border-b', 'border-gray-200');
                    row.innerHTML = `
                        <td class="px-4 py-3 text-sm text-center">${index+1}</td>
                        <td class="px-4 py-3 text-sm text-center">${item.kode_mk}</td>
                        <td class="px-4 py-3 text-sm text-center">${item.nama_mk}</td>
                        <td class="px-4 py-3 text-sm text-center">${item.hari}</td>
                        <td class="px-4 py-3 text-sm text-center">${item.waktu}</td>
                        <td class="px-4 py-3 text-sm text-center">${item.ruang}</td>
                        <td class="px-4 py-3 text-sm text-center">${item.kelas}</td>
                    `;
                    detailBody.appendChild(row);
                });

                // Setelah data di-load, tampilkan tabel detail
                detailContainer.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching detail data:', error);
                alert('Terjadi kesalahan saat mengambil data detail jadwal.');
            });
    });


    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @elseif(session('error'))
        Swal.fire({
            title: 'Gagal!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @endif
</script>

@endsection

