<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Entrenamientos | SportZona</title>
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

<!-- MAIN CONTENT -->
<main class="main-content">

    <h1>Entrenamientos Creados</h1>

    <!-- 🔍 Barra de búsqueda -->
    <form method="GET" action="index.php" class="search-bar" style="margin:15px 0; display:flex; gap:10px;">
        <input type="hidden" name="controller" value="entrenamientos">
        <input type="hidden" name="action" value="index">

        <input 
            type="text" 
            name="buscar" 
            placeholder="Buscar entrenamiento..." 
            value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>"
            style="
                padding:10px 14px;
                border-radius:8px;
                border:1px solid #ccc;
                width:250px;
                font-size:14px;
            "
        >

        <button 
            type="submit" 
            style="
                padding:10px 16px;
                background:#0ea5e9;
                color:#fff;
                border:none;
                border-radius:8px;
                cursor:pointer;
            "
        >Buscar</button>
    </form>

    <a href="index.php?controller=entrenamientos&action=create">
        <button class="btn-save" style="max-width:250px;margin-top:5px;">
            + Nuevo entrenamiento
        </button>
    </a>

    <div class="trainings-grid">
        <?php if(!empty($lista)): ?>
            <?php foreach ($lista as $item): ?>
                <div class="training-card">

                    <h3><?= htmlspecialchars($item['nombreRutina']) ?></h3>
                    <p><?= htmlspecialchars($item['descripcionEje']) ?></p>
                    <p><strong>Dificultad:</strong> <?= htmlspecialchars($item['dificultad']) ?></p>

                    <div class="training-actions">
                        <a href="index.php?controller=entrenamientos&action=edit&id=<?= $item['idEntrenamiento'] ?>">
                            <button class="btn-small btn-edit">Editar</button>
                        </a>

                        <a href="index.php?controller=entrenamientos&action=delete&id=<?= $item['idEntrenamiento'] ?>"
                        onclick="return confirm('¿Eliminar entrenamiento?')">
                            <button class="btn-small btn-delete">Eliminar</button>
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color:#777; margin-top:20px;">No se encontraron entrenamientos.</p>
        <?php endif; ?>
    </div>

</main>


</body>
</html>
