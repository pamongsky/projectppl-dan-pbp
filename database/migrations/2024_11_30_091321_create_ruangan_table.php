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
        Schema::create('ruangan', function (Blueprint $table) {
            $table->string('kodeRuang', 20)->primary();
            $table->string('namaRuang', 255);
            $table->integer('kapasitas');
            $table->foreignId('idProdi')->constrained('program_studi')->onDelete('cascade');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};
