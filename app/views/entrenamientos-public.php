<?php
include_once __DIR__ . '/components/renderMedia.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Rutinas de Entrenamiento | Sport Zona</title>
    <link rel="stylesheet" href="public/css/admin-styles.css">
    <style>
        /* --- Estilos adicionales para tarjetas públicas --- */

        .public-container {
            margin-left: 270px;
            padding: 2rem;
        }

        .public-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .public-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .public-card {
            background: white;
            border-radius: 10px;
            padding: 1.3rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            transition: 0.2s;
        }

        .public-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.12);
        }

        .public-card h3 {
            margin: 0;
            font-size: 1.3rem;
        }

        .public-card .difficulty {
            margin-top: 5px;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .video-container {
            margin-top: 1rem;
            border-radius: 10px;
            overflow: hidden;
            aspect-ratio: 16 / 9;
            background: #000;
        }

        .video-container iframe {
            width: 100%;
            height: 100%;
        }

        .search-bar-public {
            display: flex;
            gap: 10px;
            margin-top: 1rem;
            margin-bottom: 1rem;
            max-width: 600px;
        }

        .search-bar-public input {
            flex: 1;
            padding: 10px 14px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
        }

        .search-bar-public button {
            padding: 10px 20px;
            background: #6366f1;
            border: none;
            border-radius: 6px;
            color: white;
            cursor: pointer;
        }

        .search-bar-public button:hover {
            background: #4f46e5;
        }

        .public-media-container {
            width: 100%;
            max-height: 230px;
            overflow: hidden;
            border-radius: 12px;
        }

        .public-media-container img,
        .public-media-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

    </style>
</head>
<body>

<!-- Sidebar (igual que la del home del administrador pero pública) -->
<aside class="sidebar">
    <div>
        <div class="brand">Sport Zona</div>
        <ul class="nav-links">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="index.php?controller=entrenamientos&action=publicList" class="active">Entrenamientos</a></li>
        </ul>
    </div>
    <a href="index.php?controller=user&action=login" class="btn-logout">Iniciar Sesión</a>
</aside>

<!-- Contenido principal -->
<div class="public-container">

    <h1 class="public-title">Ejercicios Básicos</h1>
    <p>Explora ejercicios recomendados por nuestros entrenadores.</p>

    <!-- Barra de búsqueda -->
    <form method="GET" action="index.php" class="search-bar-public">
        <input type="hidden" name="controller" value="entrenamientos">
        <input type="hidden" name="action" value="publicList">
        <input type="text" name="buscar" placeholder="Buscar por nombre o dificultad..."
               value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">
        <button type="submit">Buscar</button>
    </form>

    <!-- Tarjetas de rutinas -->
    <div class="public-grid">
        <?php if (!empty($entrenamientos)): ?>
            <?php foreach ($entrenamientos as $ent): ?>
                <article class="exercise-card">
                    <header class="exercise-header">
                        <div>
                            <h3><?= htmlspecialchars($ent['nombreRutina']) ?></h3>
                            <p class="exercise-meta">
                                Dificultad: <strong><?= htmlspecialchars($ent['dificultad']) ?></strong>
                                <?php if (!empty($ent['nombreCoach'])): ?>
                                    · Coach: <?= htmlspecialchars($ent['nombreCoach']) ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </header>

                    <p class="exercise-description">
                        <?= nl2br(htmlspecialchars($ent['descripcionEje'])) ?>
                    </p>

                    <?php if (!empty($ent['videoURL'])): ?>
                        <div class="exercise-video">
                            <div class="video-wrapper">
                                <iframe
                                    src="<?= htmlspecialchars($ent['videoURL']) ?>"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>

        <?php else: ?>
            <p>No se encontraron rutinas.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
