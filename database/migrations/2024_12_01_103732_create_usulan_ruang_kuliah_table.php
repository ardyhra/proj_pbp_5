<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('usulan_ruang_kuliah', function (Blueprint $table) {
            $table->id();
            $table->integer('id_prodi');
            $table->string('id_ruang', 4);
            $table->char('id_tahun', 5);
            $table->enum('status', ['belum diajukan', 'diajukan', 'disetujui', 'ditolak'])->default('belum diajukan');
            $table->timestamps();

            // Tambahkan foreign key constraints jika perlu
            $table->foreign('id_prodi')->references('id_prodi')->on('programstudi')->onDelete('cascade');
            $table->foreign('id_ruang')->references('id_ruang')->on('ruang')->onDelete('cascade');
            $table->foreign('id_tahun')->references('id_tahun')->on('tahunajaran')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usulan_ruang_kuliah');
    }
};
