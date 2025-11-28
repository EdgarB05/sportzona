<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id']) || ($_SESSION['rol'] ?? '') !== 'admin') {
    header("Location: index.php?controller=user&action=login");
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Planes de Alimentación - Administrador</title>
    <link rel="stylesheet" href="public/css/admin-styles.css">
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div>
        <div class="brand">Sport Zona</div>
        <ul class="nav-links">
            <li><a href="index.php?controller=adminhome&action=index">Resumen</a></li>
            <li><a href="index.php?controller=avisos&action=index">Gestión de avisos</a></li>
            <li><a href="index.php?controller=promociones&action=index">Gestión de promociones</a></li>
            <li><a href="index.php?controller=user&action=consult">Gestión de usuarios</a></li>
            <li><a href="index.php?controller=membresias&action=index">Gestión de Membresías</a></li>
            <li><a href="index.php?controller=PlanAlimentacion&action=listar" class="active">Gestión de Planes de Alimentación</a></li>
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

<!-- CONTENIDO -->
<main class="main">
    <div class="topbar">
        <h1>Planes de Alimentación</h1>
    </div>

    <div class="table-container">

        <?php if (!empty($cuestionarios)): ?>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Objetivo</th>
                        <th>Peso</th>
                        <th>Estatura</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cuestionarios as $q): ?>
                        <tr>
                            <td><?= $q['idCuestionario'] ?></td>
                            <td><?= htmlspecialchars($q['nombreUsuario']) ?></td>
                            <td><?= htmlspecialchars($q['objetivo']) ?></td>
                            <td><?= number_format($q['peso'], 2) ?> kg</td>
                            <td><?= number_format($q['estatura'], 2) ?> m</td>
                            <td><?= $q['fechaRegistro'] ?></td>
                            <td class="actions">
                                <a href="index.php?controller=PlanAlimentacion&action=eliminar&id=<?= $q['idCuestionario'] ?>"
                                   class="btn-delete"
                                   onclick="return confirm('¿Eliminar este cuestionario?')">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <p class="no-data">No hay planes de alimentación registrados.</p>
        <?php endif; ?>

    </div>
</main>

</body>
</html>
