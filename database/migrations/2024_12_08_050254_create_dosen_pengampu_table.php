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
        Schema::create('dosen_pengampu', function (Blueprint $table) {
            $table->string('nip_dosen');
            $table->string('kode_mata_kuliah');
            $table->foreign('kode_mata_kuliah')->references('kode_mata_kuliah')->on('mata_kuliah')->onDelete('cascade');
            $table->foreign('nip_dosen')->references('nip')->on('dosen')->onDelete('cascade');
            $table->primary(['kode_mata_kuliah', 'nip_dosen']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_pengampu');
    }
};
