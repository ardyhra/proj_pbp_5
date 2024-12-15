
@extends('layouts.app')
@section('title', 'SISKARA - Manajemen Jadwal')
@section('content')
<div class="container mx-auto mt-10">
    <div class="mb-5">
        <h1 class="text-3xl font-semibold mb-4 text-center">
            Manajemen Jadwal Kuliah Kaprodi
        </h1>
    </div>
    
    <!-- Form untuk memilih Tahun Ajaran dan Program Studi -->
    <form action="{{ route('jadwal.view') }}" method="GET" class="mb-5">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="id_tahun" class="block">Tahun Ajaran</label>
                <select name="id_tahun" id="id_tahun" class="w-full p-2 border rounde">
                    <option value="" disabled selected>Pilih Tahun Ajaran</option>
                    @foreach($tahunajarans as $tahun)
                        <option value="{{ $tahun->id_tahun }}" {{ request('id_tahun') == $tahun->id_tahun ? 'selected' : '' }}>
                            {{ $tahun->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="id_prodi" class="block">Program Studi</label>
                <select name="id_prodi" id="id_prodi" class="w-full p-2 border rounde">
                    <option value="" disabled selected>Pilih Program Studi</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id_prodi }}" {{ request('id_prodi') == $prodi->id_prodi ? 'selected' : '' }}>
                            {{$prodi->strata  }} - {{ $prodi->nama_prodi }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition">Filter Jadwal</button>
    </form>
</div>

@endsection


