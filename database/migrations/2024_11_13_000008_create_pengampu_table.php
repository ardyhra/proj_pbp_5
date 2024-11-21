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
        Schema::create('pengampu', function (Blueprint $table) {
            $table->string('nidn',10);
            $table->string('kode_mk',10);

            $table->foreign('nidn')->references('nidn')->on('dosen')->onDelete('cascade');
            $table->foreign('kode_mk')->references('kode_mk')->on('matakuliah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengampu');
    }
};
