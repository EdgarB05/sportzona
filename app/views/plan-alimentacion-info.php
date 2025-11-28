<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan de alimentación - Sport Zona</title>

    <!-- CSS PRINCIPAL -->
    <link rel="stylesheet" href="public/css/styles.css">

    <!-- CSS DE MEMBRESÍAS (lo reutilizamos para el estilo premium) -->
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
    <h1>Plan de alimentación</h1>
    <p>
        Acompaña tu entrenamiento con una guía nutricional hecha a tu medida, diseñada por tu coach.
    </p>
</section>

<!-- CONTENIDO PRINCIPAL -->
<section class="membresias-container">

    <!-- Bloque 1 -->
    <div class="membresia-card destacado">
        <span class="badge">100% personalizado</span>
        <h3>¿Qué es el plan de alimentación?</h3>
        <p class="detalle">
            Es una guía nutricional creada por tu coach de acuerdo a tus objetivos:
            bajar grasa, aumentar músculo, mejorar rendimiento o simplemente
            ordenar tus hábitos.
            <br><br>
            Tu plan toma en cuenta tu horario, tus gustos, platillos que
            realmente puedas preparar y tu nivel de actividad en el gimnasio.
        </p>
    </div>

    <!-- Bloque 2 -->
    <div class="membresia-card">
        <h3>¿Cómo funciona?</h3>
        <p class="detalle">
            1. <strong>Llenas el cuestionario</strong> de plan de alimentación en tu cuenta de cliente.
            <br><br>
            2. <strong>Tu coach revisa tu información</strong> (objetivo, peso, horarios, gustos y restricciones).
            <br><br>
            3. <strong>Diseña tu plan</strong> con tiempos de comida, cantidades aproximadas y ejemplos de platillos.
            <br><br>
            4. <strong>Te lo entrega y resuelve dudas</strong> para que sepas cómo aplicarlo en tu día a día.
        </p>
    </div>

    <!-- Bloque 3 -->
    <div class="membresia-card">
        <h3>Pago del plan</h3>
        <p class="detalle">
            El <strong>pago del plan de alimentación se realiza directamente con tu coach</strong>,
            no se cobra en línea desde la página.
            <br><br>
            ● El costo será de $200.00 pesos.<br>
            ● Puedes realizar el pago en efectivo en el gimnasio.<br>
            ● Cualquier duda sobre el precio o promociones, coméntala con el coach.
        </p>
    </div>

    <!-- Bloque 4 -->
    <div class="membresia-card">
        <h3>Recomendaciones</h3>
        <p class="detalle">
            Para aprovechar al máximo tu plan:
            <br><br>
            • Sé lo más honesto posible al llenar el cuestionario.<br>
            • Informa si tienes alguna condición médica.<br>
            • Combina tu plan con constancia y descanso.<br>
            • Pide ajustes al coach si cambian tus horarios u objetivo.
        </p>
    </div>

</section>

<!-- CTA -->
<section style="max-width: 900px; margin: 40px auto 70px; text-align:center;">
    <h3 style="font-size: 24px; margin-bottom: 12px;">¿Listo para solicitar tu plan?</h3>
    <p style="font-size: 16px; color:#444; margin-bottom: 20px;">
        Si ya tienes una membresía activa, entra a tu cuenta, llena el cuestionario y habla con tu coach.
    </p>

    <a href="index.php?controller=user&action=login" class="boton">
        Ir a mi cuenta
    </a>
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
