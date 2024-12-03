<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id('id_jadwal')->primary();
            $table->string('kelas');
            $table->string('hari');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('kode_mk');
            $table->unsignedBigInteger('id_ruang');
            $table->unsignedBigInteger('id_tahun');
            $table->unsignedBigInteger('id_prodi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwals');
    }
};
