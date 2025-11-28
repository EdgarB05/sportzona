<?php
class CoachController
{
    private $db;

    public function __construct($connection)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

         // BLOQUEO DE REGRESAR
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'entrenador') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $this->db = $connection;
    }

    public function index()
    {
        $idEntrenador = $_SESSION['id'];

        // ============================
        // CLIENTES ASIGNADOS
        // ============================
        $sql = "SELECT COUNT(*) AS total
                FROM usuarios
                WHERE rol='cliente' AND idCoach=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idEntrenador);
        $stmt->execute();
        $clientesAsignados = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

        // ============================
        // CITAS DE HOY
        // ============================
        $hoy = date("Y-m-d");
        $sql = "SELECT COUNT(*) AS total
                FROM citas c
                INNER JOIN usuarios u ON u.idUsuario = c.idUsuario
                WHERE u.idCoach = ? AND c.fecha = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("is", $idEntrenador, $hoy);
        $stmt->execute();
        $citasHoy = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

        // ============================
        // ENTRENAMIENTOS / PLANES
        // ============================
        $sql = "SELECT COUNT(*) AS total
                FROM entrenamiento
                WHERE idCoach=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idEntrenador);
        $stmt->execute();
        $planesActivos = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

        include "app/views/entrenador/dashboard.php";
    }
}
?>
