

@extends('layouts.app')

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

@endsection



    
    
    
    
    






