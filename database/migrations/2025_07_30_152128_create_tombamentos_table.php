<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
            Schema::create('tombamentos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cliente_id')->constrained('clientes_tombamentos')->onDelete('cascade');
        $table->longText('dados'); // Aqui você pode salvar em HTML, JSON ou o que preferir
        $table->timestamp('atualizado_em')->useCurrent()->useCurrentOnUpdate();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tombamentos');
    }
};
