<?php
$usuarios = $usuarios ?? [];
$buscar   = $buscar   ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestión de Usuarios | Sport Zona</title>
<link rel="stylesheet" href="public/css/admin-styles.css">
</head>
<body>
<!-- Sidebar -->
<aside class="sidebar">
    <div>
        <div class="brand">Sport Zona</div>
        <ul class="nav-links">
            <li><a href="index.php?controller=adminhome&action=index">Resumen</a></li>
            <li><a href="index.php?controller=avisos&action=index">Gestión de avisos</a></li>
            <li><a href="index.php?controller=promociones&action=index">Gestión de promociones</a></li>
            <li><a href="index.php?controller=user&action=consult" class="active">Gestión de usuarios</a></li>
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

<main class="main">
    <div class="topbar">
        <h1>Gestión de Usuarios</h1>
    </div>

    <div class="section-card">
        <!-- Barra de búsqueda -->
        <form class="search-bar" method="GET" action="index.php">
            <input type="hidden" name="controller" value="user">
            <input type="hidden" name="action" value="consult">

            <input type="text" name="buscar" placeholder="Buscar usuario..." 
                   value="<?= htmlspecialchars($buscar) ?>">
            <button type="submit">Buscar</button>

            <?php if ($buscar !== ''): ?>
                <button type="button" class="btn-return"
                        onclick="window.location.href='index.php?controller=user&action=consult'">
                    Ver lista completa
                </button>
            <?php endif; ?>
        </form>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>


        <div class="table-container">
            <table class="table-usuarios">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nombre'].' '.$row['apePa'].' '.$row['apeMa']) ?></td>
                            <td><?= htmlspecialchars($row['correo']) ?></td>
                            <td><span class="badge role"><?= ucfirst($row['rol'] ?? 'miembro') ?></span></td>
                            <td>
                                <?php 
                                    $estado = strtolower($row['estado'] ?? 'activo');
                                    $clase  = $estado === 'pendiente' ? 'badge-warning' : 'badge-success';
                                ?>
                                <span class="badge <?= $clase ?>"><?= ucfirst($estado) ?></span>
                            </td>
                            <td>
                                <a href="index.php?controller=user&action=edit&id=<?= $row['idUsuario'] ?>" class="btn btn-edit">
                                    Editar
                                </a>
                                <button type="button" class="btn btn-delete"
                                        onclick="confirmarEliminacion(<?= $row['idUsuario'] ?>)">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="no-data">No se encontraron usuarios.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
function confirmarEliminacion(id){
    if (confirm('¿Estás seguro que deseas eliminar este usuario?')) {
        window.location.href = 'index.php?controller=user&action=delete&id=' + id;
    }
}
</script>

</body>
</html>
