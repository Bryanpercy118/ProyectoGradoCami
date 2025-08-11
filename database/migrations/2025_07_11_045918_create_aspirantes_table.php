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
        Schema::create('aspirantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_estudiante');
            $table->date('fecha_nacimiento');
            $table->string('discapacidad')->nullable();
            $table->string('grado_solicitado');
            $table->string('nombre_acudiente');
            $table->string('correo_acudiente');
            $table->string('telefono_acudiente');
            $table->json('datos_acudiente')->nullable();

            // Relaciones
            $table->foreignId('salon_id')
                ->constrained('salons')
                ->onDelete('restrict'); // evita eliminar salón con aspirantes asociados

            $table->foreignId('preinscripcion_id')
                ->constrained()
                ->onDelete('cascade'); // si se elimina preinscripción, elimina aspirantes

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aspirantes');
    }
};
