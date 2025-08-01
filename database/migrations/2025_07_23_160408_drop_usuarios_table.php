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
    Schema::dropIfExists('usuarios');
}

public function down()
{
    Schema::create('usuarios', function (Blueprint $table) {
        $table->id();
        // coloca os campos que tinha, caso precise recriar depois
        $table->timestamps();
    });
}
};
