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
    <title>Mis citas | Sport Zona</title>

    <!-- Reutiliza tu CSS de cliente (el que uses en membresía) -->
    <link rel="stylesheet" href="public/css/membresia-cliente.css?v=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="wrapper">

    <!-- SIDEBAR CLIENTE -->
    <aside class="sidebar" id="sidebar">

        <div class="side-header">
            <h2 class="brand">Sport Zona</h2>

            <button id="toggle-btn" class="toggle-btn" type="button">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <nav class="sidebar-menu">
            <a href="index.php?controller=cliente&action=index" class="menu-item">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Regresar</span>
            </a>

            <a href="index.php?controller=citas&action=listaCliente" class="menu-item active">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Mis citas</span>
            </a>

            <a href="index.php?controller=citas&action=agendar" class="menu-item">
                <i class="fa-solid fa-plus"></i>
                <span>Agendar nueva</span>
            </a>
        </nav>

        <div class="logout-bar">
            <a href="index.php?controller=user&action=logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Cerrar sesión</span>
            </a>
        </div>
    </aside>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="main-content">

        <h1 class="title">Mis citas</h1>
        <p class="subtitle">Consulta el estado de tus citas agendadas.</p>

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

        <?php if (!empty($citas)): ?>
            <div class="membresia-aviso" style="max-width: 900px;">
                <table style="width:100%; border-collapse:collapse; background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 6px 20px rgba(0,0,0,.12);">
                    <thead>
                        <tr style="background:#f4f4ff; text-align:left;">
                            <th style="padding:10px 14px;">Fecha</th>
                            <th style="padding:10px 14px;">Hora</th>
                            <th style="padding:10px 14px;">Motivo</th>
                            <th style="padding:10px 14px;">Estado</th>
                            <th style="padding:10px 14px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($citas as $c): ?>
                            <tr>
                                <td style="padding:10px 14px; border-top:1px solid #eee;">
                                    <?= htmlspecialchars($c['fecha']) ?>
                                </td>
                                <td style="padding:10px 14px; border-top:1px solid #eee;">
                                    <?= htmlspecialchars(substr($c['hora'],0,5)) ?>
                                </td>
                                <td style="padding:10px 14px; border-top:1px solid #eee;">
                                    <?= htmlspecialchars($c['motivo']) ?>
                                </td>
                                <td style="padding:10px 14px; border-top:1px solid #eee;">
                                    <?php
                                        $estado = $c['estado'];
                                        $color  = [
                                            'pendiente'  => '#f5a623',
                                            'confirmada' => '#21ba45',
                                            'rechazada'  => '#db2828',
                                            'cancelada'  => '#767676',
                                        ][$estado] ?? '#555';
                                    ?>
                                    <span style="
                                        padding:4px 10px;
                                        border-radius:999px;
                                        font-size:12px;
                                        color:#fff;
                                        background:<?= $color ?>;
                                    ">
                                        <?= ucfirst($estado) ?>
                                    </span>
                                </td>
                                <td style="padding:10px 14px; border-top:1px solid #eee;">
                                    <?php if ($c['estado'] === 'pendiente'): ?>
                                        <a href="index.php?controller=citas&action=cancelar&id=<?= $c['idCita'] ?>"
                                           style="color:#db2828; font-size:13px;"
                                           onclick="return confirm('¿Seguro que deseas cancelar esta cita?');">
                                           Cancelar
                                        </a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="empty-msg">Aún no tienes citas registradas.</p>
        <?php endif; ?>
    </div>

</div>

<script>
const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('toggle-btn');

toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
});
</script>

</body>
</html>
