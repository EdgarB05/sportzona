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
    <title>Mi Membresía | Sport Zona</title>

    <!-- CSS -->
    <link rel="stylesheet" href="public/css/membresia-cliente.css?v=31">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="side-header">
            <h2 class="brand">Sport Zona</h2>
        </div>

        <nav class="sidebar-menu">
            <a href="index.php?controller=cliente&action=index" class="menu-item">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Regresar</span>
            </a>

            <a href="index.php?controller=PlanAlimentacion&action=clienteFormulario"
               class="menu-item active">
                <i class="fa-solid fa-bowl-food"></i>
                <span>Plan alimenticio</span>
            </a>
        </nav>

        <div class="logout-bar">
            <a href="index.php?controller=user&action=logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Cerrar sesión</span>
            </a>
        </div>
    </aside>


    <!-- CONTENIDO -->
    <div class="main-content">

        <h1 class="title">
        <i class="fa-solid fa-id-card" style="color:#4f6cff;"></i> Mi Membresía
        </h1>
        <br><br>
        <p class="subtitle">Información actual de tu plan activo</p>

        <?php if (!empty($membresia)):
            $fechaFin = new DateTime($membresia['fechaFin']);
            $hoy = new DateTime();
            $diasRestantes = $hoy->diff($fechaFin)->days;
            $expirada = $fechaFin < $hoy;
        ?>
            <div class="dias-widget <?= $expirada ? 'expirada' : '' ?>">
                <h3><?= $expirada ? "Tu membresía ha expirado" : "Días restantes" ?></h3>
                <p class="dias-num"><?= $expirada ? "0" : $diasRestantes ?></p>
            </div>
        <?php endif; ?>

        <div class="membresia-aviso">
            <?php if (empty($membresia)): ?>
                <p class="empty-msg">No tienes una membresía activa actualmente.</p>
            <?php else: ?>
                <p><strong>Inicio:</strong> <?= htmlspecialchars($membresia['fechaInicio']); ?></p>
                <p><strong>Fin:</strong> <?= htmlspecialchars($membresia['fechaFin']); ?></p>
                <p><strong>Estado:</strong> <?= $membresia['estado'] == 'activa' ? 'Activa' : 'Expirada'; ?></p>
            <?php endif; ?>
        </div>

    </div>

</div>

</body>
</html>
