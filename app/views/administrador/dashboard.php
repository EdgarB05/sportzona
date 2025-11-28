<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.php?controller=user&action=login');
    exit();
}

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel de Administración | Sport Zona</title>
<link rel="stylesheet" href="public/css/admin-dashboard.css">
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div>
    <div class="brand">Sport Zona</div>
    <ul class="nav-links">
      <li><a href="index.php?controller=adminhome&action=index" class="active">Resumen</a></li>
      <li><a href="index.php?controller=avisos&action=index">Gestión de avisos</a></li>
      <li><a href="index.php?controller=promociones&action=index">Gestión de promociones</a></li>
      <li><a href="index.php?controller=user&action=consult">Gestión de usuarios</a></li>
      <li><a href="index.php?controller=membresias&action=index">Gestión de Membresías</a></li>
      <li><a href="index.php?controller=PlanAlimentacion&action=listar">Gestión de Planes de Alimentación</a></li>
      <li><a href="index.php?controller=user&action=registrar_admin">Registrar Administrador</a></li>
      <li><a href="index.php?controller=user&action=registrar_entrenador">Registrar Entrenador</a></li>
      <li><a href="index.php?controller=reportes&action=index">Reportes Generales</a></li>
      <li><a href="index.php?controller=reportesGraficos&action=index">Reportes en Gráficas</a></li>
      <li><a href="index.php?controller=user&action=backup">Realizar respaldo de la BD</a></li>
      <li><a href="index.php?controller=user&action=listarRespaldos">Restaurar respaldo</a></li>
    </ul>
  </div>
    <a href="index.php?controller=user&action=logout">
    <button class="btn-logout">Cerrar sesión</button>
    </a>
</aside>

<!-- MAIN -->
<main class="main">

    <div class="topbar">
        <h1>Panel del Administrador</h1>
        <p>Bienvenido, <strong><?= htmlspecialchars($_SESSION['nombre']); ?></strong></p>
    </div>

    <section class="stats-grid">

        <div class="card stat">
            <h3>Total de Usuarios</h3>
            <p class="stat-number"><?= $usuarios ?></p>
            <span class="stat-sub">Registrados actualmente</span>
        </div>

        <div class="card stat">
            <h3>Avisos Publicados</h3>
            <p class="stat-number"><?= $avisos ?></p>
            <span class="stat-sub">Activos actualmente</span>
        </div>

        <div class="card stat">
            <h3>Promociones Activas</h3>
            <p class="stat-number"><?= $promos ?></p>
            <span class="stat-sub">Vigentes este mes</span>
        </div>

    </section>

        <!-- ===== MINI-GRÁFICAS EN HORIZONTAL ===== -->
    <section class="mini-graphs"
             style="display:flex;flex-wrap:wrap;gap:24px;margin-top:24px;align-items:flex-start;">

        <!-- Usuarios por género -->
        <div style="
            flex:1 1 220px;
            background:#ffffff;
            border-radius:16px;
            padding:16px 20px;
            box-shadow:0 4px 12px rgba(15,23,42,0.06);
        ">
            <h3 style="font-size:14px;margin:0 0 8px;color:#0f172a;">Usuarios por Género</h3>
            <img src="public/media/graphs/pastel-mini.png"
                 alt="Gráfica de Género"
                 style="display:block;max-width:100%;height:auto;margin:0 auto;">
        </div>

        <!-- Avisos por estado -->
        <div style="
            flex:1 1 220px;
            background:#ffffff;
            border-radius:16px;
            padding:16px 20px;
            box-shadow:0 4px 12px rgba(15,23,42,0.06);
        ">
            <h3 style="font-size:14px;margin:0 0 8px;color:#0f172a;">Avisos por Estado</h3>
            <img src="public/media/graphs/avisos-mini.png"
                 alt="Gráfica de Avisos"
                 style="display:block;max-width:100%;height:auto;margin:0 auto;">
        </div>

        <!-- Membresías por estado -->
        <div style="
            flex:1 1 220px;
            background:#ffffff;
            border-radius:16px;
            padding:16px 20px;
            box-shadow:0 4px 12px rgba(15,23,42,0.06);
        ">
            <h3 style="font-size:14px;margin:0 0 8px;color:#0f172a;">Membresías por Estado</h3>
            <img src="public/media/graphs/membresias-mini.png"
                 alt="Gráfica de Membresías"
                 style="display:block;max-width:100%;height:auto;margin:0 auto;">
        </div>

        <!-- Promociones activas vs inactivas -->
        <div style="
            flex:1 1 220px;
            background:#ffffff;
            border-radius:16px;
            padding:16px 20px;
            box-shadow:0 4px 12px rgba(15,23,42,0.06);
        ">
            <h3 style="font-size:14px;margin:0 0 8px;color:#0f172a;">Promociones Activas vs Inactivas</h3>
            <img src="public/media/graphs/promos-mini.png"
                 alt="Gráfica de Promociones"
                 style="display:block;max-width:100%;height:auto;margin:0 auto;">
        </div>

    </section>


</main>

</body>
</html>
