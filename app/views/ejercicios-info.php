<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrenamiento básico - Sport Zona</title>

    <!-- CSS PRINCIPAL -->
    <link rel="stylesheet" href="public/css/styles.css">

    <!-- CSS PREMIUM -->
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
            <a href="index.php?controller=home&action=horarios">Horarios</a>
        </nav>

        <div class="nav-buttons">
            <a href="index.php?controller=user&action=login" class="boton">Iniciar sesión</a>
            <a href="index.php?controller=user&action=register" class="registrar">Regístrate</a>
        </div>
    </div>
</header>

<!-- HERO -->
<section class="membresias-hero">
    <h1>Entrenamiento básico</h1>
    <p>
        Comienza con ejercicios esenciales y una guía clara para entrenar con buena técnica y seguridad.
    </p>
</section>

<!-- CONTENIDO -->
<section class="membresias-container">

    <div class="membresia-card destacado">
        <span class="badge">Ideal para principiantes</span>
        <h3>¿Qué es el entrenamiento básico?</h3>
        <p class="detalle">
            Es un conjunto de ejercicios diseñados para aprender movimientos fundamentales,
            mejorar tu condición física y adaptarte al ambiente del gimnasio.
            <br><br>
            Incluye ejercicios sencillos y fáciles de seguir, enfocados en mejorar fuerza,
            movilidad, resistencia y postura.
        </p>
    </div>

    <div class="membresia-card">
        <h3>Beneficios del entrenamiento</h3>
        <p class="detalle">
            • Aprenderás técnica correcta desde el inicio.<br>
            • Previene lesiones futuras.<br>
            • Aumenta tu fuerza general y resistencia.<br>
            • Te ayuda a crear hábito y disciplina.<br>
            • Perfecto para quienes retoman el ejercicio.
        </p>
    </div>

    <div class="membresia-card">
        <h3>¿Cómo funciona dentro de Sport Zona?</h3>
        <p class="detalle">
            1. Accedes a la lista de ejercicios dentro de la plataforma.<br><br>
            2. Cada ejercicio incluye explicación, imagen y recomendaciones.<br><br>
            3. Puedes consultarlos libremente según tu ritmo.<br><br>
            4. Si tienes dudas, puedes pedir ayuda al coach.
        </p>
    </div>

    <div class="membresia-card">
        <h3>¿Para quién está pensado?</h3>
        <p class="detalle">
            • Personas nuevas en el gimnasio.<br>
            • Quienes quieren entrenar con seguridad.<br>
            • Personas retomando actividad física.<br>
            • Usuarios que buscan rutinas simples pero efectivas.
        </p>
    </div>

</section>

<!-- CTA -->
<section style="max-width: 900px; margin: 40px auto 70px; text-align:center;">
    <h3 style="font-size: 24px; margin-bottom: 12px;">¿Listo para comenzar con tus ejercicios?</h3>
    <p style="font-size: 16px; color:#444; margin-bottom: 20px;">
        Si ya tienes una cuenta, inicia sesión para ver el catálogo de ejercicios.
    </p>

    <!-- 🔵 CAMBIADO A INICIAR SESIÓN -->
    <a href="index.php?controller=user&action=login" class="boton">
        Iniciar sesión
    </a>
</section>

<!-- FOOTER -->
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
