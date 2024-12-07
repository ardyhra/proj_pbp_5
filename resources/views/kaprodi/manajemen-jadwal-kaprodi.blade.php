

{{-- @extends('layouts.app')

@section('content')
    <!-- Tampilkan pesan error jika ada -->
    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-8">
            {{ session('error') }}
        </div>
    @endif

    <!-- Dropdown Tahun Ajaran -->
    <div class="mb-8">
        <label for="tahun_ajaran" class="block text-lg font-semibold">Pilih Tahun Ajaran</label>
        <select id="tahun_ajaran" name="id_tahun" onchange="window.location.href=this.value"
                class="px-6 py-3 rounded-lg text-lg font-semibold bg-gray-300 text-gray-800 w-full">
            <option value="" disabled selected>Pilih Tahun Ajaran</option>

            @foreach($tahunAjarans as $tahun)
                <option value="{{ route('manajemen-jadwal-kaprodi.index', ['semester' => $semester, 'id_tahun' => $tahun->id_tahun]) }}"
                    {{ request('id_tahun') == $tahun->id_tahun ? 'selected' : '' }}>
                    {{ $tahun->tahun_ajaran }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Menampilkan Daftar Semester Berdasarkan Tahun Ajaran -->
    <div class="grid gap-4">
        @if($semesterType === 'ganjil')
            <!-- Semester Ganji -->
            @foreach([1, 3, 5, 7] as $sem)
            <div class="flex justify-between items-center bg-gray-100 p-6 rounded-lg shadow-md">
                <span class="text-xl font-semibold">Semester {{ $sem }}</span>
                <div class="flex space-x-4">
                    <!-- Menampilkan Jadwal untuk Semester yang Dipilih -->
                    @foreach($jadwals as $item)
                        @if($item->matakuliah->plot_semester == 'ganjil' && in_array($sem, [1, 3, 5, 7]))
                            <a href="{{ route('jadwal.view', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-blue-500 hover:underline">Lihat</a> |

                            <a href="{{ route('jadwal.edit', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-yellow-500 hover:underline">Edit</a> |

                            <a href="{{ route('jadwal.apply', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-green-500 hover:underline">Apply</a>
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        @elseif($semesterType === 'genap')
            <!-- Semester Genap -->
            @foreach([2, 4, 6, 8] as $sem)
            <div class="flex justify-between items-center bg-gray-100 p-6 rounded-lg shadow-md">
                <span class="text-xl font-semibold">Semester {{ $sem }}</span>
                <div class="flex space-x-4">
                    <!-- Menampilkan Jadwal untuk Semester yang Dipilih -->
                    @foreach($jadwals as $item)
                        @if($item->matakuliah->plot_semester == 'genap' && in_array($sem, [2, 4, 6, 8]))
                            <a href="{{ route('jadwal.view', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-blue-500 hover:underline">Lihat</a> |

                            <a href="{{ route('jadwal.edit', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-yellow-500 hover:underline">Edit</a> |

                            <a href="{{ route('jadwal.apply', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-green-500 hover:underline">Apply</a>
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        @endif
    </div>

@endsection --}}

{{-- fix --}}
{{-- @extends('layouts.app')

@section('content')
    <!-- Tampilkan pesan error jika ada -->
    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-8">
            {{ session('error') }}
        </div>
    @endif

    <!-- Dropdown Tahun Ajaran -->
    <div class="mb-8">
        <label for="tahun_ajaran" class="block text-lg font-semibold">Pilih Tahun Ajaran</label>
        <select id="tahun_ajaran" name="id_tahun" onchange="window.location.href=this.value"
                class="px-6 py-3 rounded-lg text-lg font-semibold bg-gray-300 text-gray-800 w-full">
            <option value="" disabled selected>Pilih Tahun Ajaran</option>

            @foreach($tahunAjarans as $tahun)
                <option value="{{ route('manajemen-jadwal-kaprodi.index', ['semester' => $semester, 'id_tahun' => $tahun->id_tahun]) }}"
                    {{ request('id_tahun') == $tahun->id_tahun ? 'selected' : '' }}>
                    {{ $tahun->tahun_ajaran }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Menampilkan Daftar Semester Berdasarkan Tahun Ajaran -->
    <div class="grid gap-4">
        @if($semesterType === 'ganjil')
            <!-- Semester Ganji -->
            @foreach([1, 3, 5, 7] as $sem)
            <div class="flex justify-between items-center bg-gray-100 p-6 rounded-lg shadow-md">
                <span class="text-xl font-semibold">Semester {{ $sem }}</span>
                <div class="flex space-x-4">
                    <!-- Menampilkan Jadwal untuk Semester yang Dipilih -->
                    @foreach($jadwals as $item)
                        @if($item->matakuliah->plot_semester == $sem)
                            <a href="{{ route('jadwal.view', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-blue-500 hover:underline">Lihat</a> |

                            <a href="{{ route('jadwal.edit', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-yellow-500 hover:underline">Edit</a> |

                            <a href="{{ route('jadwal.apply', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-green-500 hover:underline">Apply</a>
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        @elseif($semesterType === 'genap')
            <!-- Semester Genap -->
            @foreach([2, 4, 6, 8] as $sem)
            <div class="flex justify-between items-center bg-gray-100 p-6 rounded-lg shadow-md">
                <span class="text-xl font-semibold">Semester {{ $sem }}</span>
                <div class="flex space-x-4">
                    <!-- Menampilkan Jadwal untuk Semester yang Dipilih -->
                    @foreach($jadwals as $item)
                        @if($item->matakuliah->plot_semester == $sem)
                            <a href="{{ route('jadwal.view', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-blue-500 hover:underline">Lihat</a> |

                            <a href="{{ route('jadwal.edit', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-yellow-500 hover:underline">Edit</a> |

                            <a href="{{ route('jadwal.apply', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-green-500 hover:underline">Apply</a>
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        @endif
    </div>

@endsection --}}

{{-- @extends('layouts.app')

@section('content')
    <!-- Tampilkan pesan error jika ada -->
    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-8">
            {{ session('error') }}
        </div>
    @endif

    <!-- Dropdown Tahun Ajaran -->
    <div class="mb-8">
        <label for="tahun_ajaran" class="block text-lg font-semibold">Pilih Tahun Ajaran</label>
        <select id="tahun_ajaran" name="id_tahun" onchange="window.location.href=this.value"
                class="px-6 py-3 rounded-lg text-lg font-semibold bg-gray-300 text-gray-800 w-full">
            <option value="" disabled selected>Pilih Tahun Ajaran</option>

            @foreach($tahunAjarans as $tahun)
                <option value="{{ route('manajemen-jadwal-kaprodi.index', ['semester' => $semester, 'id_tahun' => $tahun->id_tahun]) }}"
                    {{ request('id_tahun') == $tahun->id_tahun ? 'selected' : '' }}>
                    {{ $tahun->tahun_ajaran }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Menampilkan Daftar Semester Berdasarkan Tahun Ajaran -->
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        @if($semesterType === 'ganjil')
            <!-- Semester Ganjil -->
            @foreach([1, 3, 5, 7] as $sem)
            <div class="flex flex-col items-center bg-gray-100 p-6 rounded-lg shadow-md">
                <span class="text-xl font-semibold mb-4">Semester {{ $sem }}</span>
                <div class="flex flex-col space-y-4">
                    <!-- Menampilkan Jadwal untuk Semester yang Dipilih -->
                    @foreach($jadwals as $item)
                        @if($item->matakuliah->plot_semester == $sem)
                            <div class="flex justify-between w-full">
                                <span class="font-semibold">{{ $item->matakuliah->kode_mk }}</span>
                                <div class="flex space-x-2">
                                    <a href="{{ route('jadwal.view', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-blue-500 hover:underline">Lihat</a>
                                    <a href="{{ route('jadwal.edit', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-yellow-500 hover:underline">Edit</a>
                                    <a href="{{ route('jadwal.apply', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-green-500 hover:underline">Apply</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        @elseif($semesterType === 'genap')
            <!-- Semester Genap -->
            @foreach([2, 4, 6, 8] as $sem)
            <div class="flex flex-col items-center bg-gray-100 p-6 rounded-lg shadow-md">
                <span class="text-xl font-semibold mb-4">Semester {{ $sem }}</span>
                <div class="flex flex-col space-y-4">
                    <!-- Menampilkan Jadwal untuk Semester yang Dipilih -->
                    @foreach($jadwals as $item)
                        @if($item->matakuliah->plot_semester == $sem)
                            <div class="flex justify-between w-full">
                                <span class="font-semibold">{{ $item->matakuliah->kode_mk }}</span>
                                <div class="flex space-x-2">
                                    <a href="{{ route('jadwal.view', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-blue-500 hover:underline">Lihat</a>
                                    <a href="{{ route('jadwal.edit', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-yellow-500 hover:underline">Edit</a>
                                    <a href="{{ route('jadwal.apply', ['id' => $item->id_jadwal, 'semester' => 'semester' . $sem, 'id_tahun' => request('id_tahun')]) }}" class="text-green-500 hover:underline">Apply</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        @endif
    </div>

@endsection --}}

    
    
{{-- @extends('layouts.app')

@section('content')
    <div class="mb-8">
        <!-- Dropdown Tahun Ajaran -->
        <label for="tahun_ajaran" class="block text-lg font-semibold">Pilih Tahun Ajaran</label>
        <select id="tahun_ajaran" name="id_tahun" onchange="loadJadwal()"
                class="px-6 py-3 rounded-lg text-lg font-semibold bg-gray-300 text-gray-800 w-full">
            <option value="" disabled selected>Pilih Tahun Ajaran</option>
            
            @foreach($tahunAjarans as $tahun)
                <option value="{{ $tahun->id_tahun }}" {{ request('id_tahun') == $tahun->id_tahun ? 'selected' : '' }}>
                    {{ $tahun->tahun_ajaran }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Menampilkan Tabel Jadwal Berdasarkan Tahun Ajaran -->
    <div id="jadwal_table">
        @if($jadwals->isEmpty())
            <p class="text-red-500">Tidak ada jadwal untuk tahun ajaran yang dipilih.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-blue-500 text-white">
                            <th class="border border-gray-300 px-4 py-2">Mata Kuliah</th>
                            <th class="border border-gray-300 px-4 py-2">Dosen</th>
                            <th class="border border-gray-300 px-4 py-2">Waktu</th>
                            <th class="border border-gray-300 px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwals as $jadwal)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $jadwal->kode_mk }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $jadwal->dosen->nama }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $jadwal->hari }} - {{ $jadwal->waktu_mulai }} s.d. {{ $jadwal->waktu_selesai }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route('jadwal.view', ['id' => $jadwal->id_jadwal]) }}" class="text-blue-500 hover:underline">Lihat</a> |
                                    <a href="{{ route('jadwal.edit', ['id' => $jadwal->id_jadwal]) }}" class="text-yellow-500 hover:underline">Edit</a> |
                                    <a href="{{ route('jadwal.apply', ['id' => $jadwal->id_jadwal]) }}" class="text-green-500 hover:underline">Apply</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Fungsi untuk memuat jadwal berdasarkan tahun ajaran yang dipilih
    function loadJadwal() {
        var id_tahun = $('#tahun_ajaran').val();
        $.ajax({
            url: '{{ route('get.jadwal.by.tahun') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id_tahun: id_tahun
            },
            success: function(response) {
                $('#jadwal_table').html('');
                if (response.jadwals.length > 0) {
                    var table = '<div class="overflow-x-auto">';
                    table += '<table class="w-full table-auto border-collapse border border-gray-300">';
                    table += '<thead><tr class="bg-blue-500 text-white"><th class="border border-gray-300 px-4 py-2">Mata Kuliah</th><th class="border border-gray-300 px-4 py-2">Dosen</th><th class="border border-gray-300 px-4 py-2">Waktu</th><th class="border border-gray-300 px-4 py-2">Aksi</th></tr></thead>';
                    table += '<tbody>';
                    response.jadwals.forEach(function(jadwal) {
                        table += '<tr>';
                        table += '<td class="border border-gray-300 px-4 py-2">' + jadwal.kode_mk + '</td>';
                        table += '<td class="border border-gray-300 px-4 py-2">' + jadwal.dosen.nama + '</td>';
                        table += '<td class="border border-gray-300 px-4 py-2">' + jadwal.hari + ' - ' + jadwal.waktu_mulai + ' s.d. ' + jadwal.waktu_selesai + '</td>';
                        table += '<td class="border border-gray-300 px-4 py-2"><a href="/jadwal/view/' + jadwal.id_jadwal + '" class="text-blue-500 hover:underline">Lihat</a> | <a href="/jadwal/edit/' + jadwal.id_jadwal + '" class="text-yellow-500 hover:underline">Edit</a> | <a href="/jadwal/apply/' + jadwal.id_jadwal + '" class="text-green-500 hover:underline">Apply</a></td>';
                        table += '</tr>';
                    });
                    table += '</tbody></table></div>';
                    $('#jadwal_table').html(table);
                } else {
                    $('#jadwal_table').html('<p class="text-red-500">Tidak ada jadwal untuk tahun ajaran yang dipilih.</p>');
                }
            }
        });
    }
</script>
@endsection --}}


    {{-- fix  --}}
{{-- @extends('layouts.app')

@section('content')
    <!-- Dropdown Tahun Ajaran -->
    <div class="mb-8">
        <label for="id_tahun" class="block text-lg font-semibold">Pilih Tahun Ajaran</label>
        <select id="id_tahun" name="id_tahun" onchange="window.location.href=this.value"
                class="px-6 py-3 rounded-lg text-lg font-semibold bg-gray-300 text-gray-800 w-full">
            <option value="" disabled selected>Pilih Tahun Ajaran</option>
            @foreach($tahunajarans as $tahun)
                <option value="{{ route('manajemen-jadwal-kaprodi.index', ['id_tahun' => $tahun->id_tahun, 'id_prodi' => request('id_prodi')]) }}"
                        {{ request('id_tahun') == $tahun->id_tahun ? 'selected' : '' }}>
                    {{ $tahun->tahun_ajaran }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Dropdown Program Studi -->
    <div class="mb-8">
        <label for="id_prodi" class="block text-lg font-semibold">Pilih Program Studi</label>
        <select id="id_prodi" name="id_prodi" onchange="window.location.href=this.value"
                class="px-6 py-3 rounded-lg text-lg font-semibold bg-gray-300 text-gray-800 w-full">
            <option value="" disabled selected>Pilih Program Studi</option>
            @foreach($prodis as $prodi)
                <option value="{{ route('manajemen-jadwal-kaprodi.index', ['id_tahun' => request('id_tahun'), 'id_prodi' => $prodi->id_prodi]) }}"
                        {{ request('id_prodi') == $prodi->id_prodi ? 'selected' : '' }}>
                    {{ $prodi->nama_prodi }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Daftar Jadwal -->
    <div class="grid gap-4">
        @foreach($jadwals as $jadwal)
        <div class="flex justify-between items-center bg-gray-100 p-6 rounded-lg shadow-md">
            <span class="text-xl font-semibold">{{ $jadwal->kode_mk }} - {{ $jadwal->kelas }}</span>
            <div class="flex space-x-4">
                <!-- Lihat -->
                <a href="{{ route('jadwal.view', ['id' => $jadwal->id_jadwal]) }}" class="text-blue-500 hover:underline">Lihat</a>

                <!-- Edit -->
                <a href="{{ route('jadwal.edit', ['id' => $jadwal->id_jadwal]) }}" class="text-yellow-500 hover:underline">Edit</a>

                <!-- Apply -->
                <a href="{{ route('jadwal.apply', ['id' => $jadwal->id_jadwal]) }}" class="text-green-500 hover:underline">Apply</a>
            </div>
        </div>
        @endforeach
    </div>
@endsection --}}



{{-- kapan fix --}}
{{-- @extends('layouts.app')

@section('content')
        <!-- Dropdown Program Studi -->
        <div class="mb-8">
            <label for="id_prodi" class="block text-lg font-semibold">Pilih Program Studi</label>
            <select id="id_prodi" name="id_prodi" onchange="loadJadwal()"
                    class="px-6 py-3 rounded-lg text-lg font-semibold bg-gray-300 text-gray-800 w-full">
                <option value="" disabled selected>Pilih Program Studi</option>  <!-- Pilihan awal -->
                @foreach($prodis as $prodi)
                    <option value="{{ $prodi->id_prodi }}" {{ request('id_prodi') == $prodi->id_prodi? 'selected' : '' }}>
                        {{ $prodi->nama_prodi }}
                    </option>
                @endforeach
            </select>
        </div>
        
    
    <!-- Dropdown Tahun Ajaran -->
    <div class="mb-8">
        <label for="tahun_ajaran" class="block text-lg font-semibold">Pilih Tahun Ajaran</label>
        <select id="tahun_ajaran" name="id_tahun" onchange="loadJadwal()"
                class="px-6 py-3 rounded-lg text-lg font-semibold bg-gray-300 text-gray-800 w-full">
            <option value="" disabled selected>Pilih Tahun Ajaran</option>
            @foreach($tahunAjarans as $tahun)
                <option value="{{ $tahun->id_tahun }}" {{ request('id_tahun') == $tahun->id_tahun ? 'selected' : '' }}>
                    {{ $tahun->tahun_ajaran }}
                </option>
            @endforeach
        </select>
    </div>

    <div id="jadwal-list" class="grid gap-4">
        @foreach($jadwals as $jadwal)
            <div class="flex justify-between items-center bg-gray-100 p-6 rounded-lg shadow-md">
                <span class="text-xl font-semibold">{{ $jadwal->kode_mk }} - {{ $jadwal->kelas }}</span>
                <div class="flex space-x-4">
                    <!-- Lihat -->
                    <a href="{{ route('jadwal.view', ['id' => $jadwal->id_jadwal]) }}" class="text-blue-500 hover:underline">Lihat</a>

                    <!-- Edit -->
                    <a href="{{ route('jadwal.edit', ['id' => $jadwal->id_jadwal]) }}" class="text-yellow-500 hover:underline">Edit</a>

                    <!-- Apply -->
                    <a href="{{ route('jadwal.apply', ['id' => $jadwal->id_jadwal]) }}" class="text-green-500 hover:underline">Apply</a>
                </div>
            </div>
        @endforeach
    </div>

@endsection

@push('scripts')
    <script>
        function loadJadwal() {
            var id_tahun = document.getElementById('id_tahun').value;
            var id_prodi = document.getElementById('id_prodi').value;

            if (id_tahun && id_prodi) {
                $.ajax({
                    url: '{{ route("getJadwalByTahunProdi") }}',
                    method: 'GET',
                    data: { id_tahun: id_tahun, id_prodi: id_prodi },
                    success: function(response) {
                        var jadwalList = $('#jadwal-list');
                        jadwalList.empty();

                        if(response.jadwals.length > 0) {
                            response.jadwals.forEach(function(jadwal) {
                                jadwalList.append(`
                                    <div class="flex justify-between items-center bg-gray-100 p-6 rounded-lg shadow-md">
                                        <span class="text-xl font-semibold">${jadwal.id_tahun} - ${jadwal.id_prodi}</span>
                                        <div class="flex space-x-4">
                                            <a href="/jadwal/view/${jadwal.id_jadwal}" class="text-blue-500 hover:underline">Lihat</a>
                                            <a href="/jadwal/edit/${jadwal.id_jadwal}" class="text-yellow-500 hover:underline">Edit</a>
                                            <a href="/jadwal/apply/${jadwal.id_jadwal}" class="text-green-500 hover:underline">Apply</a>
                                        </div>
                                    </div>
                                `);
                            });
                        } else {
                            jadwalList.append('<p>No data found for the selected filters.</p>');
                        }
                    }
                });
            }
        }
    </script>
@endpush --}}




{{-- fix kpn --}}
<!-- resources/views/manajemen-jadwal-kaprodi.blade.php -->
{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manajemen Jadwal Kuliah Kaprodi</h1>

    <!-- Form untuk memilih Tahun Ajaran dan Program Studi -->
    <form action="{{ route('jdawal.kaprodi') }}" method="GET" class="mb-3">
        @csrf
        <div class="form-group">
            <label for="id_tahun">Tahun Ajaran</label>
            <select name="id_tahun" id="id_tahun" class="form-control" required>
                @foreach($tahunajarans as $tahun)
                    <option value="{{ $tahun->id_tahun }}" {{ request('id_tahun') == $tahun->id_tahun ? 'selected' : '' }}>
                        {{ $tahun->tahun_ajaran}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="id_prodi">Program Studi</label>
            <select name="id_prodi" id="id_prodi" class="form-control" required>
                @foreach($prodis as $p)
                    <option value="{{ $p->id_prodi }}" {{ request('id_prodi') == $p->id_prodi ? 'selected' : '' }}>
                        {{ $p->nama_prodi }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Filter Jadwal</button>
    </form>

    <a href="{{ route('jadwal.create') }}" class="btn btn-success mb-3">Tambah Jadwal Baru</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode MK</th>
                <th>Nama MK</th>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Ruang</th>
                <th>Kuota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jadwals as $jadwal)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jadwal->kode_mk }}</td>
                    <td>{{ $jadwal->matakuliah->nama_mk }}</td>
                    <td>{{ $jadwal->kelas }}</td>
                    <td>{{ $jadwal->hari }}</td>
                    <td>{{ $jadwal->waktu_mulai }}</td>
                    <td>{{ $jadwal->waktu_selesai }}</td>
                    <td>{{ $jadwal->ruang->nama_ruang }}</td>
                    <td>{{ $jadwal->kuota }}</td>
                    <td>
                        <a href="{{ route('jadwal.edit', $jadwal->id_jadwal) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('jadwal.destroy', $jadwal->id_jadwal) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada jadwal yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection --}}


{{-- @extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Manajemen Jadwal Kuliah Kaprodi</h1>

    <!-- Form untuk memilih Tahun Ajaran dan Program Studi -->
    <form action="{{ route('jadwal.kaprodi') }}" method="GET" class="mb-3">
        <div class="form-group mb-4">
            <label for="id_tahun">Tahun Ajaran</label>
            <select name="id_tahun" id="id_tahun" class="form-control" required>
                <option value="" disabled selected>Pilih Tahun Ajaran</option>
                @foreach($tahunajarans as $tahun)
                    <option value="{{ $tahun->id_tahun }}" {{ request('id_tahun') == $tahun->id_tahun ? 'selected' : '' }}>
                        {{ $tahun->tahun_ajaran }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group mb-4">
            <label for="id_prodi">Program Studi</label>
            <select name="id_prodi" id="id_prodi" class="form-control" required>
                <option value="" disabled selected>Pilih Program Studi</option>
                @foreach($prodis as $p)
                    <option value="{{ $p->id_prodi }}" {{ request('id_prodi') == $p->id_prodi ? 'selected' : '' }}>
                        {{ $p->nama_prodi }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <button type="submit" class="btn btn-primary">Filter Jadwal</button>
    </form>
    
    <a href="{{ route('jadwal.create') }}" class="btn btn-success mb-3">Tambah Jadwal Baru</a>

    <!-- Tabel Jadwal -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="bg-primary text-white">
                    <th>No</th>
                    <th>Kode MK</th>
                    <th>Nama MK</th>
                    <th>Kelas</th>
                    <th>Hari</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Ruang</th>
                    <th>Kuota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $jadwal)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $jadwal->kode_mk }}</td>
                        <td>{{ $jadwal->matakuliah->nama_mk }}</td>
                        <td>{{ $jadwal->kelas }}</td>
                        <td>{{ $jadwal->hari }}</td>
                        <td>{{ $jadwal->waktu_mulai }}</td>
                        <td>{{ $jadwal->waktu_selesai }}</td>
                        <td>{{ $jadwal->ruang->nama_ruang }}</td>
                        <td>{{ $jadwal->kuota }}</td>
                        <td>
                            <a href="{{ route('jadwal.edit', $jadwal->id_jadwal) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('jadwal.destroy', $jadwal->id_jadwal) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada jadwal yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection --}}

<!-- resources/views/manajemen-jadwal-kaprodi.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-semibold mb-4">Manajemen Jadwal Kuliah Kaprodi</h1>

    <!-- Form untuk memilih Tahun Ajaran dan Program Studi -->
    <form action="{{ route('jadwal.view') }}" method="GET" class="mb-5">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="id_tahun" class="block text-lg">Tahun Ajaran</label>
                <select name="id_tahun" id="id_tahun" class="form-select mt-1 block w-full">
                    <option value="" disabled selected>Pilih Tahun Ajaran</option>
                    @foreach($tahunajarans as $tahun)
                        <option value="{{ $tahun->id_tahun }}" {{ request('id_tahun') == $tahun->id_tahun ? 'selected' : '' }}>
                            {{ $tahun->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="id_prodi" class="block text-lg">Program Studi</label>
                <select name="id_prodi" id="id_prodi" class="form-select mt-1 block w-full">
                    <option value="" disabled selected>Pilih Program Studi</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id_prodi }}" {{ request('id_prodi') == $prodi->id_prodi ? 'selected' : '' }}>
                            {{ $prodi->nama_prodi }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition">Filter Jadwal</button>
    </form>
</div>
@endsection


