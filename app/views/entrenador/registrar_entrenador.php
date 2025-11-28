<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registrar Entrenador</title>
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
        <li><a href="index.php?controller=user&action=registrar_admin">Registrar Administrador</a></li>
        <li><a href="index.php?controller=user&action=registrar_entrenador" class="active">Registrar Entrenador</a></li>
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
    <div class="topbar"><h1>Registrar Entrenador</h1></div>

    <div class="section-card">
      <form class="form-grid" method="POST" action="index.php?controller=user&action=guardar_entrenador">
        <div class="form-item">
          <label>Nombre</label>
          <input type="text" name="nombre" required />
        </div>
        <div class="form-item">
          <label>Apellido paterno</label>
          <input type="text" name="apePa" required />
        </div>
        <div class="form-item">
          <label>Apellido materno</label>
          <input type="text" name="apeMa" />
        </div>

        <div class="form-item">
          <label>Género</label>
          <select name="genero" required>
            <option value="">Seleccionar</option>
            <option>Masculino</option>
            <option>Femenino</option>
            <option>Otro</option>
          </select>
        </div>

        <div class="form-item">
          <label>Teléfono</label>
          <input type="text" name="telefono" />
        </div>

        <div class="form-item">
          <label>Correo</label>
          <input type="email" name="correo" required />
        </div>

        <div class="form-item">
          <label>Especialidad</label>
          <input type="text" name="especialidad" placeholder="Fitness, Yoga, Crossfit..." required />
        </div>

        <div class="form-item">
          <label>Contraseña</label>
          <input type="password" name="password" required />
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
