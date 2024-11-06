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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('mahasiswa')->default(false);
            $table->boolean('pembimbing_akademik')->default(false);
            $table->boolean('ketua_program_studi')->default(false);
            $table->boolean('dekan')->default(false);
            $table->boolean('bagian_akademik')->default(false);
            $table->timestamps();
        });
        
        

        // Migration for account_role pivot table
        Schema::create('account_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
