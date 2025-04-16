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
        Schema::create('rekap_irs', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 20);
            $table->foreignId('idThnAjaran')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->integer('semester');
            $table->integer('totalSKS');
            $table->enum('status', ['disetujui', 'belum disetujui', 'tidak disetujui', 'pending'])->default('pending');
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_irs');
    }
};
