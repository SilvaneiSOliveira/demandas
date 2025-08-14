<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contatos_filial', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('filial_id');
        $table->string('nome');
        $table->string('telefone')->nullable();
        $table->string('email')->nullable();
        $table->timestamps();

        $table->foreign('filial_id')
              ->references('id')
              ->on('filiais')
              ->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('contatos_filial');
}
};
