<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAjaranSeeder extends Seeder
{
    public function run()
    {
        DB::table('tahun_ajaran')->insert([
            ['id_tahun' => '20201', 'tahun_ajaran' => 'Semester Ganjil 2020/2021'],
            ['id_tahun' => '20202', 'tahun_ajaran' => 'Semester Genap 2020/2021'],
            ['id_tahun' => '20211', 'tahun_ajaran' => 'Semester Ganjil 2021/2022'],
            ['id_tahun' => '20212', 'tahun_ajaran' => 'Semester Genap 2021/2022'],
            ['id_tahun' => '20221', 'tahun_ajaran' => 'Semester Ganjil 2022/2023'],
            ['id_tahun' => '20222', 'tahun_ajaran' => 'Semester Genap 2022/2023'],
            ['id_tahun' => '20231', 'tahun_ajaran' => 'Semester Ganjil 2023/2024'],
            ['id_tahun' => '20232', 'tahun_ajaran' => 'Semester Genap 2023/2024'],
            ['id_tahun' => '20241', 'tahun_ajaran' => 'Semester Ganjil 2024/2025'],
            ['id_tahun' => '20242', 'tahun_ajaran' => 'Semester Genap 2024/2025'],
        ]);
    }
}
