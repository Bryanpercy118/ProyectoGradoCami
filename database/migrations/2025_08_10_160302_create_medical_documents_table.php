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
    public function up(): void {
         Schema::create('medical_documents', function (Blueprint $table) {
            $table->increments('id'); // INT UNSIGNED
            $table->unsignedInteger('user_id'); // INT UNSIGNED -> empata con users.id

            $table->string('titulo', 150);
            $table->string('categoria', 50)->nullable();
            $table->string('archivo_path');
            $table->string('archivo_nombre');
            $table->unsignedBigInteger('archivo_tamano'); // ok que sea BIGINT; no afecta FK
            $table->string('archivo_mime', 100)->default('application/pdf');
            $table->string('checksum')->nullable();
            $table->enum('estado', ['cargado','revisado','rechazado'])->default('cargado');
            $table->timestamps();

            // Índice y FK explícita (no uses foreignId/constrained en este caso)
            $table->index('user_id');
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_documents');
    }
};
