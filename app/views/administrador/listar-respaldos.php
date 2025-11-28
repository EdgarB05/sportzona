<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restaurar respaldo | Sport Zona</title>
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
            <li><a href="index.php?controller=reportesGraficos&action=index">Reportes en Gráficas</a></li>
            <li><a href="index.php?controller=user&action=backup">Realizar respaldo de la BD</a></li>
            <li><a href="index.php?controller=user&action=listarRespaldos" class="active">Restaurar respaldo</a></li>
        </ul>
    </div>
    <a href="index.php?controller=user&action=logout">
    <button class="btn-logout">Cerrar sesión</button>
    </a>
</aside>

<main class="main">

    <h1>Restaurar respaldo</h1>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="section-card">
        <h2>Respaldos disponibles</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Archivo</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($respaldos as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['nombre']) ?></td>
                    <td><?= $r['fecha'] ?></td>
                    <td>
                        <a href="index.php?controller=user&action=restaurarArchivo&file=<?= $r['ruta'] ?>"
                           class="btn btn-delete"
                           onclick="return confirm('¿Seguro que deseas restaurar este respaldo? Se reemplazará la base de datos completa.');">
                           Restaurar
                        </a>
                        <a href="index.php?controller=user&action=eliminarRespaldo&file=<?= $r['nombre'] ?>"
                            class="btn-danger"
                            onclick="return confirm('¿Eliminar el respaldo <?= $r['nombre'] ?>? Esta acción no se puede deshacer.');">
                            Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</main>

</body>
</html>
