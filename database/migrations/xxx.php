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
        Schema::table('jadwal', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tahun')->after('id');
            $table->foreign('id_tahun')->references('id_tahun')->on('tahunajaran')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropForeign(['id_tahun']);
            $table->dropColumn('id_tahun');
        });
    }

};
