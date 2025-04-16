<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rekap_khs', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 20);
            $table->foreignId('idThnAjaran')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->integer('semester');
            $table->decimal('ips', 3, 2)->nullable();
            $table->integer('totalSKS')->default(0);
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekap_khs');
    }
};
