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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('alumno_user_id');

            $table->unsignedBigInteger('salon_id');

            $table->year('year');

            $table->string('estado')->default('en_proceso');
            $table->string('folio')->nullable();
            $table->text('observaciones')->nullable();

            $table->foreignId('preinscripcion_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('aspirante_id')->nullable()->constrained('aspirantes')->nullOnDelete();

            $table->timestamps();

            $table->foreign('alumno_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('salon_id')->references('id')->on('salons')->onDelete('restrict');

            $table->unique(['alumno_user_id','year'], 'matricula_unica_por_anio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriculas');
    }
};
