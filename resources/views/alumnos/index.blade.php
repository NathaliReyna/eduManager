@extends('layouts.app')

@section('contenido')
<style>
    /* --- estilos reducidos (puedes mover a public/login.css u otro) --- */
    .content-wrapper { padding: 30px; }
    .page-title { font-size: 32px; font-weight: 700; margin-bottom: 5px; }
    .page-subtitle { color: #6b7280; margin-bottom: 25px; }
    .card-box { background: #fff; border-radius: 16px; padding: 25px; box-shadow: 0 2px 6px rgba(0,0,0,0.07); }
    .search-box { background: #f5f6f8; border-radius: 10px; padding: 12px 15px; width: 360px; display: flex; align-items: center; gap: 10px; }
    .search-box input { border: none; background: transparent; width: 100%; outline: none; }
    .btn-new { background: #2563eb; color: white; border-radius: 10px; padding: 12px 20px; border: none; font-weight: 600; cursor: pointer; }
    .btn-new:hover { background: #1d4ed8; }
    table { width: 100%; border-collapse: collapse; margin-top: 25px; }
    th { padding: 12px; text-align: left; color: #6b7280; font-weight: 600; border-bottom: 1px solid #e5e7eb; }
    td { padding: 14px 12px; border-bottom: 1px solid #f1f1f1; vertical-align: middle; }
    .estado-activo { background: #d7f5d8; color: #2e7d32; padding: 6px 12px; border-radius: 12px; font-size: 13px; font-weight: 600; display:inline-block;}
    .acciones i { font-size: 18px; cursor: pointer; margin-right: 8px; }
    .edit-icon { color: #2563eb; }
    .delete-icon { color: #dc2626; }

    /* MODAL */
    .modal-bg { position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: none; justify-content: center; align-items: center; z-index: 900; }
    .modal { background: white; width: 820px; padding: 30px; border-radius: 18px; position: relative; animation: fadeIn .18s ease-in-out; display:flex; gap:20px; }
    @keyframes fadeIn { from { opacity: 0; transform: scale(.98); } to { opacity: 1; transform: scale(1); } }
    .modal-col { flex: 1; }
    .modal-title { font-size: 26px; font-weight: 700; margin-bottom: 5px; }
    .modal-sub { color: #6b7280; margin-bottom: 18px; }
    .form-row { display:flex; gap:16px; }
    .form-group { margin-bottom: 12px; flex:1; }
    .form-group label { font-weight:600; display:block; margin-bottom:6px; }
    .form-group input, .form-group select { width:100%; padding:12px; border-radius:10px; border:1px solid #ddd; outline:none; }
    .modal-footer { margin-top: 12px; display:flex; justify-content:flex-end; gap:10px; width:100%; }
    .btn-cancel { background:#e5e7eb; border:none; padding:10px 20px; border-radius:10px; cursor:pointer; }
    .btn-save { background:#2563eb; color:white; border:none; padding:10px 20px; border-radius:10px; cursor:pointer; font-weight:600; }

    /* responsive */
    @media (max-width: 900px) {
        .modal { width: 95%; flex-direction: column; }
        .search-box { width: 100%; }
    }
</style>

<div class="content-wrapper">
    <h1 class="page-title">Gestión de Alumnos</h1>
    <p class="page-subtitle">Administra la información de todos los estudiantes</p>

    {{-- mostrar mensajes flash --}}
    @if(session('success'))
        <div style="margin-bottom:12px; padding:10px 14px; background:#d1fae5; color:#065f46; border-radius:8px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-box">
        <div style="display:flex; justify-content: space-between; align-items:center;">
            {{-- Form de búsqueda (envía GET a index) --}}
            <form method="GET" action="{{ route('alumnos.index') }}" style="display:flex; gap:12px; align-items:center;">
                <div class="search-box">
                    <input type="text" id= "buscador" name="q" placeholder="Buscar alumno..." value="{{ request('q', '') }}">
                    <button type="submit" style="background:transparent; border:none; cursor:pointer;">🔍</button>
                </div>
            </form>

            <button class="btn-new" onclick="openCreate()">+ Nuevo alumno</button>
        </div>

        {{-- Tabla --}}
        <table id="tabla-alumnos" aria-describedby="lista de alumnos">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Curso</th>
                    <th>Año</th>
                    <th>Promedio</th>
                    <th>Estado</th>
                    <th style="width:120px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumnos as $alumno)
                <tr>
                    <td>{{ $alumno->nombre }}</td>
                    <td>{{ $alumno->email }}</td>
                    <td>{{ $alumno->curso }}</td>
                    <td>{{ $alumno->anio }}</td>
                    <td>{{ $alumno->promedio }}</td>
                    <td>
                        <span class="estado-activo">{{ $alumno->estado }}</span>
                    </td>
                    <td class="acciones">
                        {{-- Edit (abrirá modal y pondrá action dinámico) --}}
                        <i class="edit-icon" title="Editar" onclick="openEdit({{ $alumno->id }}, '{{ addslashes($alumno->nombre) }}', '{{ $alumno->email }}', '{{ addslashes($alumno->curso) }}', '{{ $alumno->anio }}', '{{ $alumno->promedio }}', '{{ $alumno->estado }}')">✏️</i>

                        {{-- Delete (form añadido) --}}
                        <form style="display:inline-block" method="POST" action="{{ route('alumnos.destroy', $alumno) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este alumno?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:transparent;border:none;cursor:pointer;font-size:18px;color:#dc2626;" title="Eliminar">🗑️</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:30px;">No hay alumnos aún.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL CREAR --}}
<div id="modalCreate" class="modal-bg" aria-hidden="true">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="tituloCrear">
        <div class="modal-col">
            <h3 id="tituloCrear" class="modal-title">Nuevo alumno</h3>
            <p class="modal-sub">Ingresa los datos del nuevo alumno</p>

            <form action="{{ route('alumnos.store') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre completo</label>
                        <input name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" type="email" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Curso</label>
                        <input name="curso">
                    </div>
                    <div class="form-group">
                        <label>Año/Grado</label>
                        <select name="anio">
                            <option value="">Seleccionar</option>
                            <option>1er año</option>
                            <option>2do año</option>
                            <option>3er año</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Promedio</label>
                        <input name="promedio" type="number" step="0.01" min="0" max="100" placeholder="Ejem: 17">
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="estado">
                            <option value="Activo" selected>Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeCreate()">Cancelar</button>
                    <button class="btn-save" type="submit">Crear alumno</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDITAR --}}
<div id="modalEdit" class="modal-bg" aria-hidden="true">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="tituloEditar">
        <div class="modal-col">
            <h3 id="tituloEditar" class="modal-title">Editar alumno</h3>
            <p class="modal-sub">Modifica los datos necesarios</p>

            {{-- El action se setea dinámicamente en JS --}}
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre completo</label>
                        <input name="nombre" id="editNombre" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" id="editEmail" type="email" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Curso</label>
                        <input name="curso" id="editCurso">
                    </div>
                    <div class="form-group">
                        <label>Año/Grado</label>
                        <select name="anio" id="editAnio">
                            <option value="">Seleccionar</option>
                            <option>1er año</option>
                            <option>2do año</option>
                            <option>3er año</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Promedio</label>
                        <input name="promedio" id="editPromedio" type="number" step="0.01" min="0" max="100">
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="estado" id="editEstado">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeEdit()">Cancelar</button>
                    <button class="btn-save" type="submit">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
/* Control modals */
function openCreate(){ document.getElementById('modalCreate').style.display = 'flex'; document.body.style.overflow='hidden'; }
function closeCreate(){ document.getElementById('modalCreate').style.display = 'none'; document.body.style.overflow='auto'; }

function openEdit(id, nombre, email, curso, anio, promedio, estado) {
    document.getElementById('modalEdit').style.display = 'flex';
    document.body.style.overflow='hidden';

    // llenar campos
    document.getElementById('editNombre').value = nombre;
    document.getElementById('editEmail').value = email;
    document.getElementById('editCurso').value = curso;
    document.getElementById('editAnio').value = anio;
    document.getElementById('editPromedio').value = promedio;
    document.getElementById('editEstado').value = estado;

    // set action (ruta update)
    document.getElementById('formEdit').action = '/alumnos/' + id;
}

function closeEdit(){ document.getElementById('modalEdit').style.display = 'none'; document.body.style.overflow='auto'; }



    //buscador
    document.getElementById('buscador').addEventListener('keyup', function() {
    const valor = this.value.toLowerCase();
    const filas = document.querySelectorAll('#tabla-alumnos tbody tr');

    filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        fila.style.display = textoFila.includes(valor) ? '' : 'none';
    });
});
</script>

@endsection
