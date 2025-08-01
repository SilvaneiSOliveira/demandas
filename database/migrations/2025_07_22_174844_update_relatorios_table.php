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
    Schema::table('relatorios', function (Blueprint $table) {
        // Ajusta o campo conteudo pra longtext
        $table->longText('conteudo')->change();

        // Ajusta os campos de timestamp para seguir o padrão do banco antigo
        $table->timestamp('criado_em')->useCurrent()->change();
        $table->timestamp('atualizado_em')->useCurrent()->useCurrentOnUpdate()->change();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
