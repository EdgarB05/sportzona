<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: index.php?controller=user&action=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agendar Cita | Sport Zona</title>

    <!-- ESTILOS DEL PANEL DEL CLIENTE -->
    <link rel="stylesheet" href="public/css/horarios-cliente.css?v=1">
    <link rel="stylesheet" href="public/css/citas-dashboard.css?v=2">

    <!-- ICONOS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>

<div class="wrapper">

    <!-- ========== SIDEBAR PREMIUM ========== -->
    <aside class="sidebar" id="sidebar">

        <div class="side-header">
            <h2 class="brand">Sport Zona</h2>

        </div>

        <nav class="sidebar-menu">

            <!-- REGRESAR -->
            <a href="index.php?controller=cliente&action=index" class="menu-item">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Regresar</span>
            </a>

            <!-- AGENDAR CITA ACTIVO -->
            <a href="index.php?controller=citas&action=agendar" class="menu-item active">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Agendar cita</span>
            </a>

        </nav>

        <!-- Cerrar sesión -->
        <div class="logout-bar">
            <a href="index.php?controller=user&action=logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Cerrar sesión</span>
            </a>
        </div>

    </aside>


    <!-- ========== CONTENIDO PRINCIPAL ========== -->
    <div class="main-content">

        <h1 class="title horarios-title">
            <i class="fa-solid fa-calendar-check"></i> Agendar Cita
        </h1>
        <p class="subtitle horarios-sub">
            Programa una visita con tu entrenador.
        </p>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <!-- CONTENEDOR FORM + RESUMEN -->
        <div class="citas-grid">

            <!-- === FORMULARIO === -->
            <section class="horarios-card">
                <div class="horarios-header">
                    <i class="fa-solid fa-pen"></i>
                    <h2>Agendar una cita</h2>
                </div>

                <form method="POST" action="index.php?controller=citas&action=guardar" class="cita-form-grid">

                    <div class="form-group full">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" class="form-control"
                               value="<?= htmlspecialchars($_SESSION['nombre']); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fechaCita" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Hora</label>
                        <input type="time" name="horaCita" class="form-control" required>
                    </div>

                    <div class="form-group full">
                        <label class="form-label">Motivo de la cita</label>
                        <textarea name="motivo" class="textarea-control" rows="3" required
                                  placeholder="Ej. Evaluación física, visita guiada, plan personalizado..."></textarea>
                    </div>

                    <!-- BOTONES PREMIUM -->
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-check"></i> Confirmar cita
                        </button>

                        <a href="index.php?controller=citas&action=listaCliente" class="btn-secondary">
                            <i class="fa-solid fa-xmark"></i> Cancelar
                        </a>
                    </div>
                </form>
            </section>

            <!-- === RESUMEN === -->
            <section class="horarios-card">
                <div class="horarios-header">
                    <i class="fa-solid fa-list"></i>
                    <h2>Resumen de tus citas</h2>
                </div>

                <?php if (!empty($citas)): ?>
                    <div class="table-section">
                        <table class="citas-table">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($citas as $c): ?>
                                <tr>
                                    <td><?= htmlspecialchars($c['fecha']) ?></td>
                                    <td><?= htmlspecialchars(substr($c['hora'], 0, 5)) ?></td>
                                    <td><?= htmlspecialchars($c['motivo']) ?></td>
                                    <td>
                                        <?php
                                        $estado = strtolower($c['estado']);
                                        $badgeClass = 'badge-pendiente';
                                        if ($estado === 'confirmada') $badgeClass = 'badge-confirmada';
                                        if ($estado === 'cancelada')  $badgeClass = 'badge-cancelada';
                                        ?>
                                        <span class="badge <?= $badgeClass ?>">
                                            <?= ucfirst($estado) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php else: ?>
                    <p class="no-citas-text">Aún no tienes citas registradas.</p>
                <?php endif; ?>
            </section>

        </div>

    </div> <!-- END MAIN -->

</div> <!-- END WRAPPER -->

<!-- JS Sidebar -->
<script>
const sidebar = document.getElementById("sidebar");
const toggleBtn = document.getElementById("toggle-btn");
toggleBtn.addEventListener("click", () => {
    sidebar.classList.toggle("collapsed");
});
</script>

</body>
</html>
