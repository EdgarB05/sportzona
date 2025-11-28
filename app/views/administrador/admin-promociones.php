<?php
  $promocion = $promocion ?? null; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Promociones</title>
<link rel="stylesheet" href="public/css/admin-styles.css">
</head>
<body>

<aside class="sidebar">
  <div>
    <div class="brand">Sport Zona</div>
    <ul class="nav-links">
      <li><a href="index.php?controller=adminhome&action=index">Resumen</a></li>
      <li><a href="index.php?controller=avisos&action=index">Gestión de avisos</a></li>
      <li><a href="index.php?controller=promociones&action=index" class="active">Gestión de promociones</a></li>
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

<main class="main">
  <div class="topbar"><h1>Gestión de promociones</h1></div>
  <?php if (!empty($_SESSION['success'])): ?>
  <div class="alert alert-success">
    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
  </div>
  <?php endif; ?>

  <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-error">
      <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
  <?php endif; ?>



  <!-- Formulario -->
  <div class="section-card">
    <h2><?= $promocion ? "Editar promoción #{$promocion['idPromocion']}" : "Nueva promoción" ?></h2>

    <form action="index.php?controller=promociones&action=save" method="post">
      <?php if ($promocion): ?>
        <input type="hidden" name="idPromocion" value="<?= $promocion['idPromocion'] ?>">
      <?php endif; ?>

      <label>Título de la promoción</label>
      <input type="text" name="nombrePromo" required value="<?= htmlspecialchars($promocion['nombrePromo'] ?? '') ?>">

      <label>Descripción</label>
      <textarea name="descripcionPromo" rows="4"><?= htmlspecialchars($promocion['descripcionPromo'] ?? '') ?></textarea>

      <label>Tipo</label>
      <select name="tipoPromo">
        <?php $tipo = $promocion['tipoPromo'] ?? 'descuento'; ?>
        <option value="descuento" <?= $tipo == 'descuento' ? 'selected' : '' ?>>Descuento</option>
        <option value="2x1" <?= $tipo == '2x1' ? 'selected' : '' ?>>2x1</option>
        <option value="invitacion" <?= $tipo == 'invitacion' ? 'selected' : '' ?>>Invitación</option>
        <option value="otro" <?= $tipo == 'otro' ? 'selected' : '' ?>>Otro</option>
      </select>

      <label>Vigencia</label>
      <div style="display:flex;gap:1rem;">
        <input type="date" name="fechaInicio" required value="<?= $promocion['fechaInicio'] ?? '' ?>">
        <input type="date" name="fechaFin" required value="<?= $promocion['fechaFin'] ?? '' ?>">
      </div>

      <label>Etiquetas</label>
      <input type="text" name="etiquetas" placeholder="#verano, #descuento" value="<?= htmlspecialchars($promocion['etiquetas'] ?? '') ?>">

      <label>Estado</label>
      <?php $estado = $promocion['estadoAct'] ?? 'borrador'; ?>
      <select name="estadoAct">
        <option value="borrador" <?= $estado == 'borrador' ? 'selected' : '' ?>>Borrador</option>
        <option value="activo" <?= $estado == 'activo' ? 'selected' : '' ?>>Activo</option>
        <option value="expirado" <?= $estado == 'expirado' ? 'selected' : '' ?>>Expirado</option>
      </select>

      <div class="actions" style="display:flex;gap:1rem;">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <?php if ($promocion): ?>
          <a href="index.php?controller=promociones&action=index" class="btn btn-secondary">Cancelar</a>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <!-- Listado -->
  <div class="section-card">
    <h2>Listado de promociones</h2>

    <!-- Barra de búsqueda -->
    <form class="search-bar" method="GET" action="index.php">
      <input type="hidden" name="controller" value="promociones">
      <input type="hidden" name="action" value="index">
      <input type="text" name="buscar" placeholder="Buscar promoción..."
             value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>">
      <button type="submit">Buscar</button>

      <?php if (isset($_GET['buscar']) && $_GET['buscar'] !== ''): ?>
        <button type="button" class="btn-return" onclick="window.location.href='index.php?controller=promociones&action=index'">
          Ver lista completa
        </button>
      <?php endif; ?>
    </form>

    <div class="table-container">
      <table class="table-promociones">
        <thead>
          <tr><th>#</th><th>Título</th><th>Tipo</th><th>Estado</th><th>Vigencia</th><th>Acciones</th></tr>
        </thead>
        <tbody>
          <?php if (!$promociones): ?>
            <tr><td colspan="6" class="no-data">Sin promociones</td></tr>
          <?php else: foreach ($promociones as $p): ?>
            <tr>
              <td><?= $p['idPromocion'] ?></td>
              <td><?= htmlspecialchars($p['nombrePromo']) ?></td>
              <td><?= ucfirst($p['tipoPromo']) ?></td>
              <td><span class="badge <?= $p['estadoAct'] ?>"><?= ucfirst($p['estadoAct']) ?></span></td>
              <td><?= date('d M', strtotime($p['fechaInicio'])) ?> – <?= date('d M', strtotime($p['fechaFin'])) ?></td>
              <td>
                <a href="index.php?controller=promociones&action=edit&id=<?= $p['idPromocion'] ?>" class="btn btn-edit">Editar</a>
                <a href="index.php?controller=promociones&action=delete&id=<?= $p['idPromocion'] ?>" class="btn btn-delete" onclick="return confirm('¿Eliminar promoción?')">Eliminar</a>
                <?php if ($p['estadoAct'] !== 'activo'): ?>
                  <a href="index.php?controller=promociones&action=toggle&id=<?= $p['idPromocion'] ?>&estado=activo">Publicar</a>
                <?php else: ?>
                  <a href="index.php?controller=promociones&action=toggle&id=<?= $p['idPromocion'] ?>&estado=borrador">Borrador</a>
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
