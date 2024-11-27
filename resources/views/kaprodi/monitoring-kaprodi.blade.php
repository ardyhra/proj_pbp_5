@extends('layouts.app')

@section('title', 'Monitoring Kaprodi')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4">Monitoring</h1>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Nama Pembimbing Akademik</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Jumlah Mahasiswa yang sudah mengisi IRS</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Persentase</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data rows -->
                @foreach($data as $index => $item)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : '' }}">
                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $index + 1 }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $item['nama_pembimbing'] }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $item['jumlah_isi'] }}/{{ $item['total_mahasiswa'] }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <span class="font-bold {{ $item['persentase'] == 100 ? 'text-green-500' : 'text-red-500' }}">
                            {{ $item['persentase'] }}%
                        </span>
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <!-- Lihat -->
                        <a href="{{ route('monitoring.view', $item['id']) }}" class="text-blue-500 hover:underline flex items-center justify-center">
                            <img src="https://cdn-icons-png.flaticon.com/512/709/709699.png" alt="Lihat" class="w-5 h-5 inline">
                            <span class="ml-1">Lihat</span>
                        </a>
                    
                        <!-- Edit -->
                        <a href="{{ route('monitoring.edit', $item['id']) }}" class="text-yellow-500 hover:underline flex items-center justify-center mx-2">
                            <img src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png" alt="Edit" class="w-5 h-5 inline">
                            <span class="ml-1">Edit</span>
                        </a>
                    
                        <!-- Hapus -->
                        <a href="{{ route('monitoring.delete', $item['id']) }}" class="text-red-500 hover:underline flex items-center justify-center">
                            <img src="https://cdn-icons-png.flaticon.com/512/6861/6861362.png" alt="Hapus" class="w-5 h-5 inline">
                            <span class="ml-1">Hapus</span>
                        </a>
                    </td>
                    
                    

                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4">
        <button class="px-4 py-2 bg-gray-300 rounded shadow">Prev</button>
        <span class="font-semibold">1</span>
        <button class="px-4 py-2 bg-blue-500 text-white rounded shadow">Next</button>
    </div>
</div>
@endsection
