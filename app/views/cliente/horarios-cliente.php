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
    <title>Horarios | Sport Zona</title>

    <!-- CSS ESPECÍFICO DE HORARIOS -->
    <link rel="stylesheet" href="public/css/horarios-cliente.css?v=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR (el mismo que ya te gusta) -->
    <aside class="sidebar" id="sidebar">

        <div class="side-header">
            <h2 class="brand">Sport Zona</h2>

            <!-- Botón dentro del sidebar -->
        </div>

        <nav class="sidebar-menu">
            <a href="index.php?controller=cliente&action=index" class="menu-item">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Regresar</span>
            </a>

            <a href="index.php?controller=cliente&action=horarios" class="menu-item active">
                <i class="fa-solid fa-clock"></i>
                <span>Horarios</span>
            </a>
        </nav>

        <!-- Barra inferior de cerrar sesión -->
        <div class="logout-bar">
            <a href="index.php?controller=user&action=logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Cerrar sesión</span>
            </a>
        </div>

    </aside>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="main-content sidebar-push">

        <h1 class="title horarios-title">
            <i class="fa-solid fa-clock"></i> Horarios
        </h1>
        <p class="subtitle horarios-sub">
            Conoce los horarios de atención del gimnasio.
        </p>

        <!-- Tarjeta premium de horarios -->
        <div class="horarios-card">
            <div class="horarios-header">
                <i class="fa-solid fa-dumbbell"></i>
                <h2>Horarios generales</h2>
            </div>

            <div class="horarios-body">
                <p><strong>Lunes a viernes:</strong> 6:00 am – 9:30 pm</p>
                <p><strong>Sábado:</strong> 7:00 am – 1:00 pm</p>

                <span class="horarios-note">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    Domingos y días festivos el gimnasio permanece cerrado.
                </span>
            </div>
        </div>

    </div><!-- /.main-content -->

</div><!-- /.wrapper -->

<!-- JS para colapsar/expandir sidebar -->
<script>
const sidebar = document.getElementById("sidebar");
const toggleBtn = document.getElementById("toggle-btn");

toggleBtn.addEventListener("click", () => {
    sidebar.classList.toggle("collapsed");
});
</script>



</body>
</html>
