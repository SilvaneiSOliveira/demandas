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
     Schema::create('relatorios', function (Blueprint $table) {
        $table->id(); // int(11) com auto_increment
        $table->unsignedBigInteger('demanda_id');
        $table->longText('conteudo');
        $table->timestamp('criado_em')->useCurrent();
        $table->timestamp('atualizado_em')->useCurrent()->useCurrentOnUpdate();

        $table->foreign('demanda_id')->references('id')->on('demandas')->onDelete('cascade');
    
    });
}

};
