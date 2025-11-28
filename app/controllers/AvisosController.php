<?php
require_once __DIR__ . '/../models/AvisoModel.php';

class AvisosController {
    private $model;

    public function __construct($connection) {
        $this->model = new AvisoModel($connection);
    }

    public function index() {
        $buscar = $_GET['buscar'] ?? '';

        if (!empty($buscar)) {
            $avisos = $this->model->buscarAvisos($buscar);
        } else {
            $avisos = $this->model->obtenerAvisos();
        }

        $avisoEditar = null;
        include "app/views/administrador/admin-avisos.php";
    }

    public function show($id) {
        return $this->model->obtenerAvisoPorId($id);
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID del aviso no especificado.";
            header("Location: index.php?controller=avisos&action=index");
            exit;
        }

        $id = $_GET['id'];
        $avisoEditar = $this->model->obtenerAvisoPorId($id);
        $avisos = $this->model->obtenerAvisos();

        include "app/views/administrador/admin-avisos.php";
    }


    public function guardarAviso() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $idAviso   = $_POST['idAviso'] ?? null;
        $titulo    = trim($_POST['titulo']);
        $mensaje   = trim($_POST['mensaje']);
        $audiencia = $_POST['audiencia'];
        $etiquetas = $_POST['etiquetas'];
        $nivel     = $_POST['nivel'];
        $programacion = $_POST['programacion'];
        $fecha_programada = $_POST['fecha_programada'] ?? null;
        $id_admin  = $_SESSION['id'] ?? 1;

        if (empty($titulo) || empty($mensaje)) {
            $_SESSION['error'] = "El título y el mensaje son obligatorios.";
            header("Location: index.php?controller=avisos&action=index");
            exit;
        }

        if ($idAviso) {
            $ok = $this->model->actualizarAviso($idAviso, $titulo, $mensaje, $audiencia, $etiquetas, $nivel, $programacion, $fecha_programada);
            $_SESSION[$ok ? 'success' : 'error'] = $ok ? "Aviso actualizado correctamente." : "Error al actualizar el aviso.";
        } else {
            $ok = $this->model->crearAviso($titulo, $mensaje, $audiencia, $etiquetas, $nivel, $programacion, $fecha_programada, $id_admin);
            $_SESSION[$ok ? 'success' : 'error'] = $ok ? "Aviso creado correctamente." : "Error al crear el aviso.";
        }

        header("Location: index.php?controller=avisos&action=index");
        exit;
    }

    public function eliminarAviso($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $ok = $this->model->eliminarAviso($id);
        $_SESSION[$ok ? 'success' : 'error'] = $ok ? "Aviso eliminado." : "No se pudo eliminar el aviso.";
        header("Location: index.php?controller=avisos&action=index");
        exit;
    }

    public function cambiarEstado($id, $estado) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $ok = $this->model->cambiarEstadoAviso($id, $estado);
        $_SESSION[$ok ? 'success' : 'error'] = $ok ? "Estado actualizado." : "Error al cambiar el estado.";
        header("Location: index.php?controller=avisos&action=index");
        exit;
    }
}
?>
