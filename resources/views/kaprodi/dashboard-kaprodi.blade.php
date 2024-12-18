<!-- resources/views/dashboard-kaprodi.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard Kaprodi')

@section('sidebar')
    <!-- Sidebar -->
    <div class="p-3 pb-1 bg-gray-300 rounded-3xl text-center mb-6">
        <div class="w-24 h-24 mx-auto bg-gray-400 rounded-full mb-3 bg-center bg-contain bg-no-repeat"
             style="background-image: url('{{ asset('img/fsm.jpg') }}')"></div>
        <h2 class="text-lg text-black font-bold">Dr. Aris Sugiharto, S.Si., M.Kom.</h2>
        <p class="text-xs text-gray-800">NIDN 0011087104</p>
        <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Kaprodi</p>
        <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mt-2 block font-semibold hover:bg-opacity-70">Logout</a>
    </div>
    <nav class="space-y-4">
        <a href="{{ url('/dashboard-kaprodi') }}" class="block p-2 bg-sky-800 text-white rounded hover:bg-sky-600">Dashboard</a>
        <a href="{{ url('/manajemen-jadwal-kaprodi') }}" class="block p-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-700 hover:text-white">Manajemen Jadwal</a>
        <a href="{{ url('/rekapjadwal') }}" class="block p-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-700 hover:text-white">Rekap Jadwal</a>
    </nav>
@endsection

@section('content')
    <!-- Main Content -->
    <h1 class="text-3xl font-bold mb-6">Dashboard Kaprodi</h1>
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="p-4 bg-gray-200 rounded-lg text-center">
            <h3 class="text-lg font-semibold">Jumlah Ruang</h3>
            <p class="text-2xl font-bold">26</p>
        </div>
        <div class="p-4 bg-gray-200 rounded-lg text-center">
            <h3 class="text-lg font-semibold">Jumlah Dosen</h3>
            <p class="text-2xl font-bold">39</p>
        </div>
        <div class="p-4 bg-gray-200 rounded-lg text-center">
            <h3 class="text-lg font-semibold">Jumlah Mata Kuliah</h3>
            <p class="text-2xl font-bold">79</p>
        </div>
    </section>
@endsection
