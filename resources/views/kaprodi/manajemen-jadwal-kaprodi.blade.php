@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">Manajemen Jadwal</h1>
    <div class="flex space-x-4 my-4">
        <button class="px-4 py-2 bg-blue-500 text-white rounded">2023/2024 Ganjil</button>
        <button class="px-4 py-2 bg-gray-300 rounded">2023/2024 Genap</button>
    </div>

    <div class="border rounded-lg p-4">
        @foreach([1, 3, 5, 7] as $semester)
            <div class="flex items-center justify-between border-b py-2">
                <span>Semester {{ $semester }}</span>
                <div class="space-x-2">
                    <a href="#" class="text-blue-600">Lihat</a>
                    <a href="#" class="text-red-600">Edit</a>
                    <a href="#" class="text-blue-600">Apply</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection