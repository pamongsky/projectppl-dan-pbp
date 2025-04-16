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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nim')->primary();
            $table->string('namaMahasiswa');
            $table->string('NIPWali')->nullable();
            $table->integer('tahunAngkatan');
            $table->integer('semester');
            $table->foreignId('idProdi')->constrained('program_studi')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('IPk', 3, 2)->nullable();
            $table->enum('status', ['aktif', 'cuti', 'belum_dipilih'])->default('belum_dipilih');
            $table->foreign('NIPWali')->references('nip')->on('dosen')->onDelete('set null')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
