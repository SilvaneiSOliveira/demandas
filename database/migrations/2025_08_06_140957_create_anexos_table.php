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
    Schema::create('anexos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('demanda_id');
        $table->string('nome_arquivo');
        $table->string('caminho');
        $table->timestamps();

        $table->foreign('demanda_id')->references('id')->on('demandas')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anexos');
    }
};
