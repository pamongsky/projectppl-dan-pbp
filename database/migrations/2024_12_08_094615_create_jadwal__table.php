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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('idThnAjaran'); // Foreign key to tahun_ajaran
            $table->string('kode_mata_kuliah', 20); // Foreign key to mata_kuliah
            $table->string('hari', 10);
            $table->time('waktuMulai');
            $table->time('waktuSelesai');
            $table->string('kelas', 1);
            $table->string('kodeRuang', 20); // Foreign key to ruangan
            $table->boolean('status')->default(false);
            $table->integer('kuota')->default(0);
            $table->integer('kapasitas');
            $table->timestamps();
            $table->unsignedBigInteger('idProdi')->nullable(); // Foreign key to program_studi

            // Indexes
            $table->index('idThnAjaran', 'jadwal_idThnAjaran_foreign');
            $table->index('kode_mata_kuliah', 'jadwal_kode_mata_kuliah_foreign');
            $table->index('kodeRuang', 'jadwal_kodeRuang_foreign');
            $table->index('idProdi', 'fk_idProdi');

            // Foreign key constraints
            $table->foreign('idThnAjaran')
                ->references('id')
                ->on('tahun_ajaran')
                ->onDelete('cascade');

            $table->foreign('kode_mata_kuliah')
                ->references('kode_mata_kuliah')
                ->on('mata_kuliah')
                ->onDelete('cascade');

            $table->foreign('kodeRuang')
                ->references('kodeRuang')
                ->on('ruangan')
                ->onDelete('cascade');

            $table->foreign('idProdi')
                ->references('id')
                ->on('program_studi')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
