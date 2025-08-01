<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNivelToDemandasTable extends Migration
{
    public function up()
    {
        Schema::table('demandas', function (Blueprint $table) {
            $table->enum('nivel', ['NE', 'N1', 'N2', 'N3', 'N4'])
                  ->default('NE')
                  ->comment('Níveis de prioridade: NE=Nenhum, N1=Urgente, N2=Alta, N3=Média, N4=Baixa');
        });
    }

    public function down()
    {
        Schema::table('demandas', function (Blueprint $table) {
            $table->dropColumn('nivel');
        });
    }
}