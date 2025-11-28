<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($rutina['nombreRutina']) ?> - Sport Zona</title>
    <link rel="stylesheet" href="public/css/admin-styles.css">
</head>
<body>

<!-- Si quieres mostrar la misma sidebar que cliente/admin, puedes añadirla aquí -->

<main class="main">
    <div class="topbar">
        <h1><?= htmlspecialchars($rutina['nombreRutina']) ?></h1>
        <p class="text-muted">
            Dificultad: <strong><?= htmlspecialchars(ucfirst($rutina['dificultad'])) ?></strong>
            <?php if (!empty($rutina['nombreCoach'])): ?>
                · Coach: <?= htmlspecialchars($rutina['nombreCoach']) ?>
            <?php endif; ?>
        </p>
    </div>

    <div class="section-card">
        <h2>Descripción general</h2>
        <p><?= nl2br(htmlspecialchars($rutina['descripcionEje'])) ?></p>
    </div>

    <div class="section-card">
        <h2>Ejercicios</h2>

        <?php if (empty($ejercicios)): ?>
            <p>Aún no hay ejercicios registrados para esta rutina.</p>
        <?php else: ?>
            <div class="ejercicios-grid">
                <?php foreach ($ejercicios as $ej): ?>
                    <article class="card-ejercicio">
                        <h3><?= htmlspecialchars($ej['nombreEjercicio']) ?></h3>
                        <p class="meta">
                            Series: <?= (int)$ej['series'] ?> · Reps: <?= (int)$ej['repeticiones'] ?>
                        </p>
                        <p><?= nl2br(htmlspecialchars($ej['descripcion'])) ?></p>

                        <?php if (!empty($ej['videoUrl'])): ?>
                            <div class="video-wrapper">
                                <iframe 
                                    src="<?= htmlspecialchars($ej['videoUrl']) ?>" 
                                    frameborder="0"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <br>
        <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>
    </div>
</main>

<style>
.ejercicios-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:1.5rem;
}
.card-ejercicio{
    background:#fff;
    border-radius:1rem;
    padding:1rem 1.2rem;
    box-shadow:0 10px 25px rgba(15,23,42,0.08);
    border:1px solid #e5e7eb;
    font-size:.9rem;
}
.card-ejercicio h3{
    margin-top:0;
    font-size:1rem;
}
.card-ejercicio .meta{
    font-size:.8rem;
    color:#6b7280;
}
.video-wrapper{
    margin-top:.75rem;
    position:relative;
    padding-bottom:56.25%;
    height:0;
    overflow:hidden;
    border-radius:.75rem;
}
.video-wrapper iframe{
    position:absolute;
    top:0;left:0;
    width:100%;
    height:100%;
}
</style>

</body>
</html>
