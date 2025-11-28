<?php

  $membresiaEditar = $membresiaEditar ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Membresías | Sport Zona</title>
<link rel="stylesheet" href="public/css/admin-styles.css">
</head>
<body>

<!-- Sidebar reutilizando tu estilo negro/gris -->
<aside class="sidebar">
  <div>
    <div class="brand">Sport Zona</div>
    <ul class="nav-links">
      <li><a href="index.php?controller=adminhome&action=index">Resumen</a></li>
      <li><a href="index.php?controller=avisos&action=index">Gestión de avisos</a></li>
      <li><a href="index.php?controller=promociones&action=index">Gestión de promociones</a></li>
      <li><a href="index.php?controller=user&action=consult">Gestión de usuarios</a></li>
      <li><a href="index.php?controller=membresias&action=index" class="active">Gestión de Membresías</a></li>
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
    <h1>Gestión de Membresías</h1>
  </div>

  <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <div style="margin-bottom: 15px; text-align:right;">
      <a href="index.php?controller=membresias&action=enviarRecordatorios" 
        class="btn btn-warning"
        style="padding:10px 15px; background:#fbbc04; color:black; border-radius:6px; text-decoration:none;">
          Enviar recordatorios ahora
      </a>
  </div>


  <!-- =================== FORMULARIO NUEVA / EDITAR =================== -->
  <div class="section-card">
    <h2>
      <?= $membresiaEditar ? "Editar membresía #{$membresiaEditar['idMembresia']}" : "Nueva membresía" ?>
    </h2>

    <form action="index.php?controller=membresias&action=save" method="post" class="form-grid">

      <?php if ($membresiaEditar): ?>
        <input type="hidden" name="idMembresia" value="<?= $membresiaEditar['idMembresia'] ?>">
      <?php endif; ?>

      <!-- Usuario -->
      <div>
        <label>Usuario</label>
        <select name="idUsuario" required>
          <option value="">Seleccionar usuario...</option>
          <?php while($u = $usuarios->fetch_assoc()): 
                $sel = $membresiaEditar && $membresiaEditar['idUsuario'] == $u['idUsuario'] ? 'selected' : '';
          ?>
            <option value="<?= $u['idUsuario'] ?>" <?= $sel ?>>
              <?= htmlspecialchars($u['nombre'] . ' ' . $u['apePa'] . ' ' . $u['apeMa']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <!-- Tipo de Membresía -->
      <div>
        <label>Tipo de membresía</label>
        <select name="idTipoMembresia" required>
          <option value="">Seleccionar tipo...</option>
          <?php while($t = $tipos->fetch_assoc()):
                $sel = $membresiaEditar && $membresiaEditar['idTipoMembresia'] == $t['idTipoMembresia'] ? 'selected' : '';
          ?>
            <option value="<?= $t['idTipoMembresia'] ?>" <?= $sel ?>>
              <?= htmlspecialchars($t['nombre']) ?> (<?= $t['duracion_meses'] ?> mes<?= $t['duracion_meses']>1?'es':'' ?>)
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <!-- Fecha inicio -->
      <div>
        <label>Fecha de inicio</label>
        <input type="date" name="fechaInicio"
               value="<?= $membresiaEditar['fechaInicio'] ?? date('Y-m-d') ?>" required>
      </div>

      <!-- Estado -->
      <div>
        <label>Estado</label>
        <?php $estado = $membresiaEditar['estado'] ?? 'activa'; ?>
        <select name="estado">
          <option value="activa"   <?= $estado=='activa'?'selected':'' ?>>Activa</option>
          <option value="inactiva" <?= $estado=='inactiva'?'selected':'' ?>>Inactiva</option>
          <option value="vencida"  <?= $estado=='vencida'?'selected':'' ?>>Vencida</option>
        </select>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <?php if ($membresiaEditar): ?>
          <a href="index.php?controller=membresias&action=index" class="btn btn-secondary">Cancelar</a>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <!-- =================== LISTADO + BUSCADOR =================== -->
  <div class="section-card">
    <div class="section-header">
      <h2>Listado de membresías</h2>
      <form class="search-bar" method="GET" action="index.php">
        <input type="hidden" name="controller" value="membresias">
        <input type="hidden" name="action" value="index">
        <input type="text" name="buscar" placeholder="Buscar por usuario o tipo..."
               value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>">
        <button type="submit">Buscar</button>
      </form>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Usuario</th>
            <th>Tipo</th>
            <th>Fecha inicio</th>
            <th>Fecha fin</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($membresias && $membresias->num_rows > 0): ?>
          <?php while($m = $membresias->fetch_assoc()): ?>
            <tr>
              <td><?= $m['idMembresia'] ?></td>
              <td><?= htmlspecialchars($m['nombreUsuario'] . ' ' . $m['apePa'] . ' ' . $m['apeMa']) ?></td>
              <td><?= htmlspecialchars($m['tipoNombre']) ?></td>
              <td><?= htmlspecialchars($m['fechaInicio']) ?></td>
              <td><?= htmlspecialchars($m['fechaFin']) ?></td>
              <td>
                <span class="badge <?= $m['estado'] ?>">
                  <?= ucfirst($m['estado']) ?>
                </span>
              </td>
              <td>
                <a href="index.php?controller=membresias&action=edit&id=<?= $m['idMembresia'] ?>" class="btn btn-edit">Editar</a>
                <a href="index.php?controller=membresias&action=delete&id=<?= $m['idMembresia'] ?>"
                   class="btn btn-delete"
                   onclick="return confirm('¿Eliminar esta membresía?')">Eliminar</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7" class="no-data">No se encontraron membresías.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
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
