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
        Schema::table('computadores', function (Blueprint $table) {
           $table->timestamp('ultima_alteracao')->nullable()->after('updated_at');
           $table->string('usuario_alteracao')->nullable()->after('ultima_alteracao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('computadores', function (Blueprint $table) {
          $table->dropColumn(['ultima_alteracao', 'usuario_alteracao']);
        });
    }
};
