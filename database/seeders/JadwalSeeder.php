<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        DB::table('jadwal')->insert([
            ['id_jadwal' => '202012007101', 'kelas' => 'B', 'hari' => '1', 'waktu_mulai' => '07:00:00', 'waktu_selesai' => '08:40:00', 'kode_mk' => 'PAIK6303', 'id_ruang' => 'K102', 'id_tahun' => '20201', 'id_prodi' => 2007],
            ['id_jadwal' => '202012007102', 'kelas' => 'A', 'hari' => '1', 'waktu_mulai' => '07:00:00', 'waktu_selesai' => '08:40:00', 'kode_mk' => 'PAIK6501', 'id_ruang' => 'E101', 'id_tahun' => '20201', 'id_prodi' => 2007],
            ['id_jadwal' => '202012007103', 'kelas' => 'A', 'hari' => '1', 'waktu_mulai_mulai' => '07:00:00', 'waktu_selesai' => '08:40:00', 'kode_mk' => 'PAIK6301', 'id_ruang' => 'E103', 'id_tahun' => '20201', 'id_prodi' => 2007],
            ['id_jadwal' => '202012007104', 'kelas' => 'C', 'hari' => '1', 'waktu_mulai' => '07:00:00', 'waktu_selesai' => '08:40:00', 'kode_mk' => 'PAIK6105', 'id_ruang' => 'E102', 'id_tahun' => '20201', 'id_prodi' => 2007],
            ['id_jadwal' => '202012007105', 'kelas' => 'B', 'hari' => '1', 'waktu_mulai' => '07:00:00', 'waktu_selesai' => '09:30:00', 'kode_mk' => 'PAIK6102', 'id_ruang' => 'K202', 'id_tahun' => '20201', 'id_prodi' => 2007],
            ['id_jadwal' => '202012007106', 'kelas' => 'C', 'hari' => '1', 'waktu_mulai' => '07:00:00', 'waktu_selesai' => '09:30:00', 'kode_mk' => 'PAIK6504', 'id_ruang' => 'A303', 'id_tahun' => '20201', 'id_prodi' => 2007],
            ['id_jadwal' => '202012007107', 'kelas' => 'C', 'hari' => '1', 'waktu_mulai' => '08:50:00', 'waktu_selesai' => '10:30:00', 'kode_mk' => 'PAIK6303', 'id_ruang' => 'K102', 'id_tahun' => '20201', 'id_prodi' => 2007],
            ['id_jadwal' => '202012007108', 'kelas' => 'B', 'hari' => '1', 'waktu_mulai' => '08:50:00', 'waktu_selesai' => '10:30:00', 'kode_mk' => 'PAIK6501', 'id_ruang' => 'E101', 'id_tahun' => '20201', 'id_prodi' => 2007],
            ['id_jadwal' => '202012007109', 'kelas' => 'B', 'hari' => '1', 'waktu_mulai' => '08:50:00', 'waktu_selesai' => '10:30:00', 'kode_mk' => 'PAIK6301', 'id_ruang' => 'E103', 'id_tahun' => '20201', 'id_prodi' => 2007],
            ['id_jadwal' => '202012007110', 'kelas' => 'D', 'hari' => '1', 'waktu_mulai' => '08:50:00', 'waktu_selesai' => '10:30:00', 'kode_mk' => 'PAIK6105', 'id_ruang' => 'E102', 'id_tahun' => '20201', 'id_prodi' => 2007],
            # ... Include all remaining rows similarly
        ]);
    }
}
