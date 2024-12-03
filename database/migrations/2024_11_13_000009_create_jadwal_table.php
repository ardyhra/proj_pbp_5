<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->string('id_jadwal',12)->primary();
            $table->string('kelas',1);
            $table->string('hari',1);
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->integer('kuota')->default(50);
            $table->string('kode_mk',10);
            $table->string('id_ruang',4);
            $table->string('id_tahun',5);
            $table->unsignedBigInteger('id_prodi');


            $table->timestamps();

            $table->foreign('kode_mk')->references('kode_mk')->on('matakuliah')->onDelete('cascade');
            $table->foreign('id_ruang')->references('id_ruang')->on('ruang')->onDelete('cascade');
            $table->foreign('id_tahun')->references('id_tahun')->on('tahun_ajaran')->onDelete('cascade');
            $table->foreign('id_prodi')->references('id_prodi')->on('prodi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};






