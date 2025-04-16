<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUserRelationsTable extends Migration
{
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->string('user_id', 20); // NIM atau NIP
            $table->unsignedBigInteger('role_id'); // Role ID (1, 2, dst.)
            $table->primary(['user_id', 'role_id']); // Composite primary key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_user');
    }
}
