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
        Schema::create('irs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idJadwal')->constrained('jadwal')->onDelete('cascade');
            $table->string('nim', 20);
            $table->string('kode_mata_kuliah', 20);
            $table->foreignId('idThnAjaran')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->integer('semester');
            $table->primary(['id', 'nim', 'idThnAjaran']);
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('kode_mata_kuliah')->references('kode_mata_kuliah')->on('mata_kuliah')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('irs');
    }
};
