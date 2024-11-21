<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramStudiSeeder extends Seeder
{
    public function run()
    {
        DB::table('prodi')->insert([
            ['id_prodi' => 1001, 'nama_prodi' => 'Ilmu Hukum', 'strata' => 'S1', 'id_fakultas' => 10],
            ['id_prodi' => 1002, 'nama_prodi' => 'Hukum', 'strata' => 'S2', 'id_fakultas' => 10],
            ['id_prodi' => 1003, 'nama_prodi' => 'Kenotariatan', 'strata' => 'S2', 'id_fakultas' => 10],
            ['id_prodi' => 2007, 'nama_prodi' => 'Informatika', 'strata' => 'S1', 'id_fakultas' => 20],
            # ... Add all remaining records
        ]);
    }
}
