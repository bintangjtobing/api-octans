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
        Schema::create('suppliers_or_customers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bisnis');
            $table->string('alamat');
            $table->string('email');
            $table->string('no_hp');
            $table->foreignId('jenis_transaksi_id');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers_or_customers');
    }
};
