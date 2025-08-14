<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('contatos_filial', function (Blueprint $table) {
            $table->string('cargo')->nullable()->after('nome');
        });
    }

    public function down()
    {
        Schema::table('contatos_filial', function (Blueprint $table) {
            $table->dropColumn('cargo');
        });
    }
};