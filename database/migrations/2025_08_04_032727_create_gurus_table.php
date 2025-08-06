<?php

// database/migrations/xxxx_xx_xx_create_gurus_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->id('id_guru');
            $table->string('nip')->unique();
            $table->string('nama_guru');
            $table->unsignedBigInteger('id_user');
        });
    }

    public function down()
    {
        Schema::dropIfExists('guru');
    }
};
