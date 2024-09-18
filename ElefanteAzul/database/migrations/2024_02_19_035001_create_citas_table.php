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
        Schema::create('citas', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->datetime('entrada')->nullable();
            $table->datetime('salida')->nullable();
            $table->string('nombre', 30)->nullable();
            $table->char('telefono', 9)->nullable();
            $table->string('coche', 50)->nullable();
            $table->char('matricula', 7)->nullable();
            $table->char('tipo_lavado', 36)->nullable();
            $table->foreign('tipo_lavado')->references('id')->on('tipo_lavado');
            $table->tinyInteger('llantas')->nullable();
            $table->float('precio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
