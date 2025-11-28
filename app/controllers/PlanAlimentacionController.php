<?php
require_once __DIR__ . '/../models/PlanAlimentacionModel.php';

class PlanAlimentacionController {
    private $model;

    public function __construct($db) {
        $this->model = new PlanAlimentacionModel($db);
    }

    // ===============================
    // CLIENTE - Ver o llenar formulario
    // ===============================
    public function clienteFormulario() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
            header('Location: index.php?controller=user&action=login');
            exit;
        }

        $cuestionario = $this->model->obtenerPorUsuario($_SESSION['id']);
        if ($cuestionario) {
            require __DIR__ . '/../views/cliente/plan-alimentacion-resumen.php';
        } else {
            require __DIR__ . '/../views/cliente/plan-alimentacion-form.php';
        }
    }

    // ===============================
    // CLIENTE - Guardar formulario
    // ===============================
    public function guardarCuestionario() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
            header('Location: index.php?controller=user&action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'idUsuario'            => $_SESSION['id'],
                'nombreCompleto'       => $_POST['nombreCompleto'],
                'edad'                 => $_POST['edad'],
                'peso'                 => $_POST['peso'],
                'estatura'             => $_POST['estatura'],
                'objetivo'             => $_POST['objetivo'],
                'enfermedades'         => $_POST['enfermedades'],
                'deporte'              => $_POST['deporte'],
                'diasSemana'           => $_POST['diasSemana'],
                'horasDia'             => $_POST['horasDia'],
                'tiempoEjercicio'      => $_POST['tiempoEjercicio'],
                'horarioGym'           => $_POST['horarioGym'],
                'fumaAlcohol'          => $_POST['fumaAlcohol'],
                'comidasDia'           => $_POST['comidasDia'],
                'alimentacionHabitos'  => $_POST['alimentacionHabitos'],
                'comidasDisponibles'   => $_POST['comidasDisponibles'],
                'alimentosNoGustan'    => $_POST['alimentosNoGustan'],
                'alimentosDificilesDejar' => $_POST['alimentosDificilesDejar'],
                'alimentosDisponibles' => $_POST['alimentosDisponibles'],
                'suplementos'          => $_POST['suplementos'],
                'horarioSueno'         => $_POST['horarioSueno']
            ];

            $this->model->guardarCuestionario($data);
            header('Location: index.php?controller=PlanAlimentacion&action=clienteFormulario');
            exit;
        }
    }

    // ===============================
    // LISTAR (ADMIN / ENTRENADOR)
    // ===============================
    public function listar() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['admin', 'entrenador'])) {
            header('Location: index.php?controller=user&action=login');
            exit;
        }

        $buscar = $_GET['buscar'] ?? '';
        $idCoach = $_SESSION['id'];

        if ($_SESSION['rol'] === 'admin') {
            $cuestionarios = $this->model->obtenerCuestionarios($buscar);
            require __DIR__ . '/../views/administrador/plan-alimentacion-lista.php';
        } else {
            // Entrenador → solo los suyos
            $cuestionarios = $this->model->obtenerCuestionariosParaEntrenador($idCoach, $buscar);
            require __DIR__ . '/../views/entrenador/plan-alimentacion-lista.php';
        }
    }



    // ===============================
    // ENTRENADOR / ADMIN - Eliminar cuestionario
    // ===============================
    public function eliminar() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array($_SESSION['rol'], ['entrenador', 'admin'])) {
            header('Location: index.php');
            exit;
        }

        if (isset($_GET['id'])) {
            $this->model->eliminar($_GET['id']);
        }

        header('Location: index.php?controller=PlanAlimentacion&action=listar');
        exit;
    }

    // ===============================
    // ENTRENADOR / ADMIN - Ver plan completo
    // ===============================
    public function ver() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array($_SESSION['rol'], ['entrenador', 'admin'])) {
            header('Location: index.php');
            exit;
        }

        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID no especificado.";
            header("Location: index.php?controller=PlanAlimentacion&action=listar");
            exit;
        }

        $id = (int) $_GET['id'];
        $cuestionario = $this->model->obtenerCuestionarioPorId($id);

        if (!$cuestionario) {
            $_SESSION['error'] = "El cuestionario no existe.";
            header("Location: index.php?controller=PlanAlimentacion&action=listar");
            exit;
        }

        require __DIR__ . '/../views/entrenador/plan-alimentacion-detalles.php';
    }
}
