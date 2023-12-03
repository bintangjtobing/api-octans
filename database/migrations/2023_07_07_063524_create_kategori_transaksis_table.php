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
        Schema::create('kategori_transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('jenis_transaksi_id');
            $table->foreignId('user_id');
            $table->boolean('show')->default(true);
            $table->boolean('default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_transaksis');
    }
};
