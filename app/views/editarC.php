<?php
// $usuario viene desde el controlador
if (!$usuario) {
    echo "Usuario no encontrado.";
    return;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar usuario</title>
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
        <h1>Editar usuario: <?= htmlspecialchars($usuario['nombre']) ?></h1>
    </div>

    <div class="section-card">
        <form method="POST" action="index.php?controller=user&action=update">
            <input type="hidden" name="idUsuario" value="<?= (int)$usuario['idUsuario'] ?>">

            <div class="full-width">
                <label>Nombre</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
            </div>

            <div>
                <label>Apellido paterno</label>
                <input type="text" name="apePa" value="<?= htmlspecialchars($usuario['apePa']) ?>" required>
            </div>

            <div>
                <label>Apellido materno</label>
                <input type="text" name="apeMa" value="<?= htmlspecialchars($usuario['apeMa']) ?>" required>
            </div>

            <div>
                <label>Género</label>
                <select name="genero">
                    <?php $g = $usuario['genero'] ?? ''; ?>
                    <option value="">Selecciona una opción</option>
                    <option value="Masculino" <?= $g=='Masculino'?'selected':'' ?>>Masculino</option>
                    <option value="Femenino"  <?= $g=='Femenino'?'selected':'' ?>>Femenino</option>
                    <option value="Otro"      <?= $g=='Otro'?'selected':'' ?>>Otro</option>
                </select>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="index.php?controller=user&action=consult" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</main>
<script>
// Detectar formularios de edición con botones de tipo submit
document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll("form").forEach(form => {

        form.addEventListener("submit", function(e) {

            // Detecta si el formulario es de edición
            let isEdit =
                this.querySelector("button[type='submit'][name*='edit']") ||
                this.querySelector("button[type='submit'][value*='editar']") ||
                this.querySelector("button[type='submit'][class*='edit']") ||
                this.querySelector("button[type='submit'][class*='guardar']") ||
                this.action.includes("edit") ||
                this.action.includes("update") ||
                this.action.includes("save");

            if (isEdit) {
                const confirmar = confirm("¿Seguro que deseas guardar los cambios?");
                if (!confirmar) {
                    e.preventDefault();
                }
            }
        });
    });

});
</script>

</body>
</html>
