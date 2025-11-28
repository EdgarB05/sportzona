<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Sport Zona - Transforma tu cuerpo, transforma tu vida</title>
  <link rel="stylesheet" href="public/css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

  <!-- Navegación -->
  <header class="nav">
    <div class="container">
      <div class="logo">
        <i class="fas fa-dumbbell"></i>
        <span>Sport Zona</span>
      </div>

      <nav class="nav-menu">
        <a href="#inicio">Inicio</a>
        <a href="#servicios">Servicios</a>
        <a href="index.php?controller=home&action=horarios" class="btn-link">Horarios</a>
      </nav>

      <div class="nav-buttons">
        <a href="index.php?controller=user&action=login" class="boton">Iniciar sesión</a>
        <a href="index.php?controller=user&action=register" class="registrar">Regístrate</a>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section id="inicio" class="hero">
    <div class="hero-content">
      <h1>Transforma tu cuerpo, transforma tu vida.</h1>
      <p>Entrena en un espacio cómodo, seguro y diseñado para que alcances tus objetivos reales.</p>

      <div class="hero-buttons">
        <a href="index.php?controller=home&action=planes" class="btn btn-primary">Ver membresías</a>
      </div>
    </div>
  </section>

  <!-- Servicios -->
  <section id="servicios" class="servicios">
    <div class="container">
      <h2>Nuestros Servicios</h2>
      <p class="subtitle">Todo lo que necesitas para lograr tus objetivos</p>
      
      <div class="servicios-grid">

        <div class="servicio-card">
          <div class="servicio-icon"><i class="fas fa-running"></i></div>
          <h3>Entrenamiento básico</h3>
          <p>Rutinas esenciales y guía inicial para comenzar con buena técnica y seguridad.</p>
          <a href="index.php?controller=home&action=ejerciciosInfo" class="btn-link">Ver ejercicios</a>
        </div>

        <div class="servicio-card">
          <div class="servicio-icon"><i class="fas fa-apple-alt"></i></div>
          <h3>Planes alimenticios</h3>
          <p>Asesoría nutricional y menús prácticos alineados a tu objetivo.</p>
          <a href="index.php?controller=home&action=planAlimentacionInfo" class="btn-link">Ver información</a>
        </div>

        <div class="servicio-card">
          <div class="servicio-icon"><i class="fas fa-clock"></i></div>
          <h3>Horarios flexibles</h3>
          <p>Horarios que se ajustan a tu día.</p>
          <a href="index.php?controller=home&action=horarios" class="btn-link">Ver horarios</a>
        </div>

      </div>
    </div>
  </section>

  <!-- Por qué elegirnos -->
  <section id="caracteristicas" class="caracteristicas">
    <div class="container">
      <h2>Por qué elegirnos</h2>
      <p class="subtitle">Beneficios que marcan la diferencia</p>
      
      <div class="caracteristicas-grid">

        <div class="caracteristica-item">
          <i class="fa-solid fa-people-group caracteristica-icon"></i>
          <h4>Ambiente seguro y familiar</h4>
          <p>Un entorno amigable y cómodo donde todos pueden entrenar sin presión.</p>
        </div>

        <div class="caracteristica-item">
          <i class="fa-solid fa-expand caracteristica-icon"></i>
          <h4>Amplio espacio para entrenar</h4>
          <p>Zonas amplias y organizadas para ejercitarte sin esperar máquinas ni saturación.</p>
        </div>

        <div class="caracteristica-item">
          <i class="fas fa-clock caracteristica-icon"></i>
          <h4>Amplios horarios</h4>
          <p>Entrena cuando te venga mejor, con total flexibilidad.</p>
        </div>

        <div class="caracteristica-item">
          <i class="fas fa-users caracteristica-icon"></i>
          <h4>Comunidad motivadora</h4>
          <p>Ambiente dinámico, retos y eventos para mantenerte enfocado.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- Galería -->
<section id="galeria" class="galeria">
    <div class="container">
        <h2>Galería de resultados</h2>
        <p class="subtitle">Transformaciones reales de nuestra comunidad</p>

        <div class="carousel-container">
            <div class="carousel-track">
                <?php
                $folder = "public/media/GaleriaResultados/";
                $imagenes = array_diff(scandir($folder), ['.', '..']);

                foreach ($imagenes as $img): ?>
                    <div class="carousel-item">
                        <img src="<?= $folder . $img ?>" class="carousel-img" onclick="openFullscreen(this)">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- FULLSCREEN -->
<div id="fullscreenViewer" class="fullscreen-viewer" onclick="closeFullscreen()">
    <img id="fullscreenImg">
</div>



  <!-- Footer -->
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
                  <li><a href="#inicio">Inicio</a></li>
                  <li><a href="index.php#servicios">Servicios</a></li>
                  <li><a href="index.php?controller=home&action=horarios">Horarios</a></li>
              </ul>
          </div>

      </div>

      <div class="footer-bottom">
          © 2025 Sport Zona. Todos los derechos reservados.
      </div>
  </footer>


<script>
let index = 0;
const track = document.querySelector(".carousel-track");
const items = document.querySelectorAll(".carousel-item");
const total = items.length;

function moveCarousel() {
    index++;
    if (index > total - 3) index = 0;

    const offset = index * (items[0].offsetWidth + 20);
    track.style.transform = `translateX(-${offset}px)`;
}

// Auto-slide cada 3.5s
setInterval(moveCarousel, 3500);

/* ===== FULLSCREEN ===== */

function openFullscreen(img) {
    const viewer = document.getElementById("fullscreenViewer");
    const fullImg = document.getElementById("fullscreenImg");

    fullImg.src = img.src;
    viewer.style.display = "flex";
}

function closeFullscreen() {
    document.getElementById("fullscreenViewer").style.display = "none";
}
</script>


</body>
</html>
