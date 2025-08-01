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
    Schema::create('contatos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('empresa_id')->constrained()->onDelete('cascade');
        $table->string('nome');
        $table->string('cargo')->nullable();
        $table->string('telefone')->nullable();
        $table->timestamps();
    });
}

};
