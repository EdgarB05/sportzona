<?php 
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['id']) || ($_SESSION['rol'] ?? '') !== 'entrenador') {
    header("Location: index.php?controller=user&action=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Citas Programadas | SportZona</title>
    <link rel="stylesheet" href="public/css/trainer.css">

    <style>
        /* === ESTILO ESPECIAL PARA TABLAS DE CITAS === */

        .table-container {
            margin-top: 25px;
            background: #ffffff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        table.citas-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .citas-table thead th {
            text-align: left;
            padding: 12px;
            font-size: 15px;
            font-weight: bold;
            color: #333;
        }

        .citas-table tbody tr {
            background: #f7f9fc;
            border-radius: 12px;
            transition: 0.2s;
        }

        .citas-table tbody tr:hover {
            background: #eef4ff;
        }

        .citas-table tbody td {
            padding: 16px 14px;
            font-size: 14px;
            color: #444;
        }

        .status-confirmada { color: #0a7a1f; font-weight: bold; }
        .status-cancelada { color: #b30000; font-weight: bold; }
        .status-pendiente { color: #b38f00; font-weight: bold; }

        .action-link {
            font-size: 14px;
            margin-right: 12px;
            text-decoration: none;
            font-weight: 600;
        }
        .link-confirm { color: #0a6ef0; }
        .link-reject  { color: #c70000; }

    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar-trainer">
    <div class="sidebar-logo">SZ</div>

    <nav class="sidebar-nav">

        <a href="index.php?controller=coach&action=index"
           class="sidebar-item <?= ($_GET['controller'] ?? '') === 'coach' ? 'active' : '' ?>">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="index.php?controller=entrenamientos&action=index"
           class="sidebar-item <?= ($_GET['controller'] ?? '') === 'entrenamientos' ? 'active' : '' ?>">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="9" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
            </svg>
            <span>Entrenamientos</span>
        </a>

        <a href="index.php?controller=PlanAlimentacion&action=listar"
           class="sidebar-item <?= ($_GET['controller'] ?? '') === 'PlanAlimentacion' ? 'active' : '' ?>">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16v4H4z"/>
                <path d="M4 12h16v8H4z"/>
            </svg>
            <span>Planes Alimentación</span>
        </a>

        <a href="index.php?controller=citas&action=lista"
           class="sidebar-item active">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
            <span>Citas</span>
        </a>

        <a href="index.php?controller=user&action=logout" class="sidebar-item">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <path d="M15 3h4v18h-4"/>
                <path d="M10 17l5-5-5-5"/>
                <path d="M15 12H3"/>
            </svg>
            <span>Cerrar sesión</span>
        </a>

    </nav>

</aside>

<!-- MAIN -->
<main class="main-content">

    <h1>Citas Programadas</h1>

    <div class="table-container">

        <?php if (!empty($citas)): ?>
            <table class="citas-table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($citas as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['nombre'] . ' ' . $c['apePa']) ?></td>
                        <td><?= htmlspecialchars($c['fecha']) ?></td>
                        <td><?= htmlspecialchars(substr($c['hora'],0,5)) ?></td>
                        <td><?= htmlspecialchars($c['motivo']) ?></td>

                        <td>
                            <span class="status-<?= strtolower($c['estado']) ?>">
                                <?= ucfirst($c['estado']) ?>
                            </span>
                        </td>

                        <td>
                            <?php if ($c['estado'] === 'pendiente'): ?>
                                <a class="action-link link-confirm"
                                   href="index.php?controller=citas&action=actualizarEstado&id=<?= $c['idCita'] ?>&estado=confirmada">
                                   Confirmar
                                </a>

                                <a class="action-link link-reject"
                                   href="index.php?controller=citas&action=actualizarEstado&id=<?= $c['idCita'] ?>&estado=rechazada">
                                   Rechazar
                                </a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>

        <?php else: ?>
            <p style="padding:20px; font-size:15px; color:#555;">No hay citas registradas.</p>
        <?php endif; ?>

    </div>

</main>

</body>
</html>
