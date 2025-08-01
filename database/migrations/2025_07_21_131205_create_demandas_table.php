<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('demandas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->unsignedBigInteger('filial_id')->nullable();
            $table->string('titulo', 255)->nullable();
            $table->text('descricao')->nullable();
            $table->string('status', 50)->nullable();
            $table->timestamp('criado_em')->nullable();
            $table->string('atendente', 100)->nullable();
            $table->date('data_agendamento')->nullable();
            $table->text('resolucao')->nullable();
            $table->string('produto', 255)->nullable();
            $table->string('anexo', 255)->nullable();
            $table->enum('classificacao', ['Remoto', 'Presencial'])->nullable();
            $table->string('duracao_atendimento', 10)->nullable();
            $table->string('nivel', 2)->nullable();
            $table->string('solicitante', 100)->nullable();
            $table->string('ticket', 30)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandas');
    }
};
