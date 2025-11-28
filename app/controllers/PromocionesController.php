<?php
require_once __DIR__ . '/../models/PromocionModel.php';

class PromocionesController {
    private $model;

    public function __construct($connection) {
        session_start();
        $this->model = new PromocionModel($connection);
    }

    public function index() {
        $buscar = $_GET['buscar'] ?? '';

        if (!empty($buscar)) {
            $promociones = $this->model->buscarPromociones($buscar);
        } else {
            $promociones = $this->model->obtenerPromociones();
        }

        $promocion = null;
        include "app/views/administrador/admin-promociones.php";
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $idPromocion = $_POST['idPromocion'] ?? null;

        $titulo          = trim($_POST['nombrePromo']);
        $descripcion     = trim($_POST['descripcionPromo']);
        $tipo            = $_POST['tipoPromo'] ?? 'Descuento';
        $fechaInicio     = $_POST['fechaInicio'] ?? null;
        $fechaFin        = $_POST['fechaFin'] ?? null;
        $etiquetas       = $_POST['etiquetas'] ?? '';
        $estado          = $_POST['estadoAct'] ?? 'Borrador';
        $idAdministrador = $_SESSION['id'] ?? 1;

        if (empty($titulo) || empty($descripcion)) {
            $_SESSION['error'] = "El título y la descripción son obligatorios.";
            header("Location: index.php?controller=promociones&action=index");
            exit;
        }

        if ($idPromocion) {
            $ok = $this->model->actualizarPromocion(
                $idPromocion, $titulo, $descripcion, $tipo,
                $fechaInicio, $fechaFin, $etiquetas, $estado
            );
            $_SESSION[$ok ? 'success' : 'error'] = $ok ?
                " Promoción actualizada correctamente." :
                " Error al actualizar la promoción.";
        } else {
            $ok = $this->model->crearPromocion(
                $titulo, $descripcion, $tipo,
                $fechaInicio, $fechaFin, $etiquetas, $estado, $idAdministrador
            );
            $_SESSION[$ok ? 'success' : 'error'] = $ok ?
                " Promoción creada correctamente." :
                " Error al crear la promoción.";
        }

        header("Location: index.php?controller=promociones&action=index");
        exit;
    }

    public function delete() {
        if (!isset($_GET['id'])) return;
        $id = $_GET['id'];

        $ok = $this->model->eliminarPromocion($id);
        $_SESSION[$ok ? 'success' : 'error'] = $ok ?
            " Promoción eliminada correctamente." :
            " Error al eliminar la promoción.";

        header("Location: index.php?controller=promociones&action=index");
        exit;
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID no especificado.";
            header("Location: index.php?controller=promociones&action=index");
            exit;
        }

        $id = $_GET['id'];
        $promocion = $this->model->obtenerPromocionPorId($id);
        $promociones = $this->model->obtenerPromociones();
        include "app/views/administrador/admin-promociones.php";
    }

    public function toggle() {
        if (!isset($_GET['id']) || !isset($_GET['estado'])) {
            $_SESSION['error'] = "Datos insuficientes para cambiar estado.";
            header("Location: index.php?controller=promociones&action=index");
            exit;
        }

        $id = $_GET['id'];
        $estado = $_GET['estado'];

        $ok = $this->model->cambiarEstado($id, $estado);
        $_SESSION[$ok ? 'success' : 'error'] = $ok ?
            " Estado de la promoción actualizado correctamente." :
            " Error al actualizar el estado.";

        header("Location: index.php?controller=promociones&action=index");
        exit;
    }
}
?>
