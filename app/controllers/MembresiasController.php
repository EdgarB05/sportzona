<?php
require_once __DIR__ . '/../models/MembresiaModel.php';

class MembresiasController {
    private $model;

    public function __construct($connection) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->model = new MembresiaModel($connection);
    }

    public function index() {
        
        $this->model->actualizarEstadosVencidos();

        $buscar = $_GET['buscar'] ?? '';

        $usuarios = $this->model->obtenerUsuarios();
        $tipos = $this->model->obtenerTiposMembresia();

        $membresias = $this->model->obtenerMembresias($buscar);

        $membresiaEditar = null;


        include "app/views/administrador/admin-membresias.php";
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID de membresía no proporcionado.";
            header("Location: index.php?controller=membresias&action=index");
            exit;
        }

        $id = (int) $_GET['id'];

        $this->model->actualizarEstadosVencidos();
        $buscar = $_GET['buscar'] ?? '';

        $usuarios = $this->model->obtenerUsuarios();
        $tipos = $this->model->obtenerTiposMembresia();

        $membresiaEditar = $this->model->obtenerPorId($id);
        if (!$membresiaEditar) {
            $_SESSION['error'] = "La membresía seleccionada no existe.";
            header("Location: index.php?controller=membresias&action=index");
            exit;
        }

        $membresias = $this->model->obtenerMembresias($buscar);

        include "app/views/administrador/admin-membresias.php";
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?controller=membresias&action=index");
            exit;
        }

        $idMembresia     = $_POST['idMembresia'] ?? null;
        $idUsuario       = $_POST['idUsuario'];
        $idTipoMembresia = $_POST['idTipoMembresia'];
        $fechaInicio     = $_POST['fechaInicio'];
        $estado          = $_POST['estado'];

        if (empty($idUsuario) || empty($idTipoMembresia) || empty($fechaInicio)) {
            $_SESSION['error'] = "Todos los campos son obligatorios.";
            header("Location: index.php?controller=membresias&action=index");
            exit;
        }

        if ($idMembresia) {

            $ok = $this->model->actualizarMembresia(
                $idMembresia,
                $idUsuario,
                $idTipoMembresia,
                $fechaInicio,
                $estado
            );
            $_SESSION[$ok ? 'success' : 'error'] = $ok ?
                "Membresía actualizada correctamente." :
                "Error al actualizar la membresía.";
        } else {
            
            if ($this->model->usuarioTieneMembresiaActiva($idUsuario)) {
                $_SESSION['error'] = "El usuario ya tiene una membresía activa. "
                                . "No puedes asignar otra hasta que venza o se desactive.";
                header("Location: index.php?controller=membresias&action=index");
                exit;
            }

            $ok = $this->model->crearMembresia(
                $idUsuario,
                $idTipoMembresia,
                $fechaInicio,
                $estado
            );
            $_SESSION[$ok ? 'success' : 'error'] = $ok ?
                "Membresía creada correctamente." :
                "Error al crear la membresía.";
        }

        header("Location: index.php?controller=membresias&action=index");
        exit;
    }


    // ========== ELIMINAR ==========
    public function delete() {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID de membresía no proporcionado.";
            header("Location: index.php?controller=membresias&action=index");
            exit;
        }

        $id = (int) $_GET['id'];
        $ok = $this->model->eliminarMembresia($id);

        $_SESSION[$ok ? 'success' : 'error'] = $ok
            ? " Membresía eliminada correctamente."
            : " Error al eliminar la membresía.";

        header("Location: index.php?controller=membresias&action=index");
        exit;
    }

    public function calcularFechaFin($fechaInicio, $idTipoMembresia) {
        $duracion = [
            1 => "+1 month",
            2 => "+2 month",
            3 => "+3 month",
            4 => "+4 month",
            5 => "+12 month"
        ];

        return date("Y-m-d", strtotime($fechaInicio . " " . $duracion[$idTipoMembresia]));
    }

    public function enviarRecordatoriosManual() {

        require_once __DIR__ . '/../../libs/vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require_once __DIR__ . '/../../libs/vendor/phpmailer/phpmailer/src/SMTP.php';
        require_once __DIR__ . '/../../libs/vendor/phpmailer/phpmailer/src/Exception.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        // Obtener membresías que expiran en 3 días
        $membresias = $this->model->obtenerMembresiasPorVencer(3);

        if (empty($membresias)) {
            $_SESSION['error'] = "No hay usuarios con membresías próximas a vencer.";
            header("Location: index.php?controller=membresias&action=index");
            exit;
        }

        $enviados = 0;

        foreach ($membresias as $mem) {
            try {
                // SMTP
                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;
                $mail->Username = "misalalobg@gmail.com";
                $mail->Password = "bfwi whis uqwv ibxa"; 
                $mail->SMTPSecure = "tls";
                $mail->Port = 587;

                $mail->setFrom("misalalobg@gmail.com", "Sport Zona");
                $mail->addAddress($mem['correo']);

                $mail->isHTML(true);
                $mail->Subject = "Recordatorio de renovacion - Sport Zona";
                $mail->Body = "
                    Hola <strong>{$mem['nombre']}</strong>,<br><br>
                    Tu membresía está próxima a vencer.<br>
                    <strong>Fecha de vencimiento:</strong> {$mem['fechaFin']}<br><br>
                    Te recomendamos renovarla a tiempo.<br><br>
                    <strong>Sport Zona</strong>
                ";

                $mail->send();
                $enviados++;

            } catch (Exception $e) {
                error_log("Error enviando correo a {$mem['correo']} : " . $mail->ErrorInfo);
            }
        }

        $_SESSION['success'] = "Correos enviados correctamente: $enviados";
        header("Location: index.php?controller=membresias&action=index");
        exit;
    }



}
?>
