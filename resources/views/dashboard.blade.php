@extends('layouts.app')

@section('contenido')

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* ===== GENERAL ===== */
.dashboard-title {
    font-size: 32px;
    font-weight: bold;
    margin-bottom: 5px;
}

.dashboard-subtitle {
    color: #6b6b6b;
    margin-bottom: 25px;
}

/* ===== CUADRO AZUL ===== */
.info-box {
    background: #eef4ff;
    padding: 22px;
    border-radius: 12px;
    border: 1px solid #d4e2ff;
    display: flex;
    gap: 15px;
    margin-bottom: 35px;
}

.info-box strong {
    color: #1d3ff4;
}

/* ===== TARJETAS ===== */
.cards {
    display: flex;
    gap: 20px;
    margin-bottom: 35px;
}

.card {
    background: #fff;
    border: 1px solid #e5e5e5;
    padding: 22px;
    border-radius: 14px;
    width: 22%;
}

.card-title {
    font-size: 14px;
    color: #6b6b6b;
    margin-bottom: 15px;
}

.card-number {
    font-size: 30px;
    font-weight: bold;
    margin-bottom: 10px;
}

.card-growth {
    color: #28a745;
    font-weight: bold;
}

/* ===== SECCIÓN DE GRÁFICOS ===== */
.charts-container {
    display: flex;
    gap: 25px;
    margin-top: 20px;
}

.chart-box {
    background: #fff;
    border: 1px solid #e5e5e5;
    padding: 25px;
    border-radius: 14px;
    width: 100%;
}

.chart-title {
    font-weight: bold;
    margin-bottom: 15px;
}
</style>

<div>
    <h1 class="dashboard-title">Dashboard EduManager</h1>
    <p class="dashboard-subtitle">Resumen general del sistema académico</p>

    {{-- CUADRO AZUL --}}
    <div class="info-box">
        <span style="font-size:22px; color:#2563eb;">🔵</span>
        <p>
            <strong>Visualización de reportes:</strong>
            Este módulo permite observar de manera rápida reportes de total de alumnos,
            docentes, cursos y aprobados. Observa en los gráficos dinámicos el resumen de datos.
        </p>
    </div>

    {{-- TARJETAS --}}
    <div class="cards">
        <div class="card">
            <div class="card-title">Total alumnos</div>
            <div class="card-number">340</div>
            <div class="card-growth">+12.5% este mes</div>
        </div>

        <div class="card">
            <div class="card-title">Total docentes</div>
            <div class="card-number">50</div>
            <div class="card-growth">+3.2% este mes</div>
        </div>

        <div class="card">
            <div class="card-title">Cursos activos</div>
            <div class="card-number">70</div>
            <div class="card-growth">+8.1% este mes</div>
        </div>

        <div class="card">
            <div class="card-title">Aprobados</div>
            <div class="card-number">94.2%</div>
            <div class="card-growth">+2.4% este mes</div>
        </div>
    </div>

    {{-- GRÁFICOS --}}
    <div class="charts-container">

        {{-- Gráfico de barras --}}
        <div class="chart-box">
            <div class="chart-title">Evolución de Matrículas</div>
            <canvas id="barChart"></canvas>
        </div>

        {{-- Gráfico donut --}}
        <div class="chart-box" style="max-width: 420px;">
            <div class="chart-title">Distribución por áreas</div>
            <canvas id="donutChart"></canvas>
        </div>

    </div>
</div>

<script>
/* ======================
   GRÁFICO DE BARRAS
======================= */
const ctx1 = document.getElementById('barChart');
new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul'],
        datasets: [{
            data: [65, 60, 110, 130, 80, 75, 55],
            backgroundColor: [
                '#f8c7c7',
                '#f3bebe',
                '#ffe6b8',
                '#b7dfff',
                '#c7d2ff',
                '#d7caff',
                '#f7d4d4'
            ],
            borderRadius: 8
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

/* ======================
   GRÁFICO DONUT
======================= */
const ctx2 = document.getElementById('donutChart');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Ciencias', 'Matemáticas', 'Letras', 'Artes', 'Humanidades'],
        datasets: [{
            data: [40, 25, 15, 10, 10],
            backgroundColor: [
                '#8ec5ff',
                '#b8ddff',
                '#dccaff',
                '#baf6ff',
                '#c9c9ff'
            ]
        }]
    },
    options: {
        cutout: '60%',
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

@endsection

