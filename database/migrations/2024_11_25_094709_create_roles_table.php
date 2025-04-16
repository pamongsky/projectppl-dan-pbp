<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // Auto-increment ID (1 untuk mahasiswa, 2 untuk pembimbing akademik, dst.)
            $table->string('name', 50)->unique(); // Nama role (Mahasiswa, Pembimbing Akademik, dll.)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
