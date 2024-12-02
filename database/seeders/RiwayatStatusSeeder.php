<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatStatusSeeder extends Seeder
{
    public function run()
    {
        DB::table('riwayat_status')->insert([
            ['status' => 'AKTIF', 'nim' => '24060124120001', 'id_tahun' => '20241'],
            ['status' => 'AKTIF', 'nim' => '24060123140061', 'id_tahun' => '20231'],
            ['status' => 'AKTIF', 'nim' => '24060123140061', 'id_tahun' => '20232'],
            ['status' => 'AKTIF', 'nim' => '24060123140061', 'id_tahun' => '20241'],
            ['status' => 'AKTIF', 'nim' => '24060122130051', 'id_tahun' => '20221'],
            ['status' => 'AKTIF', 'nim' => '24060122130051', 'id_tahun' => '20222'],
            ['status' => 'AKTIF', 'nim' => '24060122130051', 'id_tahun' => '20231'],
            ['status' => 'CUTI', 'nim' => '24060122130051', 'id_tahun' => '20232'],
            ['status' => 'AKTIF', 'nim' => '24060122130051', 'id_tahun' => '20241'],
        ]);
    }
}
