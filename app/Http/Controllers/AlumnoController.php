<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        // búsqueda simple por nombre/email/curso
        $q = $request->get('q', '');
        $alumnos = Alumno::when($q, function($query, $q) {
            $q = "%$q%";
            $query->where('nombre', 'like', $q)
                    ->orWhere('email', 'like', $q)
                    ->orWhere('curso', 'like', $q);
        })->orderBy('nombre')->get();

        return view('alumnos.index', compact('alumnos', 'q'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'email'  => 'required|email|unique:alumnos,email',
            'curso'  => 'nullable|string|max:255',
            'anio'   => 'nullable|string|max:100',
            'promedio' => 'nullable|numeric|min:0|max:100',
            'estado' => 'nullable|in:Activo,Inactivo',
        ]);

        $data['estado'] = $data['estado'] ?? 'Activo';

        Alumno::create($data);

        return redirect()->route('alumnos.index')->with('success', 'Alumno creado correctamente.');
    }

    public function update(Request $request, Alumno $alumno)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'email'  => 'required|email|unique:alumnos,email,' . $alumno->id,
            'curso'  => 'nullable|string|max:255',
            'anio'   => 'nullable|string|max:100',
            'promedio' => 'nullable|numeric|min:0|max:100',
            'estado' => 'nullable|in:Activo,Inactivo',
        ]);

        $alumno->update($data);

        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente.');
    }
}
