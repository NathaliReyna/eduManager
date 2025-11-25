@extends('layouts.app')

@section('contenido')

<style>
/* ======= SEARCH BAR ======= */
.search-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.search-bar input {
    width: 260px;
    padding: 10px 14px;
    border: 1px solid #ddd;
    border-radius: 10px;
    font-size: 14px;
}

.search-bar button {
    background: #4A67E8;
    color: white;
    padding: 10px 18px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 14px;
}

/* ======= CARDS ======= */
.cards {
    display: flex;
    gap: 25px;
    margin-bottom: 30px;
}
.card {
    display: flex;
    align-items: center;
    background: #fff;
    border: 1px solid #e5e5e5;
    padding: 20px;
    border-radius: 16px;
    width: 23%;
}
.card img {
    width: 55px;
    height: 55px;
    margin-right: 15px;
}
.card .text small {
    color: #777;
    font-size: 13px;
}
.card .text h2 {
    font-size: 26px;
    margin: 4px 0;
    font-weight: bold;
}

/* ===== TABLA ===== */
.table-container {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 16px;
    padding: 20px;
}
table {
    width: 100%;
    border-collapse: collapse;
}
table th {
    text-align: left;
    font-size: 13px;
    color: #777;
    padding-bottom: 10px;
}
table td {
    padding: 14px 0;
    border-top: 1px solid #f0f0f0;
}

.badge {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
}

.badge.activo { background: #E4F6EA; color: #27ae60; }
.badge.pendiente { background: #FFF4D8; color: #f39c12; }

/* ====== ACTIONS ===== */
.action-btns button {
    border: none;
    background: transparent;
    cursor: pointer;
    font-size: 18px;
    margin-right: 6px;
}

/* ===== POPUPS ===== */
.popup-bg {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.45);
    justify-content: center;
    align-items: center;
}
.popup {
    background: white;
    width: 480px;
    padding: 25px;
    border-radius: 16px;
}
.popup h2 {
    margin-bottom: 15px;
}
.popup form input,
.popup form select {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border: 1px solid #ccc;
    border-radius: 10px;
}
.popup-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}
.btn-cancel {
    padding: 8px 14px;
    background: #ccc;
    border-radius: 10px;
}
.btn-save {
    padding: 8px 14px;
    background: #4A67E8;
    color: white;
    border-radius: 10px;
}
</style>

<h1 class="page-title">Gestión de Matrículas</h1>
    <p class="page-subtitle" style="padding-bottom: 2rem">Administra las inscripciones de alumnos a cursos</p>

<div class="search-bar">
    <input type="text" id="searchInput" placeholder="Buscar matrícula... " >
    <button onclick="openCrear()">+ Nueva Matrícula</button>
</div>

<!-- ======= CARDS ======= -->
<div class="cards">
    <div class="card">
        <img src="/img/icon1.png" alt="icono">
        <div class="text">
            <small>Total Matrículas</small>
            <h2>120</h2>
        </div>
    </div>

    <div class="card">
        <img src="/img/icon2.png" alt="icono">
        <div class="text">
            <small>Activas</small>
            <h2>95</h2>
        </div>
    </div>

    <div class="card">
        <img src="/img/icon3.png" alt="icono">
        <div class="text">
            <small>Pendientes</small>
            <h2>18</h2>
        </div>
    </div>

    <div class="card">
        <img src="/img/icon4.png" alt="icono">
        <div class="text">
            <small>Canceladas</small>
            <h2>7</h2>
        </div>
    </div>
</div>

<!-- ===== TABLA ===== -->
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Curso</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tablaMatriculas">

            <tr>
                <td>Juan Pérez</td>
                <td>Programación Web</td>
                <td>12/01/2024</td>
                <td><span class="badge activo">Activo</span></td>
                <td class="action-btns">
                    <button onclick="openEditar(1,'Juan Pérez','Programación Web','Activo')">✏️</button>
                    <button onclick="openEliminar(1)">🗑️</button>
                </td>
            </tr>

            <tr>
                <td>Ana Torres</td>
                <td>Bases de Datos</td>
                <td>20/01/2024</td>
                <td><span class="badge pendiente">Pendiente</span></td>
                <td class="action-btns">
                    <button onclick="openEditar(2,'Ana Torres','Bases de Datos','Pendiente')">✏️</button>
                    <button onclick="openEliminar(2)">🗑️</button>
                </td>
            </tr>

            <tr>
                <td>Juan Rodriguez</td>
                <td>Bases de Datos</td>
                <td>20/01/2024</td>
                <td><span class="badge activo">Activo</span></td>
                <td class="action-btns">
                    <button onclick="openEditar(1,'Juan Roriguez','Bases de Datos','Activo')">✏️</button>
                    <button onclick="openEliminar(1)">🗑️</button>
                </td>
            </tr>

            <tr>
                <td>Ariana Gonzales</td>
                <td>Programación Web</td>
                <td>18/02/2024</td>
                <td><span class="badge activo">Activo</span></td>
                <td class="action-btns">
                    <button onclick="openEditar(1,'Juan Pérez','Programación Web','Activo')">✏️</button>
                    <button onclick="openEliminar(1)">🗑️</button>
                </td>
            </tr>


        </tbody>
    </table>
</div>

{{-- ====================== POPUPS ======================= --}}

<!-- CREAR -->
<div class="popup-bg" id="popupCrear">
    <div class="popup">
        <h2>Nueva Matrícula</h2>

        <form id="formCrear">
            <input type="text" placeholder="Alumno">
            <input type="text" placeholder="Curso">
            <select>
                <option>Activo</option>
                <option>Pendiente</option>
            </select>

            <div class="popup-buttons">
                <button type="button" class="btn-cancel" onclick="closeCrear()">Cancelar</button>
                <button type="submit" class="btn-save">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- EDITAR -->
<div class="popup-bg" id="popupEditar">
    <div class="popup">
        <h2>Editar Matrícula</h2>

        <form id="formEditar">
            <input type="hidden" id="edit_id">

            <input type="text" id="edit_alumno">
            <input type="text" id="edit_curso">

            <select id="edit_estado">
                <option>Activo</option>
                <option>Pendiente</option>
            </select>

            <div class="popup-buttons">
                <button type="button" class="btn-cancel" onclick="closeEditar()">Cancelar</button>
                <button type="submit" class="btn-save">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<!-- ELIMINAR -->
<div class="popup-bg" id="popupEliminar">
    <div class="popup">
        <h2>Eliminar Matrícula</h2>
        <p>¿Seguro que deseas eliminar esta matrícula?</p>

        <div class="popup-buttons">
            <button type="button" class="btn-cancel" onclick="closeEliminar()">Cancelar</button>
            <button class="btn-save">Eliminar</button>
        </div>
    </div>
</div>


<script>
/* ===== POPUPS ===== */
function openCrear() {
    document.getElementById('popupCrear').style.display = 'flex';
}

function closeCrear() {
    document.getElementById('popupCrear').style.display = 'none';
}

function openEditar(id, alumno, curso, estado) {
    document.getElementById('popupEditar').style.display = 'flex';
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_alumno').value = alumno;
    document.getElementById('edit_curso').value = curso;
    document.getElementById('edit_estado').value = estado;
}

function closeEditar() {
    document.getElementById('popupEditar').style.display = 'none';
}

function openEliminar(id) {
    document.getElementById('popupEliminar').style.display = 'flex';
}

function closeEliminar() {
    document.getElementById('popupEliminar').style.display = 'none';
}

/* ===== BUSCADOR ===== */
document.getElementById("searchInput").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#tablaMatriculas tr");

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>

@endsection
