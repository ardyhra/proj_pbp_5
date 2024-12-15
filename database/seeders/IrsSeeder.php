<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('irs')->insert([
            // Elisa
            ['status' => 'BARU', 'nilai' => 39, 'nim' => '24060123140061', 'id_jadwal' => '202312007105', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 72, 'nim' => '24060123140061', 'id_jadwal' => '202312007111', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 82, 'nim' => '24060123140061', 'id_jadwal' => '202312007127', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 86, 'nim' => '24060123140061', 'id_jadwal' => '202312007204', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 77, 'nim' => '24060123140061', 'id_jadwal' => '202312007211', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 88, 'nim' => '24060123140061', 'id_jadwal' => '202312007305', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 90, 'nim' => '24060123140061', 'id_jadwal' => '202312007314', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 71, 'nim' => '24060123140061', 'id_jadwal' => '202312007325', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 73, 'nim' => '24060123140061', 'id_jadwal' => '202322007101', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 79, 'nim' => '24060123140061', 'id_jadwal' => '202322007108', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 85, 'nim' => '24060123140061', 'id_jadwal' => '202322007113', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 89, 'nim' => '24060123140061', 'id_jadwal' => '202322007116', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 91, 'nim' => '24060123140061', 'id_jadwal' => '202322007207', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 72, 'nim' => '24060123140061', 'id_jadwal' => '202322007212', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 76, 'nim' => '24060123140061', 'id_jadwal' => '202322007313', 'tanggal_disetujui' => null],
            
            // Fitri
            ['status' => 'BARU', 'nilai' => 73, 'nim' => '24060122130051', 'id_jadwal' => '202212007104', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 80, 'nim' => '24060122130051', 'id_jadwal' => '202212007111', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 82, 'nim' => '24060122130051', 'id_jadwal' => '202212007127', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 81, 'nim' => '24060122130051', 'id_jadwal' => '202212007204', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 79, 'nim' => '24060122130051', 'id_jadwal' => '202212007211', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 78, 'nim' => '24060122130051', 'id_jadwal' => '202212007305', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 85, 'nim' => '24060122130051', 'id_jadwal' => '202212007314', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 87, 'nim' => '24060122130051', 'id_jadwal' => '202212007325', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 91, 'nim' => '24060122130051', 'id_jadwal' => '202222007101', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 93, 'nim' => '24060122130051', 'id_jadwal' => '202222007108', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 90, 'nim' => '24060122130051', 'id_jadwal' => '202222007113', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 88, 'nim' => '24060122130051', 'id_jadwal' => '202222007116', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 81, 'nim' => '24060122130051', 'id_jadwal' => '202222007207', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 74, 'nim' => '24060122130051', 'id_jadwal' => '202222007212', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 73, 'nim' => '24060122130051', 'id_jadwal' => '202222007313', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 70, 'nim' => '24060122130051', 'id_jadwal' => '202312007101', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 69, 'nim' => '24060122130051', 'id_jadwal' => '202312007109', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 68, 'nim' => '24060122130051', 'id_jadwal' => '202312007114', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 71, 'nim' => '24060122130051', 'id_jadwal' => '202312007205', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 83, 'nim' => '24060122130051', 'id_jadwal' => '202312007210', 'tanggal_disetujui' => null],
            ['status' => 'BARU', 'nilai' => 85, 'nim' => '24060122130051', 'id_jadwal' => '202312007217', 'tanggal_disetujui' => null],
            // test

            // Fitri
            // ['status' => 'BARU', 'nilai' => 85, 'nim' => '24060122130051', 'id_jadwal' => '202412007101', 'tanggal_disetujui' => null],
            // ['status' => 'BARU', 'nilai' => 85, 'nim' => '24060122130051', 'id_jadwal' => '202412007102', 'tanggal_disetujui' => null],
            // ['status' => 'BARU', 'nilai' => 85, 'nim' => '24060122130051', 'id_jadwal' => '202412007103', 'tanggal_disetujui' => null],
            // ['status' => 'BARU', 'nilai' => 85, 'nim' => '24060122130051', 'id_jadwal' => '202412007104', 'tanggal_disetujui' => null],
            // ['status' => 'BARU', 'nilai' => 85, 'nim' => '24060122130051', 'id_jadwal' => '202412007105', 'tanggal_disetujui' => null],
            // ['status' => 'BARU', 'nilai' => 85, 'nim' => '24060122130051', 'id_jadwal' => '202412007106', 'tanggal_disetujui' => null],
            
            // Elisa
            // ['status' => 'BARU', 'nilai' => 91, 'nim' => '24060123140061', 'id_jadwal' => '202412007110', 'tanggal_disetujui' => null],
            // ['status' => 'BARU', 'nilai' => 72, 'nim' => '24060123140061', 'id_jadwal' => '202412007111', 'tanggal_disetujui' => null],
            // ['status' => 'BARU', 'nilai' => 76, 'nim' => '24060123140061', 'id_jadwal' => '202412007112', 'tanggal_disetujui' => null],
            // ['status' => 'BARU', 'nilai' => 91, 'nim' => '24060123140061', 'id_jadwal' => '202412007113', 'tanggal_disetujui' => null],
            // ['status' => 'BARU', 'nilai' => 72, 'nim' => '24060123140061', 'id_jadwal' => '202412007114', 'tanggal_disetujui' => null],
            // ['status' => 'BARU', 'nilai' => 76, 'nim' => '24060123140061', 'id_jadwal' => '202412007115', 'tanggal_disetujui' => null],
            

        ]);
        
        
    }
}
