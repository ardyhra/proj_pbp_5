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
            ["status" => "Belum IRS", "nim" => "24060121120002", "id_jadwal" => "202012007101"],
            ["status" => "Sudah IRS", "nim" => "24060120120001", "id_jadwal" => "202012007102"],
        ]);
    }
}
