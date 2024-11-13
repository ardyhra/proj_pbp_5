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
        Schema::create('matakuliah', function (Blueprint $table) {
            $table->id();  // Kolom id otomatis
            $table->string('kodemk');  // Kolom untuk kode mata kuliah
            $table->string('namamk');  // Kolom untuk nama mata kuliah
            $table->string('plot_semester');  // Kolom untuk plot semester
            $table->integer('sks');  // Kolom untuk jumlah SKS
            $table->string('jenis');  // Kolom untuk jenis mata kuliah (misalnya: teori, praktek)
            $table->timestamps();  // Kolom timestamps (created_at, updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matakuliahs');
    }
};
