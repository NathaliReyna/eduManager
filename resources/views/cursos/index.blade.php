{{-- resources/views/cursos/index.blade.php --}}
@extends('layouts.app')

@section('contenido')
<style>
    /* estilos (igual visual que tus otras vistas) */
    .cursos-container { padding: 25px; }
    .cursos-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
    .search-box { width: 420px; position: relative; }
    .search-box input { width:100%; padding:12px 40px 12px 15px; border-radius:10px; border:1px solid #eee; background:#f7f7f7; }
    .search-box button { position:absolute; right:8px; top:7px; border:none; background:transparent; cursor:pointer; }
    .btn-nuevo { background:#2563eb; color:white; padding:10px 18px; border-radius:8px; border:none; cursor:pointer; }

    #cursos-lista { display:flex; flex-wrap:wrap; gap:16px; margin-top:18px; }

    .curso-card { width:300px; padding:18px; border-radius:10px; border-top:10px solid #155DFC; background:white; position:relative; box-shadow:0 2px 6px rgba(0,0,0,0.03); }
    .curso-card h3{margin:0 0 4px 0}
    .curso-card small{color:#777;display:block;margin-bottom:8px}
    .curso-card p{color:#333;margin:16px 0}
    .curso-card .meta{font-size:13px;color:#5b5b5b}
    .curso-card .tags{margin-top:12px}
    


    .curso-card button:focus,
    .curso-card button:active {
    outline: none !important;
    box-shadow: none !important;

    .curso-card {
    outline: none !important;
    border: blue !important;
}
}
    .tag{display:inline-block;padding:6px 10px;border-radius:8px;background:#111;color:#fff;font-size:12px;margin-right:8px}
    .tag-activo{background:#d7f5d8;color:#1f7a2f}

    .edit-icon{position:absolute; right:12px; top:12px; cursor:pointer; font-size:16px}

    /* popup */
    .popup-overlay{position:fixed; inset:0; background:rgba(0,0,0,0.5); display:none; justify-content:center; align-items:center; z-index:1100}
    .popup{width:560px; background:white; padding:22px; border-radius:12px}
    .popup h2{margin:0 0 6px 0}
    .popup label{display:block;margin-top:12px;font-weight:600}
    .popup input, .popup textarea, .popup select{width:100%;padding:10px;border-radius:8px;border:1px solid #ddd;background:#fafafa}
    .popup textarea{min-height:80px}
    .popup-buttons{display:flex;justify-content:flex-end;gap:10px;margin-top:18px}
    .btn-cancel{background:#f0f0f0;padding:8px 14px;border-radius:8px;border:none;cursor:pointer}
    .btn-save{background:#2563eb;color:white;padding:8px 14px;border-radius:8px;border:none;cursor:pointer}

    /* responsive */
    @media (max-width: 900px){
        .curso-card{width:100%}
        .popup{width:95%}
    }
</style>

<div class="cursos-container">
    <div class="cursos-header">
        <div>
            <h1>Gestión de Cursos</h1>
            <p class="text-muted">Administra todos los cursos académicos</p>
        </div>

        <div style="display:flex; gap:12px; align-items:center;">
            <div class="search-box">
                <input id="buscadorCursos" placeholder="Buscar curso...">
                <button type="button">🔍</button>
            </div>

            <button class="btn-nuevo" onclick="openCrear()">+ Nuevo curso</button>
        </div>
    </div>

    {{-- mensajes flash --}}
    @if(session('success'))
        <div style="margin-bottom:12px;padding:10px;background:#d1fae5;color:#065f46;border-radius:8px;">{{ session('success') }}</div>
    @endif

    <div id="cursos-lista">
        @foreach($cursos as $curso)
            <div class="curso-card" data-nombre="{{ strtolower($curso->nombre) }}">
                {{-- Edit (abre modal) --}}
                <button type="button" onclick='openEditar(@json($curso))' class="edit-icon" title="Editar">✏️</button>


                <h3>{{ $curso->nombre }}</h3>
                <small>{{ $curso->codigo }}</small>

                <p>{{ Str::limit($curso->descripcion, 160) }}</p>

                <p class="meta">
                    👨‍🏫 {{ $curso->docente ?? '—' }}<br>
                    🕒 {{ $curso->horario ?? '—' }} <br>
                    📚 {{ $curso->creditos ?? 0 }} créditos
                </p>

                <div class="tags">
                    @if($curso->categoria)
                        <span class="tag">{{ $curso->categoria }}</span>
                    @endif
                    <span class="tag tag-activo">{{ $curso->estado }}</span>

                    {{-- Delete form --}}
                    <form method="POST" action="{{ route('cursos.destroy', $curso) }}" style="display:inline-block; float:right;" onsubmit="return confirm('¿Eliminar curso?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-cancel" style="background:transparent;border:none;color:#dc2626;cursor:pointer">🗑️</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- POPUP CREAR -->
<div id="popupCrear" class="popup-overlay" aria-hidden="true">
    <div class="popup" role="dialog">
        <h2>Nuevo curso</h2>
        <p class="text-muted">Completa los datos</p>

        <form id="formCrear" action="{{ route('cursos.store') }}" method="POST">
            @csrf

            <label>Nombre</label>
            <input name="nombre" required>

            <label>Código</label>
            <input name="codigo">

            <label>Descripción</label>
            <textarea name="descripcion"></textarea>

            <label>Docente</label>
            <input name="docente">

            <div style="display:flex; gap:10px;">
                <div style="flex:1">
                    <label>Horario</label>
                    <input name="horario">
                </div>
                <div style="width:120px">
                    <label>Créditos</label>
                    <input name="creditos" type="number" min="0" value="0">
                </div>
            </div>

            <label>Categoría</label>
            <input name="categoria">

            <label>Estado</label>
            <select name="estado">
                <option value="Activo" selected>Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>

            <div class="popup-buttons">
                <button type="button" class="btn-cancel" onclick="closeCrear()">Cancelar</button>
                <button class="btn-save">Crear curso</button>
            </div>
        </form>
    </div>
</div>

<!-- POPUP EDITAR -->
<div id="popupEditar" class="popup-overlay" aria-hidden="true">
    <div class="popup" role="dialog">
        <h2>Editar curso</h2>
        <p class="text-muted">Modifica lo necesario</p>

        <form id="formEditar" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" id="edit_id" name="id">

            <label>Nombre</label>
            <input id="edit_nombre" name="nombre" required>

            <label>Código</label>
            <input id="edit_codigo" name="codigo">

            <label>Descripción</label>
            <textarea id="edit_descripcion" name="descripcion"></textarea>

            <label>Docente</label>
            <input id="edit_docente" name="docente">

            <div style="display:flex; gap:10px;">
                <div style="flex:1">
                    <label>Horario</label>
                    <input id="edit_horario" name="horario">
                </div>
                <div style="width:120px">
                    <label>Créditos</label>
                    <input id="edit_creditos" name="creditos" type="number" min="0">
                </div>
            </div>

            <label>Categoría</label>
            <input id="edit_categoria" name="categoria">

            <label>Estado</label>
            <select id="edit_estado" name="estado">
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>

            <div class="popup-buttons">
                <button type="button" class="btn-cancel" onclick="closeEditar()">Cancelar</button>
                <button class="btn-save">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>

<script>
/* ====== Buscador en tiempo real (JS) ====== */
document.getElementById('buscadorCursos').addEventListener('keyup', function(){
    const q = this.value.toLowerCase();
    document.querySelectorAll('#cursos-lista .curso-card').forEach(card=>{
        const nombre = card.dataset.nombre || '';
        card.style.display = nombre.includes(q) ? 'block' : 'none';
    });
});

/* ====== Popups ====== */
function openCrear(){ document.getElementById('popupCrear').style.display = 'flex'; document.body.style.overflow='hidden'; }
function closeCrear(){ document.getElementById('popupCrear').style.display = 'none'; document.body.style.overflow='auto'; }

function openEditar(curso){
    const modal = document.getElementById('popupEditar');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    document.getElementById('edit_id').value = curso.id;
    document.getElementById('edit_nombre').value = curso.nombre;
    document.getElementById('edit_codigo').value = curso.codigo ?? '';
    document.getElementById('edit_descripcion').value = curso.descripcion ?? '';
    document.getElementById('edit_docente').value = curso.docente ?? '';
    document.getElementById('edit_horario').value = curso.horario ?? '';
    document.getElementById('edit_creditos').value = curso.creditos ?? 0;
    document.getElementById('edit_categoria').value = curso.categoria ?? '';
    document.getElementById('edit_estado').value = curso.estado;

    // asignar action del formulario PUT
    document.getElementById('formEditar').action = `/cursos/${curso.id}`;
}

function closeEditar(){ document.getElementById('popupEditar').style.display = 'none'; document.body.style.overflow='auto'; }
</script>

<!-- referencia imagen (local) -->
<!-- Imagen de referencia: /mnt/data/Cursos.png -->

@endsection
