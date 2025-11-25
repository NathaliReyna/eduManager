{{-- resources/views/docentes/index.blade.php --}}
@extends('layouts.app')

@section('contenido')
<style>
/* ===== Página y contenedores ===== */
.content-wrapper { padding: 30px; }
.page-title { font-size: 32px; font-weight: 700; margin-bottom: 5px; }
.page-subtitle { color: #6b7280; margin-bottom: 25px; }
.card-box { background: #fff; border-radius: 16px; padding: 25px; box-shadow: 0 2px 6px rgba(0,0,0,0.07); }

/* ===== Buscador + botón nuevo ===== */
.search-box { background: #f5f6f8; border-radius: 10px; padding: 12px 15px; width: 360px; display: flex; align-items: center; gap: 10px; }
.search-box input { border: none; background: transparent; width: 100%; outline: none; }
.btn-new { background: #2563eb; color: white; border-radius: 10px; padding: 12px 20px; border: none; font-weight: 600; cursor: pointer; }
.btn-new:hover { background:#1d4ed8; }

/* ===== Tabla ===== */
table { width: 100%; border-collapse: collapse; margin-top: 25px; }
th { padding: 12px; text-align: left; color: #6b7280; font-weight: 600; border-bottom: 1px solid #e5e7eb; }
td { padding: 14px 12px; border-bottom: 1px solid #f1f1f1; vertical-align: middle; }

/* ===== Estado ===== */
.estado-activo { background: #d7f5d8; color: #2e7d32; padding: 6px 12px; border-radius: 12px; font-size: 13px; font-weight: 600; display:inline-block; }
.estado-inactivo { background:#fbe7e7; color:#b91c1c; padding:6px 12px; border-radius:12px; font-size:13px; font-weight:600; display:inline-block; }

/* ===== Iconos ACCIONES ===== */
.acciones button.icon-btn { background: transparent; border: none; cursor: pointer; font-size: 18px; margin-right: 8px; }
.icon-edit { color: #2563eb; }
.icon-delete { color: #dc2626; }

/* ===== MODALES ===== */
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
    <h1 class="page-title">Gestión de Docentes</h1>
    <p class="page-subtitle">Administra la información del personal docente</p>

    {{-- imagen opcional (usada para referencia en diseño) --}}
    <div style="display:none;">
        <img src="/mnt/data/Docentes.png" alt="docentes reference">
    </div>

    <div class="card-box">
        <div style="display:flex; justify-content: space-between; align-items:center;">
            {{-- Buscador (filtrado en tiempo real con JS) --}}
            <div class="search-box" style="width:480px;">
                <input type="text" id="buscadorDocentes" placeholder="Buscar docente...">
                <button type="button" style="background:transparent;border:none;cursor:pointer;">🔍</button>
            </div>

            {{-- Nuevo docente --}}
            <button class="btn-new" onclick="openCreate()">+ Nuevo docente</button>
        </div>

        {{-- Tabla --}}
        <table id="tablaDocentes" aria-describedby="lista de docentes">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Especialización</th>
                    <th>Departamento</th>
                    <th>Cursos</th>
                    <th>Estado</th>
                    <th style="width:120px">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($docentes as $docente)
                <tr>
                    <td>{{ $docente->nombre }}</td>
                    <td>{{ $docente->email }}</td>
                    <td>{{ $docente->especializacion }}</td>
                    <td>{{ $docente->departamento }}</td>
                    <td>{{ $docente->cursos }}</td>
                    <td>
                        @if($docente->estado === 'Activo')
                            <span class="estado-activo">Activo</span>
                        @else
                            <span class="estado-inactivo">Inactivo</span>
                        @endif
                    </td>
                    <td class="acciones">
                        {{-- Edit: abrimos modal con datos --}}
                        <button class="icon-btn" title="Editar" onclick="openEditDocente({{ $docente->id }}, '{{ addslashes($docente->nombre) }}', '{{ $docente->email }}', '{{ addslashes($docente->especializacion) }}', '{{ addslashes($docente->departamento) }}', {{ $docente->cursos }}, '{{ $docente->estado }}')">
                            <span class="icon-edit">✏️</span>
                        </button>

                        {{-- Delete --}}
                        <form style="display:inline-block" method="POST" action="{{ route('docentes.destroy', $docente->id) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este docente?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-btn" title="Eliminar">
                                <span class="icon-delete">🗑️</span>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:30px;">No hay docentes aún.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

{{-- MODAL CREAR DOCENTE --}}
<div id="modalCreateDocente" class="modal-bg" aria-hidden="true">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="tituloCrearDocente">
        <div class="modal-col">
            <h3 id="tituloCrearDocente" class="modal-title">Nuevo docente</h3>
            <p class="modal-sub">Ingresa los datos del nuevo docente</p>

            <form action="{{ route('docentes.store') }}" method="POST" id="formCreateDocente">
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
                        <label>Especialización</label>
                        <input name="especializacion" placeholder="Ej: Física cuántica" >
                    </div>
                    <div class="form-group">
                        <label>Departamento</label>
                        <select name="departamento">
                            <option value="">Seleccionar</option>
                            <option>Matemática</option>
                            <option>Física</option>
                            <option>Artes</option>
                            <option>Lengua</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Cursos</label>
                        <input name="cursos" type="number" min="0" value="0">
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
                    <button type="button" class="btn-cancel" onclick="closeCreateDocente()">Cancelar</button>
                    <button class="btn-save" type="submit">Crear docente</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDITAR DOCENTE --}}
<div id="modalEditDocente" class="modal-bg" aria-hidden="true">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="tituloEditarDocente">
        <div class="modal-col">
            <h3 id="tituloEditarDocente" class="modal-title">Editar docente</h3>
            <p class="modal-sub">Modifica los datos necesarios</p>

            {{-- action se setea desde JS --}}
            <form id="formEditDocente" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre completo</label>
                        <input name="nombre" id="editDocNombre" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" id="editDocEmail" type="email" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Especialización</label>
                        <input name="especializacion" id="editDocEspecializacion">
                    </div>
                    <div class="form-group">
                        <label>Departamento</label>
                        <select name="departamento" id="editDocDepartamento">
                            <option value="">Seleccionar</option>
                            <option>Matemática</option>
                            <option>Física</option>
                            <option>Artes</option>
                            <option>Lengua</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Cursos</label>
                        <input name="cursos" id="editDocCursos" type="number" min="0">
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="estado" id="editDocEstado">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeEditDocente()">Cancelar</button>
                    <button class="btn-save" type="submit">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
/* ===== Modales ===== */
function openCreate(){ 
    document.getElementById('modalCreateDocente').style.display = 'flex'; 
    document.body.style.overflow = 'hidden';
}
function closeCreateDocente(){ 
    document.getElementById('modalCreateDocente').style.display = 'none'; 
    document.body.style.overflow = 'auto';
}

function openEditDocente(id, nombre, email, especializacion, departamento, cursos, estado) {
    document.getElementById('modalEditDocente').style.display = 'flex';
    document.body.style.overflow = 'hidden';

    document.getElementById('editDocNombre').value = nombre;
    document.getElementById('editDocEmail').value = email;
    document.getElementById('editDocEspecializacion').value = especializacion;
    document.getElementById('editDocDepartamento').value = departamento;
    document.getElementById('editDocCursos').value = cursos;
    document.getElementById('editDocEstado').value = estado;

    document.getElementById('formEditDocente').action = '/docentes/' + id;
}

function closeEditDocente(){
    document.getElementById('modalEditDocente').style.display = 'none';
    document.body.style.overflow = 'auto';
}

/* ===== Buscador en tiempo real (JS) ===== */
document.getElementById('buscadorDocentes').addEventListener('keyup', function() {
    const valor = this.value.toLowerCase();
    const filas = document.querySelectorAll('#tablaDocentes tbody tr');

    filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(valor) ? '' : 'none';
    });
});
</script>

@endsection
