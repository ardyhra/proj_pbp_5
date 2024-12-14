<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsulanjadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usulanjadwal', function (Blueprint $table) {
            $table->id(); // Kolom ID
            $table->string('id_tahun',5);
            $table->unsignedBigInteger('id_prodi');
            $table->enum('status', ['Belum Diajukan', 'Diajukan', 'Disetujui', 'Ditolak'])->default('Belum Diajukan');

            $table->timestamps(); // Kolom created_at dan updated_at
            $table->foreign('id_tahun')->references('id_tahun')->on('tahun_ajaran')->onDelete('cascade');
            $table->foreign('id_prodi')->references('id_prodi')->on('prodi')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usulanjadwal');
    }
}

