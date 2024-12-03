<?php

// database/migrations/YYYY_MM_DD_add_kuota_to_jadwal_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKuotaToJadwalTable extends Migration
{
    public function up()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            // Menambahkan kolom kuota dengan nilai default 50
            $table->integer('kuota')->default(50)->after('id_prodi');
        });
    }

    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            // Menghapus kolom kuota jika migrasi dibatalkan
            $table->dropColumn('kuota');
        });
    }
}

