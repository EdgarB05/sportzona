<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registrar Administrador</title>
  <link rel="stylesheet" href="public/css/admin-styles.css" />
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
        <li><a href="index.php?controller=user&action=registrar_admin" class="active">Registrar Administrador</a></li>
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
    <div class="topbar"><h1>Registrar Administrador</h1></div>

    <div class="section-card">
      <form class="form-grid" method="POST" action="index.php?controller=user&action=guardar_admin">
        <div class="form-item">
          <label>Nombre completo</label>
          <input type="text" name="nombreAdmin" required />
        </div>

        <div class="form-item">
          <label>Usuario</label>
          <input type="text" name="nomUsuario" required />
        </div>

        <div class="form-item">
          <label>Correo</label>
          <input type="email" name="correoUti" required />
        </div>

        <div class="form-item">
          <label>Contraseña</label>
          <input type="password" name="contraseña" required />
        </div>

        <div class="actions">
          <button type="submit" class="btn btn-primary">Registrar</button>
          <a href="index.php?controller=user&action=consult" class="btn btn-secondary">Cancelar</a>
        </div>
      </form>
    </div>
  </main>
</body>
</html>
