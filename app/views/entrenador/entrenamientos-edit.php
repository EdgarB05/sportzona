<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Entrenamiento | SportZona</title>
    <link rel="stylesheet" href="public/css/trainer.css">
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar-trainer">

    <div class="sidebar-logo">SZ</div>

    <nav class="sidebar-nav">

        <!-- DASHBOARD -->
        <a href="index.php?controller=coach&action=index" 
           class="sidebar-item <?= ($_GET['controller'] ?? '') === 'coach' ? 'active' : '' ?>">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- ENTRENAMIENTOS -->
        <a href="index.php?controller=entrenamientos&action=index"
           class="sidebar-item <?= ($_GET['controller'] ?? '') === 'entrenamientos' ? 'active' : '' ?>">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2h-4"/>
                <path d="M3 9V5a2 2 0 0 1 2-2h4"/>
                <rect x="3" y="9" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
            </svg>
            <span>Entrenamientos</span>
        </a>

        <!-- PLANES DE ALIMENTACIÓN -->
        <a href="index.php?controller=PlanAlimentacion&action=listar"
           class="sidebar-item <?= ($_GET['controller'] ?? '') === 'PlanAlimentacion' ? 'active' : '' ?>">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16v4H4z"/>
                <path d="M4 12h16v8H4z"/>
            </svg>
            <span>Planes Alimentación</span>
        </a>

        <!-- CITAS -->
        <a href="index.php?controller=citas&action=lista"
           class="sidebar-item <?= ($_GET['controller'] ?? '') === 'citas' ? 'active' : '' ?>">
            <svg fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
            <span>Citas</span>
        </a>

        <!-- LOGOUT -->
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

<main class="main-content">

    <div class="form-container">

        <h2>Editar Entrenamiento</h2>

        <form action="index.php?controller=entrenamientos&action=update" method="POST">

            <input type="hidden" name="idEntrenamiento" value="<?= $entrenamiento['idEntrenamiento'] ?>">

            <label class="label">Nombre de rutina</label>
            <input type="text" name="nombreRutina" class="input"
                   value="<?= htmlspecialchars($entrenamiento['nombreRutina']) ?>">

            <label class="label">Descripción</label>
            <textarea name="descripcionEje" rows="3"><?= htmlspecialchars($entrenamiento['descripcionEje']) ?></textarea>

            <label class="label">Dificultad</label>
            <input type="text" name="dificultad" class="input"
                   value="<?= htmlspecialchars($entrenamiento['dificultad']) ?>">
                   
            <button class="btn-save">Actualizar entrenamiento</button>

        </form>

    </div>

</main>

</body>
</html>
