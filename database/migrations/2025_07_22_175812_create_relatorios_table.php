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
        $table->id(); // int(11)
        $table->unsignedBigInteger('demanda_id'); // FK
        $table->longText('conteudo'); // longtext
        $table->timestamp('criado_em')->useCurrent(); // timestamp
        $table->timestamp('atualizado_em')->useCurrent()->useCurrentOnUpdate(); // timestamp

        $table->foreign('demanda_id')->references('id')->on('demandas')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relatorios');
    }
};
