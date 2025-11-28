<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Si ya está logueado, redirigir según rol
if (isset($_SESSION['id'])) {

    switch ($_SESSION['rol']) {
        case 'cliente':
            header("Location: index.php?controller=cliente&action=index");
            exit;

        case 'administrador':
            header("Location: index.php?controller=administrador&action=index");
            exit;

        case 'entrenador':
            header("Location: index.php?controller=entrenador&action=index");
            exit;
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport Zona - Iniciar Sesión</title>
    <link rel="stylesheet" href="public/css/auth-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="auth-body">

    <!-- NAV -->
    <header class="nav">
        <div class="nav-container">
            <div class="logo">
                <i class="fas fa-dumbbell"></i>
                <span>Sport Zona</span>
            </div>
            <nav class="nav-menu">
                <a href="index.php#inicio">Inicio</a>
                <a href="index.php#servicios">Servicios</a>
                <a href="index.php?controller=home&action=horarios">Horarios</a>
            </nav>
        </div>
    </header>

    <div class="auth-container">

        <!-- HERO -->
        <div class="auth-hero">
            <div class="auth-hero-content">
                <h1>Energía que te impulsa</h1>
                <p class="auth-subtitle">Accede a tu cuenta para reservar citas, horarios y asesorías personalizadas.</p>

                <div class="auth-features">
                    <div class="feature-item"><i class="fas fa-calendar-check"></i><span>Sin permanencia</span></div>
                    <div class="feature-item"><i class="fas fa-clock"></i><span>Acceso 24/7</span></div>
                </div>
            </div>
        </div>

        <!-- FORM -->
        <div class="auth-form-section">
            <div class="auth-form-container">

                <div class="auth-header">
                    <h2>Bienvenido a Sport Zona</h2>
                    <div class="auth-tabs">
                        <a href="index.php?controller=user&action=login" class="auth-tab active">Iniciar sesión</a>
                        <a href="index.php?controller=user&action=insert" class="auth-tab">Crear cuenta</a>
                    </div>
                </div>

                <?php if (!empty($mensaje)): ?>
                    <div class="alert-message"
                         style="background:#ffdddd;color:#b30000;padding:12px;margin-bottom:18px;
                                border-left:4px solid #cc0000;border-radius:4px;font-size:14px;">
                        <?= $mensaje ?>
                    </div>
                <?php endif; ?>

                <form class="auth-form" method="POST">

                    <div class="form-group">
                        <label for="correo">Correo electrónico</label><br>
                        <input type="email" id="correo" name="correo" placeholder="nombre@correo.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label><br>
                        <input type="password" id="password" name="password" placeholder="······" required>
                    </div>

                    <button type="submit" name="enviar" class="auth-btn">Entrar</button>
                </form>

                <div class="auth-footer">
                    ¿No tienes cuenta? <a href="index.php?controller=user&action=insert" class="auth-link">Regístrate</a>
                </div>

            </div>
        </div>

    </div>

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
                    <li><a href="index.php#servicios">Servicios</a></li>
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
