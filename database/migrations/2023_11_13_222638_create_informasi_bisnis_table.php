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
        Schema::create('informasi_bisnis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bisnis');
            $table->string('alamat');
            $table->string('no_tax')->nullable();
            $table->string('website')->nullable();
            $table->string('email');
            $table->string('no_handphone');
            $table->string('logo')->nullable();
            $table->string('jabatan');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_bisnis');
    }
};
