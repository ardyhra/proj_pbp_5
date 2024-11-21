<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        DB::table('mahasiswa')->insert([
            ['nim' => '24060120120001', 'nama' => 'ANDI PUTRA', 'semester' => 9, 'angkatan' => 2020, 'id_prodi' => 2007, 'nidn' => '0627128001'],
            ['nim' => '24060120130052', 'nama' => 'BUDI SANTOSO', 'semester' => 9, 'angkatan' => 2020, 'id_prodi' => 2007, 'nidn' => '0020048104'],
            ['nim' => '24060121120002', 'nama' => 'CICI AMALIA', 'semester' => 7, 'angkatan' => 2021, 'id_prodi' => 2007, 'nidn' => '0627128001'],
            # ... Add all remaining records
        ]);
    }
}
