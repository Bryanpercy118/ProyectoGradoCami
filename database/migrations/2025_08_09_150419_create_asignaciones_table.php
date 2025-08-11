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
    Schema::create('asignaciones', function (Blueprint $table) {
        $table->id();

        // Deben coincidir con el tipo exacto de cada tabla
        $table->unsignedInteger('teacher_id');       // users.id → int unsigned
        $table->unsignedBigInteger('subject_id');    // subjects.id → bigint unsigned
        $table->unsignedBigInteger('salon_id');      // salons.id → bigint unsigned

        $table->year('year');
        $table->timestamps();

        $table->foreign('teacher_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');

        $table->foreign('subject_id')
              ->references('id')
              ->on('subjects')
              ->onDelete('cascade');

        $table->foreign('salon_id')
              ->references('id')
              ->on('salons')
              ->onDelete('cascade');

        $table->unique(['teacher_id', 'subject_id', 'salon_id', 'year'], 'asignacion_unica');
    });
}






    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignaciones');
    }
};
