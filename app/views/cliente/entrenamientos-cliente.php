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
    <title>Entrenamientos | Sport Zona</title>

    <!-- CSS Premium (sidebar y layout) -->
    <link rel="stylesheet" href="public/css/horarios-cliente.css?v=4">

    <!-- CSS de diseño premium para ejercicios -->
    <link rel="stylesheet" href="public/css/ejercicioscliente.css?v=3">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<div class="wrapper">

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar" id="sidebar">

        <div class="side-header">
            <h2 class="brand">Sport Zona</h2>
        </div>

        <nav class="sidebar-menu">

            <a href="index.php?controller=cliente&action=index" class="menu-item">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Regresar</span>
            </a>

            <a href="#" class="menu-item active">
                <i class="fa-solid fa-dumbbell"></i>
                <span>Entrenamientos</span>
            </a>

        </nav>

        <div class="logout-bar">
            <a href="index.php?controller=user&action=logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Cerrar sesión</span>
            </a>
        </div>

    </aside>

    <!-- ===== CONTENIDO ===== -->
    <div class="main-content">

        <h1 class="title exercise-title">
            <i class="fa-solid fa-dumbbell"></i>
            Rutinas Generales
        </h1>

        <p class="exercise-sub">
            Rutinas activadas por tu coach.
        </p>

        <!-- ===== BARRA DE BÚSQUEDA PREMIUM ===== -->
        <form method="GET" action="index.php" style="max-width: 450px; margin-bottom: 25px;">
            <input type="hidden" name="controller" value="entrenamientos">
            <input type="hidden" name="action" value="publicList">

            <div style="
                display: flex;
                gap: 10px;
                background: rgba(255,255,255,0.5);
                padding: 12px;
                border-radius: 12px;
                box-shadow: 0 4px 14px rgba(0,0,0,0.12);
                backdrop-filter: blur(10px);
            ">
                <input 
                    type="text" 
                    name="buscar" 
                    placeholder="Buscar ejercicio..." 
                    value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>"
                    style="
                        flex: 1;
                        border: none;
                        outline: none;
                        background: transparent;
                        font-size: 15px;
                    "
                >
                <button 
                    type="submit" 
                    style="
                        background: #4f6cff;
                        border: none;
                        padding: 10px 18px;
                        border-radius: 8px;
                        color: white;
                        cursor: pointer;
                        font-weight: 600;
                    "
                >
                    Buscar
                </button>
            </div>
        </form>
        <!-- ===== FIN BUSCADOR ===== -->


        <!-- ===== LISTA DE RUTINAS ===== -->
        <?php if (!empty($entrenamientos)): ?>
            <?php foreach ($entrenamientos as $e): ?>

                <div class="exercise-card">
                    <h3><?= htmlspecialchars($e['nombreRutina']) ?></h3>

                    <p class="exercise-meta">
                        Dificultad: <strong><?= htmlspecialchars($e['dificultad']) ?></strong> · 
                        Coach: <?= htmlspecialchars($e['nombreCoach']) ?>
                    </p>

                    <p class="exercise-desc">
                        <?= nl2br(htmlspecialchars($e['descripcionEje'])) ?>
                    </p>
                </div>

            <?php endforeach; ?>
        <?php else: ?>

            <p>No hay rutinas disponibles actualmente.</p>

        <?php endif; ?>

    </div>

</div>

</body>
</html>
