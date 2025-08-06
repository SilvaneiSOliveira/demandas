<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
{
    Schema::table('demandas', function (Blueprint $table) {
        $table->string('anexo')->nullable()->after('descricao'); // ajusta 'descricao' se quiser ordenar diferente
    });
}

   public function down()
{
    Schema::table('demandas', function (Blueprint $table) {
        $table->dropColumn('anexo');
    });
}

};
