<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('preinscripcions', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('estado')->default('inactiva');
            $table->timestamps();
        });

        Schema::create('preinscripcion_cupos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('preinscripcion_id')->constrained()->onDelete('cascade');
            $table->foreignId('salon_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('cupo_total');
            $table->timestamps();

            $table->unique(['preinscripcion_id', 'salon_id'], 'preinscripcion_salon_unique');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preinscripcions');
    }
};
