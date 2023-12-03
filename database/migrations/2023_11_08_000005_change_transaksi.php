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
        Schema::table('feedback_centers', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id');
            $table->string('no_feedback');
            $table->string('kategori');
            $table->string('deskripsi');
            $table->string('info_tambahan')->nullable();
            $table->string('progres')->default('draft');
            $table->foreignId('progres_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_centers');
    }
};
