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
            // ["status" => "Belum IRS", "nim" => "24060121120002", "id_jadwal" => "202012007101"],
            // ["status" => "Sudah IRS", "nim" => "24060120120001", "id_jadwal" => "202012007102"],
            // Mahasiswa B (Semester 3)
            ['status' => 'BARU', 'nilai' => 39, 'nim' => '24060123140061', 'id_jadwal' => '202312007105'],
            ['status' => 'BARU', 'nilai' => 72, 'nim' => '24060123140061', 'id_jadwal' => '202312007111'],
            ['status' => 'BARU', 'nilai' => 82, 'nim' => '24060123140061', 'id_jadwal' => '202312007127'],
            ['status' => 'BARU', 'nilai' => 86, 'nim' => '24060123140061', 'id_jadwal' => '202312007203'],
            ['status' => 'BARU', 'nilai' => 77, 'nim' => '24060123140061', 'id_jadwal' => '202312007211'],
            ['status' => 'BARU', 'nilai' => 88, 'nim' => '24060123140061', 'id_jadwal' => '202312007305'],
            ['status' => 'BARU', 'nilai' => 90, 'nim' => '24060123140061', 'id_jadwal' => '202312007314'],
            ['status' => 'BARU', 'nilai' => 71, 'nim' => '24060123140061', 'id_jadwal' => '202312007325'],
            ['status' => 'BARU', 'nilai' => 73, 'nim' => '24060123140061', 'id_jadwal' => '202322007101'],
            ['status' => 'BARU', 'nilai' => 79, 'nim' => '24060123140061', 'id_jadwal' => '202322007108'],
            ['status' => 'BARU', 'nilai' => 85, 'nim' => '24060123140061', 'id_jadwal' => '202322007113'],
            ['status' => 'BARU', 'nilai' => 89, 'nim' => '24060123140061', 'id_jadwal' => '202322007116'],
            ['status' => 'BARU', 'nilai' => 91, 'nim' => '24060123140061', 'id_jadwal' => '202322007207'],
            ['status' => 'BARU', 'nilai' => 72, 'nim' => '24060123140061', 'id_jadwal' => '202322007212'],
            ['status' => 'BARU', 'nilai' => 76, 'nim' => '24060123140061', 'id_jadwal' => '202322007313'],


            // Mahasiswa C (Semester 4)
            ['status' => 'BARU', 'nilai' => 73, 'nim' => '24060122130051', 'id_jadwal' => '202212007104'],
            ['status' => 'BARU', 'nilai' => 80, 'nim' => '24060122130051', 'id_jadwal' => '202212007111'],
            ['status' => 'BARU', 'nilai' => 82, 'nim' => '24060122130051', 'id_jadwal' => '202212007127'],
            ['status' => 'BARU', 'nilai' => 81, 'nim' => '24060122130051', 'id_jadwal' => '202212007203'],
            ['status' => 'BARU', 'nilai' => 79, 'nim' => '24060122130051', 'id_jadwal' => '202212007211'],
            ['status' => 'BARU', 'nilai' => 78, 'nim' => '24060122130051', 'id_jadwal' => '202212007305'],
            ['status' => 'BARU', 'nilai' => 85, 'nim' => '24060122130051', 'id_jadwal' => '202212007314'],
            ['status' => 'BARU', 'nilai' => 87, 'nim' => '24060122130051', 'id_jadwal' => '202212007325'],
            ['status' => 'BARU', 'nilai' => 91, 'nim' => '24060122130051', 'id_jadwal' => '202222007101'],
            ['status' => 'BARU', 'nilai' => 93, 'nim' => '24060122130051', 'id_jadwal' => '202222007108'],
            ['status' => 'BARU', 'nilai' => 90, 'nim' => '24060122130051', 'id_jadwal' => '202222007113'],
            ['status' => 'BARU', 'nilai' => 88, 'nim' => '24060122130051', 'id_jadwal' => '202222007116'],
            ['status' => 'BARU', 'nilai' => 81, 'nim' => '24060122130051', 'id_jadwal' => '202222007207'],
            ['status' => 'BARU', 'nilai' => 74, 'nim' => '24060122130051', 'id_jadwal' => '202222007212'],
            ['status' => 'BARU', 'nilai' => 73, 'nim' => '24060122130051', 'id_jadwal' => '202222007313'],
            ['status' => 'BARU', 'nilai' => 70, 'nim' => '24060122130051', 'id_jadwal' => '202312007101'],
            ['status' => 'BARU', 'nilai' => 69, 'nim' => '24060122130051', 'id_jadwal' => '202312007109'],
            ['status' => 'BARU', 'nilai' => 68, 'nim' => '24060122130051', 'id_jadwal' => '202312007114'],
            ['status' => 'BARU', 'nilai' => 71, 'nim' => '24060122130051', 'id_jadwal' => '202312007205'],
            ['status' => 'BARU', 'nilai' => 83, 'nim' => '24060122130051', 'id_jadwal' => '202312007210'],
            ['status' => 'BARU', 'nilai' => 85, 'nim' => '24060122130051', 'id_jadwal' => '202312007217'],

        ]);
    }
}
