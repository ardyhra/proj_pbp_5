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
                // akun FITRI ANGGRAINI
                'email' => 'mahasiswa@example.com',
                'password' => Hash::make('password123'),
                'mahasiswa' => true,
                'pembimbing_akademik' => false,
                'ketua_program_studi' => false,
                'dekan' => false,
                'bagian_akademik' => false,
                'related_id' => '24060122130051',
            ],
            [
                // akun pak Guruh
                'email' => 'pembimbing@example.com',
                'password' => Hash::make('password123'),
                'mahasiswa' => false,
                'pembimbing_akademik' => true,
                'ketua_program_studi' => false,
                'dekan' => false,
                'bagian_akademik' => false,
                'related_id' => '0627128001',
            ],
            [
                // akun bu Retno
                'email' => 'pembimbing2@example.com',
                'password' => Hash::make('password123'),
                'mahasiswa' => false,
                'pembimbing_akademik' => true,
                'ketua_program_studi' => false,
                'dekan' => false,
                'bagian_akademik' => false,
                'related_id' => '0020048104',
            ],
            [
                // akun pak Aris
                'email' => 'kaprodi@example.com',
                'password' => Hash::make('password123'),
                'mahasiswa' => false,
                'pembimbing_akademik' => false,
                'ketua_program_studi' => true,
                'dekan' => false,
                'bagian_akademik' => false,
                'related_id' => '0011087104',
            ],
            [
                // akun pak Kusworo Adi
                'email' => 'dekan@example.com',
                'password' => Hash::make('password123'),
                'mahasiswa' => false,
                'pembimbing_akademik' => false,
                'ketua_program_studi' => false,
                'dekan' => true,
                'bagian_akademik' => false,
                'related_id' => '0017037201',
                
            ],
            [
                // akun pak bowo (nanti bisa diganti karena di db gaada nama ba)
                'email' => 'akademik@example.com',
                'password' => Hash::make('password123'),
                'mahasiswa' => false,
                'pembimbing_akademik' => false,
                'ketua_program_studi' => false,
                'dekan' => false,
                'bagian_akademik' => true,
                'related_id' => '0',
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
                'related_id' => '0011087104',
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
                'related_id' => '0017037201',
            ],
        ]);
    }
}
