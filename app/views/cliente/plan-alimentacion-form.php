<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: index.php?controller=user&action=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Nutricional | Sport Zona</title>

    <!-- Usa el mismo CSS premium del cliente -->
    <link rel="stylesheet" href="public/css/horarios-cliente.css?v=3">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<div class="wrapper">

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar" id="sidebar">

        <div class="side-header">
            <h2 class="brand">Sport Zona</h2>
        </div>

        <nav class="sidebar-menu">
            <a href="index.php?controller=cliente&action=index" class="menu-item">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Regresar</span>
            </a>

            <a href="index.php?controller=PlanAlimentacion&action=clienteFormulario"
               class="menu-item active">
                <i class="fa-solid fa-bowl-food"></i>
                <span>Plan alimenticio</span>
            </a>
        </nav>

        <div class="logout-bar">
            <a href="index.php?controller=user&action=logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Cerrar sesión</span>
            </a>
        </div>
    </aside>

    <!-- ===== CONTENIDO PRINCIPAL ===== -->
    <div class="main-content">

        <h1 class="title horarios-title">
            <i class="fa-solid fa-bowl-rice"></i> Formulario nutricional
        </h1>
        <p class="subtitle horarios-sub">
            Completa este formulario para que tu entrenador pueda preparar tu plan personalizado.
        </p>

        <!-- ===== TARJETA PREMIUM ===== -->
        <div class="horarios-card nutrition-card">

            <div class="nutrition-card-header">
                <h2>Datos para tu plan</h2>
                <p>Cuida que la información sea lo más precisa posible.</p>
            </div>

            <form method="POST"
                  action="index.php?controller=PlanAlimentacion&action=guardarCuestionario"
                  class="nutrition-form">

                <!-- ===== SECCIÓN: DATOS GENERALES ===== -->
                <h3 class="section-title">Datos generales</h3>

                <div class="nutrition-grid">

                    <div class="form-field full">
                        <label>Nombre completo</label>
                        <input type="text" name="nombreCompleto" required>
                    </div>

                    <div class="form-field">
                        <label>Edad</label>
                        <input type="number" name="edad" required>
                    </div>

                    <div class="form-field">
                        <label>Peso (kg)</label>
                        <input type="number" step="0.1" name="peso" required>
                    </div>

                    <div class="form-field">
                        <label>Estatura (m)</label>
                        <input type="number" step="0.01" name="estatura" required>
                    </div>

                    <div class="form-field">
                        <label>Objetivo</label>
                        <select name="objetivo" required>
                            <option value="">Selecciona…</option>
                            <option>Aumentar masa muscular</option>
                            <option>Perder grasa corporal</option>
                            <option>Mejorar rendimiento</option>
                        </select>
                    </div>

                    <div class="form-field full">
                        <label>Enfermedades</label>
                        <textarea name="enfermedades"
                                  placeholder="Ej. hipertensión, diabetes, alergias…"></textarea>
                    </div>
                </div>

                <!-- ===== ACTIVIDAD FÍSICA ===== -->
                <h3 class="section-title">Actividad física</h3>

                <div class="nutrition-grid">

                    <div class="form-field">
                        <label>Deporte que practicas</label>
                        <input type="text" name="deporte"
                               placeholder="Gym, fútbol, natación…">
                    </div>

                    <div class="form-field">
                        <label>Días de ejercicio / semana</label>
                        <input type="number" name="diasSemana">
                    </div>

                    <div class="form-field">
                        <label>Horas de ejercicio / día</label>
                        <input type="number" step="0.1" name="horasDia">
                    </div>

                    <div class="form-field full">
                        <label>Horario de gimnasio</label>
                        <input type="text" name="horarioGym"
                               placeholder="Ej. Lunes a viernes 6:00 - 7:00 pm">
                    </div>
                </div>

                <!-- ===== HÁBITOS ALIMENTICIOS ===== -->
                <h3 class="section-title">Hábitos alimenticios</h3>

                <div class="nutrition-grid">

                    <div class="form-field">
                        <label>¿Consumes alcohol o fumas?</label>
                        <input type="text" name="fumaAlcohol"
                               placeholder="Ej. ocasionalmente">
                    </div>

                    <div class="form-field">
                        <label>Comidas por día</label>
                        <input type="number" name="comidasDia">
                    </div>

                    <div class="form-field full">
                        <label>Describe tu alimentación diaria</label>
                        <textarea name="alimentacionHabitos"
                                  placeholder="¿Qué desayunas, comes y cenas?"></textarea>
                    </div>

                    <div class="form-field">
                        <label>Comidas disponibles al día</label>
                        <input type="number" name="comidasDisponibles">
                    </div>

                    <div class="form-field full">
                        <label>Alimentos que no te gustan</label>
                        <textarea name="alimentosNoGustan"></textarea>
                    </div>

                    <div class="form-field full">
                        <label>Alimentos difíciles de dejar</label>
                        <input type="text" name="alimentosDificilesDejar">
                    </div>

                    <div class="form-field full">
                        <label>Alimentos que puedes comprar</label>
                        <textarea name="alimentosDisponibles"></textarea>
                    </div>
                </div>

                <!-- ===== SUEÑO Y SUPLEMENTOS ===== -->
                <h3 class="section-title">Sueño y suplementos</h3>

                <div class="nutrition-grid">

                    <div class="form-field">
                        <label>Suplementos</label>
                        <input type="text" name="suplementos">
                    </div>

                    <div class="form-field">
                        <label>Horario de sueño</label>
                        <input type="text" name="horarioSueno"
                               placeholder="Ej. 11:00 pm a 6:00 am">
                    </div>

                </div>

                <!-- BOTÓN -->
                <div class="nutrition-actions">
                    <button type="submit" class="btn-nutri-primary">
                        <i class="fa-solid fa-paper-plane"></i>
                        Enviar cuestionario
                    </button>
                </div>

            </form>

        </div><!-- card end -->

    </div><!-- main-content end -->

</div><!-- wrapper end -->

<script>
const sidebar = document.getElementById("sidebar");
const toggleBtn = document.getElementById("toggle-btn");

toggleBtn.addEventListener("click", ()=> sidebar.classList.toggle("collapsed"));
</script>

</body>
</html>
