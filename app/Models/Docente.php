<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $fillable = [
        'nombre',
        'email',
        'especializacion',
        'departamento',
        'cursos',
        'estado',
    ];
}
