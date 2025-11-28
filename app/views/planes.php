<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membresías - Sport Zona</title>

    <!-- CSS PRINCIPAL -->
    <link rel="stylesheet" href="public/css/styles.css">

    <!-- CSS DE MEMBRESÍAS -->
    <link rel="stylesheet" href="public/css/planes.css">

    <!-- ICONOS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<!-- NAVBAR -->
<header class="nav">
    <div class="container">
        <div class="logo">
            <i class="fas fa-dumbbell"></i>
            <span>Sport Zona</span>
        </div>

        <nav class="nav-menu">
            <a href="index.php?controller=home&action=index">Inicio</a>
            <a href="index.php#servicios">Servicios</a>
            <a href="#horarios">Horarios</a>
        </nav>

        <div class="nav-buttons">
            <a href="index.php?controller=user&action=login" class="boton">Iniciar sesión</a>
            <a href="index.php?controller=user&action=insert" class="registrar">Regístrate</a>
        </div>
    </div>
</header>

<!-- HERO -->
<section class="membresias-hero">
    <h1>Membresías</h1>
    <p>Encuentra el plan que mejor se adapta a tu ritmo, objetivos y presupuesto.</p>
</section>

<!-- TARJETAS -->
<section class="membresias-container">

    <!-- Plan destacado -->
    <div class="membresia-card destacado">
        <span class="badge">Mejor elección</span>
        <h3>3 Meses</h3>
        <h2>$730 MXN</h2>
        <div class="ahorro">Ahorra $170 MXN</div>
        <p class="detalle">
            Perfecto para quienes buscan constancia sin comprometerse a largo plazo.
            <br><br>
            Ideal si quieres evaluar tus resultados reales y mantener motivación continua.
        </p>
    </div>

    <div class="membresia-card">
        <h3>Mensualidad</h3>
        <h2>$300 MXN</h2>
        <div class="ahorro nada">Sin ahorro</div>
        <p class="detalle">
            La opción flexible para quienes están comenzando o quieren probar el servicio.
            <br><br>
            Ideal si buscas un compromiso mes a mes sin presión.
        </p>
    </div>

    <div class="membresia-card">
        <h3>2 Meses</h3>
        <h2>$500 MXN</h2>
        <div class="ahorro">Ahorra $100 MXN</div>
        <p class="detalle">
            Perfecto si estás tomando impulso y deseas ver avances en un periodo corto.
            <br><br>
            Recomendado si entrenas mínimo 3 veces por semana.
        </p>
    </div>

    <div class="membresia-card">
        <h3>4 Meses</h3>
        <h2>$900 MXN</h2>
        <div class="ahorro">Ahorra $300 MXN</div>
        <p class="detalle">
            Un plan sólido para comprometerte con tus metas y obtener resultados visibles.
            <br><br>
            Ideal para rutinas progresivas o programas de transformación.
        </p>
    </div>

    <div class="membresia-card">
        <h3>Anualidad</h3>
        <h2>$2300 MXN</h2>
        <div class="ahorro">Ahorra $1300 MXN</div>
        <p class="detalle">
            Para quienes van en serio con su salud y buscan el mejor costo-beneficio.
            <br><br>
            La opción más económica para entrenar sin límites todo el año.
        </p>
    </div>

</section>

<footer class="auth-page-footer">
    <div class="footer-content">

        <div class="footer-section">
            <h4>Sport Zona</h4>
            <p>Energía, enfoque y resultados en un solo lugar.</p>

            <div class="social-links">
                <a href="https://www.instagram.com/fitness_tees1?igsh=aGRxeWVvZW0zdTgz" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.facebook.com/share/17V7qj2aRz/" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                </a>
            </div>
        </div>

        <div class="footer-section">
            <h4>Dirección</h4>
            <p>Av. Emiliano Zapata 116,<br>Antonio Barona, 62320 Cuernavaca, Mor.</p>
            <p><strong>Contacto:</strong> 777 416 2821</p>
        </div>

        <div class="footer-section">
            <h4>Navegación</h4>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="index.php?controller=home&action=planes">Servicios</a></li>
                <li><a href="index.php?controller=home&action=horarios">Horarios</a></li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        © 2025 Sport Zona. Todos los derechos reservados.
    </div>
</footer>
</body>
</html>
