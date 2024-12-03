<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->string('semester');   // Kolom untuk semester (ganjil/genap)
            $table->string('section');    // Kolom untuk section (semester1, semester2, dll)
        });
    }
    
    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropColumn('semester');
            $table->dropColumn('section');
        });
    }
    // /**
    //  * Run the migrations.
    //  */
    // public function up(): void
    // {
    //     Schema::table('jadwal', function (Blueprint $table) {
    //         //
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::table('jadwal', function (Blueprint $table) {
    //         //
    //     });
    // }
};
