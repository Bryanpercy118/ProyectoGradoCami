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
    public function up(): void
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->id();

            // Users.id es INT UNSIGNED en tu BD
            $table->unsignedInteger('estudiante_id');
            $table->unsignedInteger('docente_id');

            // Otras FKs son BIGINT UNSIGNED
            $table->unsignedBigInteger('periodo_id');
            $table->unsignedBigInteger('subject_id');

            $table->year('year');
            $table->decimal('nota', 4, 2)->nullable(); // escala 0–5 (ajusta si usas 0–10)

            $table->timestamps();

            // FKs
            $table->foreign('estudiante_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('docente_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('periodo_id')->references('id')->on('periodos')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

            // Unicidad por alumno + periodo + materia
            $table->unique(['estudiante_id', 'periodo_id', 'subject_id'], 'nota_unica_por_periodo_materia');

            // Índices útiles
            $table->index('docente_id');
            $table->index('year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notas');
    }
};
