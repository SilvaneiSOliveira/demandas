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
        Schema::create('computadores', function (Blueprint $table) {
            $table->id();

            // relação com cliente
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');

            // relação com filial (pode ser null caso a máquina esteja no cliente matriz)
            $table->foreignId('filial_id')->nullable()->constrained('filiais')->onDelete('cascade');

            // tag única em todo o sistema
            $table->string('tag')->unique();

            $table->string('local');
            $table->string('processador');
            $table->string('memoria_ram');
            $table->string('armazenamento');
            $table->string('sistema_operacional');
            $table->text('observacao')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computadores');
    }
};
