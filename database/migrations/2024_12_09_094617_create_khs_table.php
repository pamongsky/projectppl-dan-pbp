<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('khs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idIRS')->constrained('irs')->onDelete('cascade');
            $table->string('nim', 20);
            $table->string('kode_mata_kuliah', 20);
            $table->enum('NilaiMataKuliah', ['A', 'B', 'C', 'D', 'E']);
            $table->integer('semester');
            $table->integer('SKS');
            $table->foreignId('idThnAjaran')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->foreign('kode_mata_kuliah')->references('kode_mata_kuliah')->on('mata_kuliah')->onDelete('cascade');
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->timestamps();

            // Tambahkan unique constraint untuk mencegah duplikasi data
            $table->unique(['nim', 'kode_mata_kuliah', 'idThnAjaran']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('khs');
    }
};
