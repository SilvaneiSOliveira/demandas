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
    Schema::create('clientes', function (Blueprint $table) {
        $table->id();
        $table->string('nome_cliente');
        $table->string('razao_social')->nullable();
        $table->string('cnpj')->nullable();
        $table->string('endereco')->nullable();
        $table->string('bairro')->nullable();
        $table->string('cidade')->nullable();
        $table->string('estado', 2)->nullable();
        $table->string('produto')->nullable();
        $table->string('contato_nome')->nullable();
        $table->string('contato_cargo')->nullable();
        $table->string('contato_telefone')->nullable();
        $table->timestamps();
    });
}

};
