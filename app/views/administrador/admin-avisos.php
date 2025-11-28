<?php
session_start();
if (!isset($_SESSION['id']) || ($_SESSION['rol'] ?? '') !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Avisos | Sport Zona</title>
<link rel="stylesheet" href="public/css/admin-styles.css">
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
  <div>
    <div class="brand">Sport Zona</div>
    <ul class="nav-links">
      <li><a href="index.php?controller=adminhome&action=index">Resumen</a></li>
      <li><a href="index.php?controller=avisos&action=index" class="active">Gestión de avisos</a></li>
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

<!-- Contenido principal -->
<main class="main">
  <div class="topbar">
    <h1>Gestión de avisos</h1>
  </div>

  <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <!-- ====== Formulario ====== -->
  <div class="section-card">
    <h2><?= $avisoEditar ? "Editar aviso #{$avisoEditar['idAviso']}" : "Nuevo aviso" ?></h2>

    <form action="index.php?controller=avisos&action=save" method="post">
      <?php if ($avisoEditar): ?>
        <input type="hidden" name="idAviso" value="<?= $avisoEditar['idAviso'] ?>">
      <?php endif; ?>

      <div>
        <label>Título del aviso</label>
        <input type="text" name="titulo" required value="<?= htmlspecialchars($avisoEditar['titulo'] ?? '') ?>">
      </div>

      <div>
        <label>Audiencia</label>
        <select name="audiencia">
          <?php $aud = $avisoEditar['audiencia'] ?? 'todos'; ?>
          <option value="todos" <?= $aud=='todos'?'selected':'' ?>>Todos</option>
          <option value="nuevos" <?= $aud=='nuevos'?'selected':'' ?>>Nuevos</option>
          <option value="activos" <?= $aud=='activos'?'selected':'' ?>>Activos</option>
          <option value="inactivos" <?= $aud=='inactivos'?'selected':'' ?>>Inactivos</option>
        </select>
      </div>

      <div style="grid-column:1/3;">
        <label>Mensaje</label>
        <textarea name="mensaje" rows="4" required><?= htmlspecialchars($avisoEditar['mensaje'] ?? '') ?></textarea>
      </div>

      <div>
        <label>Etiquetas</label>
        <input type="text" name="etiquetas" value="<?= htmlspecialchars($avisoEditar['etiquetas'] ?? '') ?>" placeholder="#mantenimiento, #promoción">
      </div>

      <div>
        <label>Nivel</label>
        <select name="nivel">
          <?php $niv = $avisoEditar['nivel'] ?? 'informativo'; ?>
          <option value="informativo" <?= $niv=='informativo'?'selected':'' ?>>Informativo</option>
          <option value="importante" <?= $niv=='importante'?'selected':'' ?>>Importante</option>
          <option value="crítico" <?= $niv=='crítico'?'selected':'' ?>>Crítico</option>
        </select>
      </div>

      <div class="actions">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <?php if ($avisoEditar): ?>
          <a href="index.php?controller=avisos&action=index" class="btn btn-secondary">Cancelar</a>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <!-- ====== Tabla de avisos ====== -->
  <div class="section-card">
    <h2>Listado de avisos</h2>

    <!-- Barra de búsqueda -->
    <form class="search-bar" method="GET" action="index.php">
      <input type="hidden" name="controller" value="avisos">
      <input type="hidden" name="action" value="index">
      <input type="text" name="buscar" placeholder="Buscar aviso..." 
             value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>">
      <button type="submit">Buscar</button>

      <?php if (isset($_GET['buscar']) && $_GET['buscar'] !== ''): ?>
        <button type="button" class="btn-return" onclick="window.location.href='index.php?controller=avisos&action=index'">Ver lista completa</button>
      <?php endif; ?>
    </form>

    <div class="table-container">
      <table class="table-avisos">
        <thead>
          <tr><th>#</th><th>Título</th><th>Estado</th><th>Audiencia</th><th>Acciones</th></tr>
        </thead>
        <tbody>
          <?php if (!$avisos): ?>
            <tr><td colspan="5" class="no-data">Sin avisos</td></tr>
          <?php else: foreach ($avisos as $a): ?>
            <tr>
              <td><?= $a['idAviso'] ?></td>
              <td><strong><?= htmlspecialchars($a['titulo']) ?></strong></td>
              <td><span class="badge <?= $a['estado'] ?>"><?= ucfirst($a['estado']) ?></span></td>
              <td><?= ucfirst($a['audiencia']) ?></td>
              <td>
                <a href="index.php?controller=avisos&action=edit&id=<?= $a['idAviso'] ?>" class="btn btn-edit">Editar</a>
                <a href="index.php?controller=avisos&action=delete&id=<?= $a['idAviso'] ?>" class="btn btn-delete" onclick="return confirm('¿Eliminar aviso?')">Eliminar</a>
                <?php if ($a['estado'] !== 'publicado'): ?>
                  <a href="index.php?controller=avisos&action=toggle&id=<?= $a['idAviso'] ?>&estado=publicado">Publicar</a>
                <?php else: ?>
                  <a href="index.php?controller=avisos&action=toggle&id=<?= $a['idAviso'] ?>&estado=borrador">Borrador</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; endif; ?>
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
