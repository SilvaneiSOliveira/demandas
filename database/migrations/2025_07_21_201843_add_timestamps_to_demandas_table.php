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
    Schema::table('demandas', function (Blueprint $table) {
        $table->timestamps(); // Isso adiciona created_at e updated_at
    });
}

public function down()
{
    Schema::table('demandas', function (Blueprint $table) {
        $table->dropTimestamps();
    });
}

};
