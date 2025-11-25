<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();

            // Datos básicos (si más adelante quieres relacionar con modelos usar foreignId)
            $table->string('alumno');        // nombre o identificador legible del alumno
            $table->string('curso');         // nombre del curso (o código)
            $table->date('fecha')->nullable();
            $table->string('semestre')->nullable(); // ej. "2025-2"
            $table->enum('estado', ['Pendiente','Aprobado','Completado'])->default('Pendiente');

            // Opcionales / metadatos
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matriculas');
    }
};
