<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::orderBy('id', 'desc')->get();
        return view('docentes.index', compact('docentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:docentes',
            'especializacion' => 'required',
            'departamento' => 'required',
            'cursos' => 'required|integer',
            'estado' => 'required',
        ]);

        Docente::create($request->all());

        return redirect()->back()->with('success', 'Docente creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $docente = Docente::findOrFail($id);

        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:docentes,email,' . $docente->id,
            'especializacion' => 'required',
            'departamento' => 'required',
            'cursos' => 'required|integer',
            'estado' => 'required',
        ]);

        $docente->update($request->all());

        return redirect()->back()->with('success', 'Docente actualizado');
    }

    public function destroy($id)
    {
        Docente::destroy($id);

        return redirect()->back()->with('success', 'Docente eliminado');
    }
}
