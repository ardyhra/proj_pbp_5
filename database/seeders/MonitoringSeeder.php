<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonitoringSeeder extends Seeder
{
    public function run()
    {
        DB::table('monitoring')->insert([
            [
                'nama_pembimbing' => 'Udin Saripudin, S.Kom, M.Cs',
                'total_mahasiswa' => '20/40',
                'persentase' => '50%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pembimbing' => 'Dr. Eng. Adi Wibowo, S.Si, M.Kom.',
                'total_mahasiswa' => '40/40',
                'persentase' => '100%',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

