<?php
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: index.php?controller=user&action=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Plan Alimenticio | Sport Zona</title>

    <!-- CSS de cliente -->
    <link rel="stylesheet" href="public/css/horarios-cliente.css?v=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="side-header">
            <h2 class="brand">Sport Zona</h2>

            <button id="toggle-btn" class="toggle-btn" type="button">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <nav class="sidebar-menu">

            <!-- Regresar al dashboard del cliente -->
            <a href="index.php?controller=cliente&action=index" class="menu-item">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Regresar</span>
            </a>

            <!-- Plan Alimenticio activo -->
            <a class="menu-item active">
                <i class="fa-solid fa-utensils"></i>
                <span>Plan alimenticio</span>
            </a>

        </nav>

        <!-- Cerrar sesión -->
        <div class="logout-bar">
            <a href="index.php?controller=user&action=logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Cerrar sesión</span>
            </a>
        </div>

    </aside>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="main-content">

        <h1 class="title horarios-title">
            <i class="fa-solid fa-utensils"></i> Mi Plan de Alimentación
        </h1>

        <p class="subtitle horarios-sub">
            Este es tu cuestionario registrado. Tu entrenador podrá generar un plan personalizado con esta información.
        </p>

        <!-- Tarjeta tipo glass -->
        <div class="horarios-card">
            
            <div class="horarios-header">
                <i class="fa-solid fa-user"></i>
                <h2><?= htmlspecialchars($cuestionario['nombreCompleto']) ?></h2>
            </div>

            <div class="horarios-body">

                <p><strong>Edad:</strong> <?= $cuestionario['edad'] ?></p>
                <p><strong>Peso:</strong> <?= $cuestionario['peso'] ?> kg</p>
                <p><strong>Estatura:</strong> <?= $cuestionario['estatura'] ?> m</p>
                <p><strong>Objetivo:</strong> <?= htmlspecialchars($cuestionario['objetivo']) ?></p>

                <p><strong>Deporte:</strong> <?= htmlspecialchars($cuestionario['deporte']) ?></p>
                <p><strong>Días a la semana:</strong> <?= $cuestionario['diasSemana'] ?></p>
                <p><strong>Horas al día:</strong> <?= $cuestionario['horasDia'] ?></p>
                <p><strong>Tiempo de ejercicio:</strong> <?= $cuestionario['tiempoEjercicio'] ?></p>

                <p><strong>Horario de gimnasio:</strong> <?= htmlspecialchars($cuestionario['horarioGym']) ?></p>
                <p><strong>Fuma o bebe alcohol:</strong> <?= htmlspecialchars($cuestionario['fumaAlcohol']) ?></p>

                <p><strong>Comidas por día:</strong> <?= $cuestionario['comidasDia'] ?></p>
                <p><strong>Hábitos alimenticios:</strong> <?= htmlspecialchars($cuestionario['alimentacionHabitos']) ?></p>
                <p><strong>Comidas disponibles al día:</strong> <?= $cuestionario['comidasDisponibles'] ?></p>

                <p><strong>Alimentos que no le gustan:</strong> <?= htmlspecialchars($cuestionario['alimentosNoGustan']) ?></p>
                <p><strong>Alimentos difíciles de dejar:</strong> <?= htmlspecialchars($cuestionario['alimentosDificilesDejar']) ?></p>
                <p><strong>Alimentos disponibles:</strong> <?= htmlspecialchars($cuestionario['alimentosDisponibles']) ?></p>

                <p><strong>Suplementos:</strong> <?= htmlspecialchars($cuestionario['suplementos']) ?></p>
                <p><strong>Horario de sueño:</strong> <?= htmlspecialchars($cuestionario['horarioSueno']) ?></p>

                <span class="horarios-note">
                    <i class="fa-solid fa-calendar-check"></i>
                    Fecha de registro: <?= $cuestionario['fechaRegistro'] ?>
                </span>
            </div>

        </div>

    </div><!-- /.main-content -->

</div><!-- /.wrapper -->

<!-- JS Sidebar -->
<script>
const sidebar = document.getElementById("sidebar");
const toggleBtn = document.getElementById("toggle-btn");

toggleBtn.addEventListener("click", () => {
    sidebar.classList.toggle("collapsed");
});
</script>

</body>
</html>
