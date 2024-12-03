<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        DB::table('mahasiswa')->insert([
            ['nim' => '24060120120001', 'nama' => 'ANDI PUTRA', 'semester' => 9, 'angkatan' => 2020, 'status' => 'AKTIF',  'id_prodi' => 2007, 'nidn' => '0627128001'],
            ['nim' => '24060120130052', 'nama' => 'BUDI SANTOSO', 'semester' => 9, 'angkatan' => 2020, 'status' => 'AKTIF',  'id_prodi' => 2007, 'nidn' => '0020048104'],
            ['nim' => '24060121120002', 'nama' => 'CICI AMALIA', 'semester' => 7, 'angkatan' => 2021, 'status' => 'AKTIF',  'id_prodi' => 2007, 'nidn' => '0627128001'],
            ['nim' => '24060124120001', 'nama' => 'DINA PERMATA', 'semester' => 1, 'angkatan' => 2024, 'status' => 'AKTIF',  'id_prodi' => 2007, 'nidn' => '0627128001'],
            ['nim' => '24060123140061', 'nama' => 'ELISA HANDAYANI', 'semester' => 3, 'angkatan' => 2023, 'status' => 'AKTIF',  'id_prodi' => 2007, 'nidn' => '0627128001'],
            ['nim' => '24060122130051', 'nama' => 'FITRI ANGGRAINI', 'semester' => 5, 'angkatan' => 2022, 'status' => 'AKTIF',  'id_prodi' => 2007, 'nidn' => '0627128001'],
        ]);
    }
}
