<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuangSeeder extends Seeder
{
    public function run()
    {
        DB::table('ruang')->insert([
            ['id_ruang' => 'A101', 'blok_gedung' => 'A', 'lantai' => 1, 'kapasitas' => 50],
            ['id_ruang' => 'A102', 'blok_gedung' => 'A', 'lantai' => 1, 'kapasitas' => 50],
            ['id_ruang' => 'A103', 'blok_gedung' => 'A', 'lantai' => 1, 'kapasitas' => 50],
            ['id_ruang' => 'A104', 'blok_gedung' => 'A', 'lantai' => 1, 'kapasitas' => 50],
            ['id_ruang' => 'A201', 'blok_gedung' => 'A', 'lantai' => 2, 'kapasitas' => 50],
            ['id_ruang' => 'A202', 'blok_gedung' => 'A', 'lantai' => 2, 'kapasitas' => 50],
            ['id_ruang' => 'A203', 'blok_gedung' => 'A', 'lantai' => 2, 'kapasitas' => 50],
            ['id_ruang' => 'A204', 'blok_gedung' => 'A', 'lantai' => 2, 'kapasitas' => 50],
            ['id_ruang' => 'A303', 'blok_gedung' => 'A', 'lantai' => 3, 'kapasitas' => 50],
            ['id_ruang' => 'A304', 'blok_gedung' => 'A', 'lantai' => 3, 'kapasitas' => 50],
            ['id_ruang' => 'B101', 'blok_gedung' => 'B', 'lantai' => 1, 'kapasitas' => 50],
            ['id_ruang' => 'B102', 'blok_gedung' => 'B', 'lantai' => 1, 'kapasitas' => 50],
            ['id_ruang' => 'B103', 'blok_gedung' => 'B', 'lantai' => 1, 'kapasitas' => 50],
            ['id_ruang' => 'B104', 'blok_gedung' => 'B', 'lantai' => 1, 'kapasitas' => 50],
            ['id_ruang' => 'B201', 'blok_gedung' => 'B', 'lantai' => 2, 'kapasitas' => 50],
            ['id_ruang' => 'B202', 'blok_gedung' => 'B', 'lantai' => 2, 'kapasitas' => 50],
            ['id_ruang' => 'B203', 'blok_gedung' => 'B', 'lantai' => 2, 'kapasitas' => 50],
            ['id_ruang' => 'B204', 'blok_gedung' => 'B', 'lantai' => 2, 'kapasitas' => 50],
            ['id_ruang' => 'E101', 'blok_gedung' => 'E', 'lantai' => 1, 'kapasitas' => 50],
            ['id_ruang' => 'E102', 'blok_gedung' => 'E', 'lantai' => 1, 'kapasitas' => 50],
            ['id_ruang' => 'E103', 'blok_gedung' => 'E', 'lantai' => 1, 'kapasitas' => 50],
            ['id_ruang' => 'K102', 'blok_gedung' => 'K', 'lantai' => 1, 'kapasitas' => 50],
            ['id_ruang' => 'K202', 'blok_gedung' => 'K', 'lantai' => 1, 'kapasitas' => 50],
        ]);
    }
}
