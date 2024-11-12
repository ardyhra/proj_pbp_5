<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    public function run()
    {
        DB::table('accounts')->insert([
            [
                'email' => 'mahasiswa@example.com',
                'password' => Hash::make('password123'),
                'mahasiswa' => true,
                'pembimbing_akademik' => false,
                'ketua_program_studi' => false,
                'dekan' => false,
                'bagian_akademik' => false,
            ],
            [
                'email' => 'pembimbing@example.com',
                'password' => Hash::make('password123'),
                'mahasiswa' => false,
                'pembimbing_akademik' => true,
                'ketua_program_studi' => false,
                'dekan' => false,
                'bagian_akademik' => false,
            ],
            [
                'email' => 'kaprodi@example.com',
                'password' => Hash::make('password123'),
                'mahasiswa' => false,
                'pembimbing_akademik' => false,
                'ketua_program_studi' => true,
                'dekan' => false,
                'bagian_akademik' => false,
            ],
            [
                'email' => 'dekan@example.com',
                'password' => Hash::make('password123'),
                'mahasiswa' => false,
                'pembimbing_akademik' => false,
                'ketua_program_studi' => false,
                'dekan' => true,
                'bagian_akademik' => false,
            ],
            [
                'email' => 'akademik@example.com',
                'password' => Hash::make('password123'),
                'mahasiswa' => false,
                'pembimbing_akademik' => false,
                'ketua_program_studi' => false,
                'dekan' => false,
                'bagian_akademik' => true,
            ],
            // Akun dengan Peran Ganda
            // Dosen sekaligus Kaprodi
            [
                'email' => 'dosen_kaprodi@example.com',
                'password' => Hash::make('password123'),
                'mahasiswa' => false,
                'pembimbing_akademik' => true,
                'ketua_program_studi' => true,
                'dekan' => false,
                'bagian_akademik' => false,
            ],
            // Dosen sekaligus Dekan
            [
                'email' => 'dosen_dekan@example.com',
                'password' => Hash::make('password123'),
                'mahasiswa' => false,
                'pembimbing_akademik' => true,
                'ketua_program_studi' => false,
                'dekan' => true,
                'bagian_akademik' => false,
            ],
        ]);
    }
}
