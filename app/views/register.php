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
    <title>Registro - Sport Zona</title>
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
                <a href="index.php?controller=home&action=index">Inicio</a>
                <a href="index.php#servicios">Servicios</a>
                <a href="index.php?controller=home&action=horarios">Horarios</a>
            </nav>
        </div>
    </header>

    <div class="auth-container">

        <!-- HERO -->
        <div class="auth-hero">
            <div class="auth-hero-content">
                <h1>Tu primer paso empieza hoy</h1>
                <p class="auth-subtitle">Crea tu cuenta para reservar clases, ver horarios y activar tu prueba gratuita.</p>

                <div class="auth-features">
                    <div class="feature-item"><i class="fas fa-lock"></i><span>Pagos seguros</span></div>
                    <div class="feature-item"><i class="fas fa-calendar-alt"></i><span>Membresías accesibles</span></div>
                </div>
            </div>
        </div>

        <!-- FORM REGISTER -->
        <div class="auth-form-section">
            <div class="auth-form-container">

                <div class="auth-header">
                    <h2>Crear cuenta</h2>
                    <div class="auth-tabs">
                        <a href="index.php?controller=user&action=login" class="auth-tab">Iniciar sesión</a>
                        <a href="index.php?controller=user&action=register" class="auth-tab active">Crear cuenta</a>
                    </div>
                </div>

                <?php if (!empty($mensaje)): ?>
                    <?php if ($mensaje === "El usuario se ha registrado correctamente"): ?>
                        <div id="alertMessage"
                            style="background:#e8f9e8;color:#0e6b0e;padding:12px;margin-bottom:18px;
                                    border-left:4px solid #2ecc71;border-radius:4px;font-size:14px;
                                    opacity:1;transition:opacity .6s ease;">
                            <?= htmlspecialchars($mensaje) ?>
                        </div>

                    <?php else: ?>
                        <div id="alertMessage"
                            style="background:#ffdddd;color:#b30000;padding:12px;margin-bottom:18px;
                                    border-left:4px solid #cc0000;border-radius:4px;font-size:14px;
                                    opacity:1;transition:opacity .6s ease;">
                            <?= htmlspecialchars($mensaje) ?>
                        </div>
                    <?php endif; ?>

                    <script>
                        setTimeout(() => {
                            const alertBox = document.getElementById("alertMessage");
                            if (alertBox) {
                                alertBox.style.opacity = "0";
                                setTimeout(() => alertBox.remove(), 600);
                            }
                        }, 3000); 
                    </script>

                <?php endif; ?>



                <form class="auth-form register-form"
                      method="POST"
                      action="index.php?controller=user&action=register">

                    <div class="form-group full-width">
                        <label for="nombre">Nombre</label><br>
                        <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="apePa">Apellido Paterno</label>
                            <input type="text" id="apePa" name="apePa" placeholder="Apellido paterno" required>
                        </div>
                        <div class="form-group">
                            <label for="apeMa">Apellido Materno</label>
                            <input type="text" id="apeMa" name="apeMa" placeholder="Apellido materno">
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="correo">Correo electrónico</label><br>
                        <input type="email" id="correo" name="correo" placeholder="nombre@correo.com" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" id="password" name="password" placeholder="Mín. 8 caracteres" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirmar contraseña</label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Repite la contraseña" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="telefono">Teléfono (opcional)</label>
                            <input type="tel" id="telefono" name="telefono" placeholder="777 000 0000">
                        </div>
                        <div class="form-group">
                            <label for="genero">Género</label>
                            <select id="genero" name="genero" required>
                                <option value="">Selecciona una opción</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" name="enviar" class="auth-btn primary full-width">Crear cuenta</button>

                </form>

                <div class="auth-footer">
                    Ya tengo cuenta <a href="index.php?controller=user&action=login" class="auth-link">Iniciar sesión</a>
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
                    <li><a href="index.php?controller=home&action=index">Inicio</a></li>
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
