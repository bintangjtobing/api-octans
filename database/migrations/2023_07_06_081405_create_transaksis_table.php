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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->date('tanggal');
            $table->string('no_transaksi');
            $table->integer('jumlah');
            $table->text('deskripsi')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('kategori_transaksi_id');
            $table->foreignId('suppliers_or_customers_id')->nullable();
            $table->boolean('anggaran');
            $table->foreignId('jenis_transaksi_id');
            // $table->boolean('void')->default(false)->after('jenis_transaksi_id')->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
