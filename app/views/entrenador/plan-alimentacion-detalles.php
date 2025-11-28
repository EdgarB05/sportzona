<?php
// Se espera que el controlador haya enviado $cuestionario
if (!isset($cuestionario)) {
    echo "Error: No se encontró el cuestionario.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del Cuestionario | Entrenador</title>
    <link rel="stylesheet" href="public/css/trainer.css">
</head>
<body>

<!-- SIDEBAR ENTRENADOR -->
<aside class="sidebar-trainer">
    <div class="sidebar-logo">SZ</div>

    <nav class="sidebar-nav">

        <!-- DASHBOARD -->
        <a href="index.php?controller=coach&action=index" class="sidebar-item">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- ENTRENAMIENTOS -->
        <a href="index.php?controller=entrenamientos&action=index" class="sidebar-item">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2h-4"/>
                <path d="M3 9V5a2 2 0 0 1 2-2h4"/>
                <rect x="3" y="9" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
            </svg>
            <span>Entrenamientos</span>
        </a>

        <!-- PLANES ALIMENTACIÓN -->
        <a href="index.php?controller=PlanAlimentacion&action=listar" class="sidebar-item active">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16v4H4z"/>
                <path d="M4 12h16v8H4z"/>
            </svg>
            <span>Planes Alimentación</span>
        </a>

        <!-- CITAS -->
        <a href="index.php?controller=citas&action=lista" class="sidebar-item">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
            <span>Citas</span>
        </a>

        <!-- LOGOUT -->
        <a href="index.php?controller=user&action=logout" class="sidebar-item">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <path d="M15 3h4v18h-4"/>
                <path d="M10 17l5-5-5-5"/>
                <path d="M15 12H3"/>
            </svg>
            <span>Cerrar sesión</span>
        </a>

    </nav>
</aside>

<!-- MAIN -->
<main class="main-content">

    <h1>Detalles del Cuestionario</h1>

    <div class="training-card" style="max-width:850px; margin-top:20px;">

        <h2><?= htmlspecialchars($cuestionario['nombreCompleto']) ?></h2>

        <p><strong>Cliente:</strong> 
            <?= htmlspecialchars($cuestionario['nombreUsuario'] . ' ' . $cuestionario['apePa'] . ' ' . $cuestionario['apeMa']) ?>
        </p>

        <p><strong>Fecha registrado:</strong> <?= htmlspecialchars($cuestionario['fechaRegistro']) ?></p>

        <hr>

        <h3>Datos Generales</h3>
        <p><strong>Edad:</strong> <?= $cuestionario['edad'] ?></p>
        <p><strong>Peso:</strong> <?= $cuestionario['peso'] ?> kg</p>
        <p><strong>Estatura:</strong> <?= $cuestionario['estatura'] ?> m</p>
        <p><strong>Objetivo:</strong> <?= htmlspecialchars($cuestionario['objetivo']) ?></p>

        <hr>

        <h3>Salud y Hábitos</h3>
        <p><strong>Enfermedades:</strong> <?= nl2br(htmlspecialchars($cuestionario['enfermedades'])) ?></p>
        <p><strong>Deporte:</strong> <?= htmlspecialchars($cuestionario['deporte']) ?></p>
        <p><strong>Días por semana:</strong> <?= $cuestionario['diasSemana'] ?></p>
        <p><strong>Horas por día:</strong> <?= $cuestionario['horasDia'] ?></p>
        <p><strong>Tiempo de ejercicio:</strong> <?= htmlspecialchars($cuestionario['tiempoEjercicio']) ?></p>
        <p><strong>Horario de gimnasio:</strong> <?= htmlspecialchars($cuestionario['horarioGym']) ?></p>
        <p><strong>Fuma / Alcohol:</strong> <?= htmlspecialchars($cuestionario['fumaAlcohol']) ?></p>

        <hr>

        <h3>Hábitos Alimenticios</h3>
        <p><strong>Comidas por día:</strong> <?= $cuestionario['comidasDia'] ?></p>
        <p><strong>Hábitos de alimentación:</strong> <?= nl2br(htmlspecialchars($cuestionario['alimentacionHabitos'])) ?></p>
        <p><strong>Comidas disponibles:</strong> <?= htmlspecialchars($cuestionario['comidasDisponibles']) ?></p>

        <p><strong>Alimentos que no le gustan:</strong><br>
            <?= nl2br(htmlspecialchars($cuestionario['alimentosNoGustan'])) ?>
        </p>

        <p><strong>Alimentos difíciles de dejar:</strong><br>
            <?= nl2br(htmlspecialchars($cuestionario['alimentosDificilesDejar'])) ?>
        </p>

        <p><strong>Alimentos disponibles:</strong><br>
            <?= nl2br(htmlspecialchars($cuestionario['alimentosDisponibles'])) ?>
        </p>

        <p><strong>Suplementos:</strong><br>
            <?= nl2br(htmlspecialchars($cuestionario['suplementos'])) ?>
        </p>

        <p><strong>Horario de sueño:</strong><br>
            <?= nl2br(htmlspecialchars($cuestionario['horarioSueno'])) ?>
        </p>

        <div style="margin-top:25px;">
            <a href="index.php?controller=PlanAlimentacion&action=listar">
                <button class="btn-small btn-edit">Volver a la lista</button>
            </a>
        </div>
    </div>

</main>

</body>
</html>
