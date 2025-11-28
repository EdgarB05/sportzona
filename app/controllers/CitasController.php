<?php
require_once __DIR__ . '/../models/CitaModel.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CitasController {
    private $model;

    public function __construct($connection) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->model = new CitaModel($connection);
    }

    // ============================================================
    // CLIENTE: FORMULARIO PARA AGENDAR CITA
    // ============================================================
    public function agendar() {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'cliente') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $idUsuario = $_SESSION['id'];
        $citas = $this->model->obtenerCitasPorUsuario($idUsuario);

        require __DIR__ . '/../views/cliente/citas-agendar.php';
    }

    // ============================================================
    // CLIENTE: GUARDAR NUEVA CITA
    // ============================================================
    public function guardar() {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'cliente') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?controller=citas&action=agendar");
            exit;
        }

        $idUsuario = $_SESSION['id'];
        $fecha = $_POST['fechaCita'] ?? '';
        $hora  = $_POST['horaCita'] ?? '';
        $motivo = trim($_POST['motivo'] ?? '');

        if (empty($fecha) || empty($hora) || empty($motivo)) {
            $_SESSION['error'] = "Todos los campos son obligatorios.";
            header("Location: index.php?controller=citas&action=agendar");
            exit;
        }

        $ok = $this->model->crearCita($idUsuario, $fecha, $hora, $motivo);

        if ($ok) {
            $_SESSION['success'] = "Cita agendada correctamente. Espera confirmación.";
        } else {
            $_SESSION['error'] = "Error al agendar la cita.";
        }

        header("Location: index.php?controller=citas&action=listaCliente");
        exit;
    }

    // ============================================================
    // CLIENTE: VER SUS CITA
    // ============================================================
    public function listaCliente() {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'cliente') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $idUsuario = $_SESSION['id'];
        $citas = $this->model->obtenerCitasPorUsuario($idUsuario);

        require __DIR__ . '/../views/cliente/citas-agendar.php';
    }

    // ============================================================
    // CLIENTE: CANCELAR CITA
    // ============================================================
    public function cancelar() {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'cliente') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $idCita = $_GET['id'] ?? null;

        if (!$idCita) {
            header("Location: index.php?controller=citas&action=listaCliente");
            exit;
        }

        $ok = $this->model->cancelarPorCliente($idCita, $_SESSION['id']);

        $_SESSION[$ok ? 'success' : 'error'] = $ok
            ? "Cita cancelada correctamente."
            : "No se pudo cancelar la cita.";

        header("Location: index.php?controller=citas&action=listaCliente");
        exit;
    }

    // ============================================================
    // ADMIN / ENTRENADOR: LISTA COMPLETA
    // ============================================================
    public function lista() {
        if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['admin','entrenador'])) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $citas = $this->model->obtenerTodas();

        if ($_SESSION['rol'] === 'admin') {
            require __DIR__ . '/../views/administrador/citas-lista.php';
        } else {
            require __DIR__ . '/../views/entrenador/citas-lista.php';
        }
    }

    // ============================================================
    // ADMIN / ENTRENADOR: CONFIRMAR / RECHAZAR CITA
    // ============================================================
    public function actualizarEstado() {
        if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['admin','entrenador'])) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $idCita = $_GET['id'] ?? null;
        $estado = $_GET['estado'] ?? null;

        if (!$idCita || !in_array($estado, ['confirmada','rechazada'])) {
            header("Location: index.php?controller=citas&action=lista");
            exit;
        }

        $detalle = $this->model->obtenerDetalleCita($idCita);
        if (!$detalle) {
            header("Location: index.php?controller=citas&action=lista");
            exit;
        }

        $ok = $this->model->actualizarEstado($idCita, $estado);

        if ($ok) {
            $this->enviarCorreoEstadoCita(
                $detalle['correo'],
                $detalle['nombre'] . ' ' . $detalle['apePa'],
                $estado,
                $detalle['fecha'],
                $detalle['hora']
            );
            $_SESSION['success'] = "Estado de la cita actualizado y correo enviado.";
        } else {
            $_SESSION['error'] = "No se pudo actualizar el estado de la cita.";
        }

        header("Location: index.php?controller=citas&action=lista");
        exit;
    }

    // ============================================================
    // CORREO DE NOTIFICACIÓN
    // ============================================================
    private function enviarCorreoEstadoCita($correoDestino, $nombre, $estado, $fecha, $hora) {
        require_once __DIR__ . '/../../libs/vendor/phpmailer/phpmailer/src/Exception.php';
        require_once __DIR__ . '/../../libs/vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require_once __DIR__ . '/../../libs/vendor/phpmailer/phpmailer/src/SMTP.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'misalalobg@gmail.com';
            $mail->Password   = 'bfwi whis uqwv ibxa';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('misalalobg@gmail.com', 'Sport Zona');
            $mail->addAddress($correoDestino, $nombre);
            $mail->isHTML(true);

            if ($estado === 'confirmada') {
                $asunto = "Tu cita ha sido CONFIRMADA";
                $estadoTexto = "CONFIRMADA ";
                $mensajeExtra = "Te esperamos en tu cita a la fecha y hora indicadas.";
            } else {
                $asunto = "Tu cita ha sido RECHAZADA";
                $estadoTexto = "RECHAZADA ";
                $mensajeExtra = "Por favor agenda otra cita en un horario diferente.";
            }

            $mail->Subject = $asunto;
            $mail->Body = "
                <h2>Hola, $nombre</h2>
                <p>El estado de tu cita ahora es: <strong>$estadoTexto</strong></p>
                <p><strong>Fecha:</strong> $fecha<br>
                   <strong>Hora:</strong> $hora</p>
                <p>$mensajeExtra</p><br>
                <p>Atentamente,<br>Sport Zona</p>
            ";

            $mail->send();

        } catch (Exception $e) {
            error_log("Error al enviar correo de cita: {$mail->ErrorInfo}");
        }
    }
}
