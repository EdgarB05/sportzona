<?php 
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: index.php?controller=user&action=login");
    exit;

    // BLOQUEA EL BOTÓN DE REGRESAR (desactiva cache del navegador)
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Cliente | Sport Zona</title>
    <link rel="stylesheet" href="public/css/dashboard-cliente.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- NAV SUPERIOR -->
<nav class="nav-top">
    <div class="logo">Sport Zona</div>
    <div class="nav-right">
        <a href="index.php?controller=user&action=logout" class="logout">Cerrar sesión</a>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
    <p>Accede a avisos, promociones y funciones de tu membresía.</p>
</section>

<?php if (!empty($membresia) && $expiraPronto): ?>
<div class="alert-membresia">
    <div class="alert-icon">
        <i class="fa-solid fa-triangle-exclamation"></i>
    </div>

    <div class="alert-text">
        <span class="alert-title">Tu membresía está por expirar</span>
        <span class="alert-body">
            Vence en <strong><?= $diasRestantes ?> día(s)</strong>.  
            ¡Renueva para evitar interrupciones!
        </span>
    </div>
</div>
<?php endif; ?>



<div class="container">

    <!-- AVISOS -->
    <section class="section-block">
        <h2>Avisos</h2>
        <p class="section-sub">Información importante del gimnasio</p>

        <div class="cards-row">
            <?php if (!empty($avisosDestacados)): ?>
                <?php foreach ($avisosDestacados as $aviso): ?>
                    <a class="notice-card" href="">
                        <h3><?= htmlspecialchars($aviso['titulo']); ?></h3>
                        <p><?= nl2br(htmlspecialchars($aviso['mensaje'])); ?></p>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-msg">No hay avisos disponibles.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- PROMOCIONES -->
    <section class="section-block">
        <h2>Promociones</h2>
        <p class="section-sub">Aprovecha las promociones activas</p>

        <div class="cards-row">
            <?php if (!empty($promosVigentes)): ?>
                <?php foreach ($promosVigentes as $promo): ?>
                    <a class="promo-card" href="">
                        <h3><?= htmlspecialchars($promo['nombrePromo']); ?></h3>
                        <p><?= nl2br(htmlspecialchars($promo['descripcionPromo'])); ?></p>
                        <span class="promo-fechas">
                            Vigencia: <?= htmlspecialchars($promo['fechaInicio']); ?> - 
                            <?= htmlspecialchars($promo['fechaFin']); ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-msg">No hay promociones activas.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- ACCESOS RÁPIDOS -->
    <section class="section-block">
        <h2>Accesos rápidos</h2>

        <div class="grid-5">

            <div class="card">
                <h3>Membresía</h3>
                <p>Consulta tu plan actual y vigencia.</p>
                <a href="index.php?controller=cliente&action=membresia">Ver membresía</a>
            </div>

            <div class="card">
                <h3>Horarios</h3>
                <p>Revisa los horarios del gimnasio.</p>
                <a href="index.php?controller=cliente&action=horarios">Ver horarios</a>
            </div>

            <div class="card">
                <h3>Ejercicios</h3>
                <p>Consulta los ejercicios disponibles.</p>
                <a href="index.php?controller=entrenamientos&action=publicList">Ver ejercicios</a>
            </div>

            <div class="card">
                <h3>Plan alimenticio</h3>
                <p>Tu alimentación personalizada.</p>
                <a href="index.php?controller=PlanAlimentacion&action=clienteFormulario">Ver plan</a>
            </div>

            <div class="card">
                <h3>Citas</h3>
                <p>Agenda y consulta tus citas.</p>
                <a href="index.php?controller=citas&action=agendar">Agendar cita</a>
            </div>

        </div>
    </section>

</div>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-inner">

        <div class="footer-col">
            <h3>Sport Zona</h3>
            <p>Energía, enfoque y resultados en un solo lugar.</p>
            <div class="footer-icons">
                <i class="fab fa-instagram"></i>
                <i class="fab fa-facebook"></i>
            </div>
        </div>

        <div class="footer-col">
            <h3>Dirección</h3>
            <p>Av. Emiliano Zapata 116,<br>Cuernavaca, Mor.</p>
            <p><strong>Contacto:</strong> 777 416 2821</p>
        </div>

        <div class="footer-col">
            <h3>Navegación</h3>
            <ul>
                <li><a href="index.php?controller=home&action=index">Inicio</a></li>
                <li><a href="index.php#servicios">Servicios</a></li>
                <li><a href="index.php?controller=cliente&action=horarios">Horarios</a></li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        © 2025 Sport Zona. Todos los derechos reservados.
    </div>
</footer>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const alertBox = document.querySelector(".alert-membresia");
    if (alertBox) {
        setTimeout(() => {
            alertBox.classList.add("hide-alert");
        }, 4000); // <-- tiempo antes de desaparecer (ms)
    }
});
</script>


</body>
</html>
