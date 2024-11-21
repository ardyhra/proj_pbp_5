<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengampuSeeder extends Seeder
{
    public function run()
    {
        DB::table('pengampu')->insert([
            ['nidn' => '0003039602', 'kode_mk' => 'PAIK6604'],
            ['nidn' => '0003028301', 'kode_mk' => 'UUW00009'],
            ['nidn' => '0020077902', 'kode_mk' => 'PAIK6821'],
            ['nidn' => '0016057801', 'kode_mk' => 'PAIK6802'],
            // ['nidn' => '0024057906', 'kode_mk' => 'PAIK6802'],
            // ['nidn' => '0014098003', 'kode_mk' => 'PAIK6801'],
            // ['nidn' => '0018056403', 'kode_mk' => 'PAIK6801'],
            // ['nidn' => '0020048104', 'kode_mk' => 'PAIK6701'],
            // ['nidn' => '0622038802', 'kode_mk' => 'PAIK6701'],
            // ['nidn' => '0025118503', 'kode_mk' => 'UUW00007'],
            // ['nidn' => '0007085506', 'kode_mk' => 'UUW00003'],
            // ['nidn' => '0123456789', 'kode_mk' => 'UUW00005'],
            // ['nidn' => '0001095808', 'kode_mk' => 'PAIK6101'],
            // ['nidn' => '0016057801', 'kode_mk' => 'PAIK6102'],
            // ['nidn' => '0009038204', 'kode_mk' => 'PAIK6102'],
            // ['nidn' => '0003038907', 'kode_mk' => 'PAIK6102'],
            // ['nidn' => '0025118503', 'kode_mk' => 'PAIK6103'],
            // ['nidn' => '0024057906', 'kode_mk' => 'PAIK6103'],
            // ['nidn' => '0020068108', 'kode_mk' => 'PAIK6103'],
            // ['nidn' => '0024057906', 'kode_mk' => 'PAIK6104'],
            // ['nidn' => '0011087104', 'kode_mk' => 'PAIK6104'],
            // ['nidn' => '0020077902', 'kode_mk' => 'PAIK6105'],
            // ['nidn' => '0011087104', 'kode_mk' => 'PAIK6105'],
            // ['nidn' => '0020127304', 'kode_mk' => 'PAIK6201'],
            // ['nidn' => '0001047404', 'kode_mk' => 'PAIK6202'],
            // ['nidn' => '0007116503', 'kode_mk' => 'PAIK6202'],
            // ['nidn' => '0025118503', 'kode_mk' => 'PAIK6203'],
            // ['nidn' => '0024057906', 'kode_mk' => 'PAIK6203'],
            // ['nidn' => '0020048104', 'kode_mk' => 'PAIK6204'],
            // ['nidn' => '0005077005', 'kode_mk' => 'PAIK6204'],
            // ['nidn' => '0012027907', 'kode_mk' => 'UUW00006'],
            // ['nidn' => '0005077005', 'kode_mk' => 'UUW00006'],
            // ['nidn' => '0014098003', 'kode_mk' => 'PAIK6301'],
            // ['nidn' => '0003039602', 'kode_mk' => 'PAIK6301'],
            // ['nidn' => '0627128001', 'kode_mk' => 'PAIK6302'],
            // ['nidn' => '0007116503', 'kode_mk' => 'PAIK6302'],
            // ['nidn' => '0029087303', 'kode_mk' => 'PAIK6303'],
            // ['nidn' => '0003028301', 'kode_mk' => 'PAIK6303'],
            # ... Include all remaining records similarly
        ]);
    }
}
