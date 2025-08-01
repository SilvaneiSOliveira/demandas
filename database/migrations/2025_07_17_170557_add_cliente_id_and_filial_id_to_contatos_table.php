<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contatos', function (Blueprint $table) {
            $table->unsignedBigInteger('filial_id')->nullable()->after('empresa_id');
            $table->foreign('filial_id')->references('id')->on('filiais')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('contatos', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropForeign(['filial_id']);
            $table->dropColumn(['empresa_id', 'filial_id']);
        });
    }
};
