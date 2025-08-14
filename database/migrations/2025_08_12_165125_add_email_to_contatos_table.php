<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('contatos', function (Blueprint $table) {
            $table->string('email', 255)->nullable()->after('nome'); // Opcional: `->after()` define a posição da coluna
        });
    }

    public function down()
    {
        Schema::table('contatos', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};