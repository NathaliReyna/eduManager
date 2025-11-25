<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    // muestra listado (puedes agregar middleware auth en routes)
    public function index()
    {
        $cursos = Curso::orderBy('nombre')->get();
        return view('cursos.index', compact('cursos'));
    }

    // crea curso
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'docente' => 'nullable|string|max:255',
            'horario' => 'nullable|string|max:255',
            'creditos' => 'nullable|integer|min:0|max:255',
            'categoria' => 'nullable|string|max:100',
            'estado' => 'nullable|in:Activo,Inactivo',
        ]);

        $data['estado'] = $data['estado'] ?? 'Activo';

        Curso::create($data);

        return redirect()->route('cursos.index')->with('success', 'Curso creado correctamente.');
    }

    // actualiza curso
    public function update(Request $request, Curso $curso)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'docente' => 'nullable|string|max:255',
            'horario' => 'nullable|string|max:255',
            'creditos' => 'nullable|integer|min:0|max:255',
            'categoria' => 'nullable|string|max:100',
            'estado' => 'nullable|in:Activo,Inactivo',
        ]);

        $curso->update($data);

        return redirect()->route('cursos.index')->with('success', 'Curso actualizado correctamente.');
    }

    // elimina curso
    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('cursos.index')->with('success', 'Curso eliminado correctamente.');
    }
}
