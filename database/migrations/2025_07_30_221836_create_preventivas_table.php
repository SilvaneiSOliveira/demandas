<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
{
    Schema::create('preventivas', function (Blueprint $table) {
        $table->id();
        $table->string('cliente');
        $table->string('filial');
        $table->string('status')->nullable();
        $table->date('data')->nullable();
        $table->text('observacoes')->nullable();
        $table->string('usuario_alteracao')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preventivas');
    }
};
