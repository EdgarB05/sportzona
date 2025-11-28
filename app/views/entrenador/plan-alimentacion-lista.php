<?php if (!isset($cuestionarios)) { $cuestionarios = []; } ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Planes de Alimentación | Entrenador</title>
    <link rel="stylesheet" href="public/css/trainer.css">
</head>
<body>

<!-- SIDEBAR ENTRENADOR -->
<aside class="sidebar-trainer">
    <div class="sidebar-logo">SZ</div>

    <nav class="sidebar-nav">

        <a href="index.php?controller=coach&action=index" 
           class="sidebar-item">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="index.php?controller=entrenamientos&action=index"
           class="sidebar-item">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2h-4"/>
                <path d="M3 9V5a2 2 0 0 1 2-2h4"/>
                <rect x="3" y="9" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
            </svg>
            <span>Entrenamientos</span>
        </a>

        <a class="sidebar-item active"
           href="index.php?controller=PlanAlimentacion&action=listar">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16v4H4z"/>
                <path d="M4 12h16v8H4z"/>
            </svg>
            <span>Planes Alimentación</span>
        </a>

        <a href="index.php?controller=citas&action=lista"
           class="sidebar-item">
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
    <h1>Planes de Alimentación</h1>

    <!-- Buscador -->
    <form method="get" action="index.php" class="search-bar">
        <input type="hidden" name="controller" value="PlanAlimentacion">
        <input type="hidden" name="action" value="listar">
        <input type="text" name="buscar" placeholder="Buscar cliente o nombre"
               value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">
        <button type="submit" class="btn-small btn-edit">Buscar</button>
    </form>

    <?php if (empty($cuestionarios)): ?>
        <p style="margin-top:40px;color:#6b7280;">No hay cuestionarios registrados.</p>
    <?php else: ?>
        <div class="trainings-grid">
            <?php foreach ($cuestionarios as $c): ?>
                <div class="training-card">

                    <h3><?= htmlspecialchars($c['nombreCompleto']) ?></h3>

                    <p><strong>Objetivo:</strong> <?= htmlspecialchars($c['objetivo']) ?></p>

                    <p><strong>Cliente:</strong> <?= htmlspecialchars($c['nombreUsuario']) ?></p>

                    <p><strong>Fecha:</strong> <?= htmlspecialchars($c['fechaRegistro']) ?></p>

                    <div class="training-actions">
                        <a href="index.php?controller=PlanAlimentacion&action=ver&id=<?= $c['idCuestionario'] ?>">
                            <button class="btn-small btn-edit">Ver detalles</button>
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

</body>
</html>
