<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public function index()
    {
        $matriculas = Matricula::all();
        return view('matriculas.index', compact('matriculas'));
    }

    public function store(Request $request)
    {
        Matricula::create($request->all());
        return redirect()->back()->with('ok', 'Matrícula creada');
    }

    public function update(Request $request, $id)
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->update($request->all());
        return redirect()->back()->with('ok', 'Actualizado');
    }

    public function destroy($id)
    {
        Matricula::destroy($id);
        return redirect()->back()->with('ok', 'Eliminado');
    }
}

