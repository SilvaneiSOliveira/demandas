<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('filiais', function (Blueprint $table) {
            $table->string('tipo_suporte', 255)->nullable()->after('nome'); // Opcional: after()
            $table->string('produto', 255)->nullable()->after('tipo_suporte'); // Opcional: after()
        });
    }

    public function down()
    {
        Schema::table('filiais', function (Blueprint $table) {
            $table->dropColumn(['tipo_suporte', 'produto']);
        });
    }
};
