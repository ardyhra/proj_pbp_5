<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fakultas')->insert([
            ['id_fakultas' => 10, 'nama_fakultas' => 'Fakultas Hukum'],
            ['id_fakultas' => 11, 'nama_fakultas' => 'Fakultas Ekonomika dan Bisnis'],
            ['id_fakultas' => 12, 'nama_fakultas' => 'Fakultas Peternakan dan Pertanian'],
            ['id_fakultas' => 13, 'nama_fakultas' => 'Fakultas Psikologi'],
            ['id_fakultas' => 14, 'nama_fakultas' => 'Fakultas Ilmu Budaya'],
            ['id_fakultas' => 15, 'nama_fakultas' => 'Fakultas Perikanan dan Ilmu Kelautan'],
            ['id_fakultas' => 16, 'nama_fakultas' => 'Fakultas Teknik'],
            ['id_fakultas' => 17, 'nama_fakultas' => 'Fakultas Ilmu Sosial dan Ilmu Politik'],
            ['id_fakultas' => 18, 'nama_fakultas' => 'Fakultas Kedokteran'],
            ['id_fakultas' => 19, 'nama_fakultas' => 'Fakultas Kesehatan Masyarakat'],
            ['id_fakultas' => 20, 'nama_fakultas' => 'Fakultas Sains dan Matematika'],
            ['id_fakultas' => 21, 'nama_fakultas' => 'Sekolah Vokasi'],
            ['id_fakultas' => 22, 'nama_fakultas' => 'Sekolah Pasca Sarjana'],
        ]);
    }
}
