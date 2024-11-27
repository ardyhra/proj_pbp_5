<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  

    public function up(){
        Schema::create('monitoring', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pembimbing');
            $table->string('total_mahasiswa');
            $table->string('persentase');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring');
    }
};
