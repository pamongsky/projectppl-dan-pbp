<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaftarRuangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daftar_ruang', function (Blueprint $table) {
            $table->id(); // Primary key 'id'
            $table->unsignedBigInteger('idProdi'); // ID Program Studi (relasi ke 'program_studi')
            $table->string('kodeRuang'); // Kode Ruang (relasi ke 'ruangan')
            $table->integer('jumlahRuangan')->default(1); // Jumlah ruangan yang terdaftar

            // Timestamps untuk created_at dan updated_at
            $table->timestamps();

            // Menambahkan foreign key untuk 'idProdi' yang merujuk ke tabel 'program_studi'
            $table->foreign('idProdi')->references('id')->on('program_studi')->onDelete('cascade');
            
            // Menambahkan foreign key untuk 'kodeRuang' yang merujuk ke tabel 'ruangan'
            $table->foreign('kodeRuang')->references('kodeRuang')->on('ruangan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daftar_ruang');
    }
}
