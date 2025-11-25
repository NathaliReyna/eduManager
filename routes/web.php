<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MatriculaController;





// Página de inicio (pública)
Route::get('/', function () {
    return view('welcome');
});

// Dashboard principal
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Auth::routes();

// Grupo protegido para las demás vistas
Route::middleware('auth')->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- NUEVAS RUTAS PARA TU MENÚ ---

    Route::resource('alumnos', AlumnoController::class)->only([
    'index','store','update','destroy'
    ]);

    
    Route::get('/docentes', [DocenteController::class, 'index'])->name('docentes.index');
    Route::post('/docentes', [DocenteController::class, 'store'])->name('docentes.store');
    Route::put('/docentes/{id}', [DocenteController::class, 'update'])->name('docentes.update');
    Route::delete('/docentes/{id}', [DocenteController::class, 'destroy'])->name('docentes.destroy');

    Route::resource('cursos', CursoController::class)->only([
    'index','store','update','destroy'
    ]);

    Route::resource('matriculas', MatriculaController::class)->only([
    'index','store','update','destroy'
    ]);


});

require __DIR__.'/auth.php';
