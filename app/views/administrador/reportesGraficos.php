<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reportes Gráficos | Sport Zona</title>
<link rel="stylesheet" href="public/css/admin-styles.css">
</head>
<body>

<aside class="sidebar">
    <div>
        <div class="brand">Sport Zona</div>
        <ul class="nav-links">
            <li><a href="index.php?controller=adminhome&action=index">Resumen</a></li>
            <li><a href="index.php?controller=avisos&action=index">Gestión de avisos</a></li>
            <li><a href="index.php?controller=promociones&action=index">Gestión de promociones</a></li>
            <li><a href="index.php?controller=user&action=consult">Gestión de usuarios</a></li>
            <li><a href="index.php?controller=membresias&action=index">Gestión de Membresías</a></li>
            <li><a href="index.php?controller=PlanAlimentacion&action=listar">Gestión de Planes de Alimentación</a></li>
            <li><a href="index.php?controller=user&action=registrar_admin">Registrar Administrador</a></li>
            <li><a href="index.php?controller=user&action=registrar_entrenador">Registrar Entrenador</a></li>
            <li><a href="index.php?controller=reportes&action=index">Reportes Generales</a></li>
            <li><a href="index.php?controller=reportesGraficos&action=index" class="active">Reportes en Gráficas</a></li>
            <li><a href="index.php?controller=user&action=backup">Realizar respaldo de la BD</a></li>
            <li><a href="index.php?controller=user&action=listarRespaldos">Restaurar respaldo</a></li>
        </ul>
    </div>
    <a href="index.php?controller=user&action=logout">
    <button class="btn-logout">Cerrar sesión</button>
    </a>
</aside>

<main class="main">
    <div class="topbar">
        <h1>Reportes Gráficos</h1>
    </div>

    <section class="section-card">
        <h2>Generar Reportes con Gráficas</h2>
        <p>Se generará un PDF con gráfica de pastel y gráfica de barras.</p>

        <a class="btn-primary" href="index.php?controller=reportesGraficos&action=graficas">
            Generar PDF de Gráficas
        </a>
    </section>
</main>

</body>
</html>
