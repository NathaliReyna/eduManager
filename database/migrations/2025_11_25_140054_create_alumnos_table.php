<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnosTable extends Migration
{
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('curso')->nullable();
            $table->string('anio')->nullable();
            $table->decimal('promedio', 5, 2)->nullable();
            $table->enum('estado', ['Activo','Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alumnos');
    }
}
