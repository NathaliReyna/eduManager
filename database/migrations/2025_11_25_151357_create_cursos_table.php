<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('docente')->nullable();
            $table->string('horario')->nullable();
            $table->unsignedTinyInteger('creditos')->default(0);
            $table->string('categoria')->nullable();
            $table->enum('estado', ['Activo','Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cursos');
    }
};
