<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios - Sport Zona</title>

    <!-- CSS PRINCIPAL -->
    <link rel="stylesheet" href="public/css/styles.css">

    <!-- CSS DE MEMBRESÍAS (ESTILO PREMIUM) -->
    <link rel="stylesheet" href="public/css/planes.css">

    <!-- ICONOS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Ajustes visuales exclusivos para HORARIOS */
        .horario-card h2 {
            font-size: 45px !important;
            margin-bottom: 5px;
        }

        .detalle-horario {
            margin-top: 15px;
            font-size: 15px;
            line-height: 1.5;
            color: #555;
        }
    </style>
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
            <a href="index.php?controller=home&action=horarios" class="active">Horarios</a>
        </nav>

        <div class="nav-buttons">
            <a href="index.php?controller=user&action=login" class="boton">Iniciar sesión</a>
            <a href="index.php?controller=user&action=register" class="registrar">Regístrate</a>
        </div>
    </div>
</header>

<!-- HERO NEGRO PREMIUM -->
<section class="membresias-hero">
    <h1>Horarios</h1>
    <p>Entrena en los horarios que mejor se adapten a tu ritmo y objetivos.</p>
</section>

<!-- TARJETAS DE HORARIOS (ESTILO PREMIUM) -->
<section class="membresias-container">

    <!-- Lunes a Viernes DESTACADO -->
    <div class="membresia-card destacado horario-card">
        <span class="badge">Más utilizado</span>
        <h3>Lunes a Viernes</h3>
        <h2>6:00 AM – 9:30 PM</h2>

        <div class="ahorro">Acceso todo el día</div>

        <p class="detalle-horario">
            Perfecto para quienes entrenan antes o después del trabajo.
            <br><br>
            Ambiente dinámico, buena disponibilidad y acceso completo a todas las áreas.
        </p>
    </div>

    <!-- Sábado -->
    <div class="membresia-card horario-card">
        <h3>Sábado</h3>
        <h2>7:00 AM – 1:00 PM</h2>

        <div class="ahorro">Horario reducido</div>

        <p class="detalle-horario">
            Ideal para entrenar con tranquilidad en un ambiente más relajado.
            <br><br>
            Perfecto para rutinas largas o sesiones de recuperación.
        </p>
    </div>

</section>

<!-- INFORMACIÓN ADICIONAL -->
<section class="info-extra" style="margin: 50px auto; max-width: 900px; text-align:center;">
    <h3 style="font-size: 25px; margin-bottom: 10px;">Información importante</h3>

    <p style="font-size: 16px; color:#444; line-height: 1.6;">
        • El acceso está permitido hasta 15 minutos antes del cierre.<br>
        • En días festivos podría haber horario especial.<br>
        • Los cambios se anunciarán en redes sociales y dentro del gimnasio.
    </p>
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
