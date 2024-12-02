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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nim',14)->primary();
            $table->string('nama', 100);
            $table->integer('semester');
            $table->integer('angkatan');
            $table->string('status', 9);
            $table->unsignedBigInteger('id_prodi');
            $table->string('nidn',10);

            $table->timestamps();

            $table->foreign('id_prodi')->references('id_prodi')->on('prodi')->onDelete('cascade');
            $table->foreign('nidn')->references('nidn')->on('dosen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
