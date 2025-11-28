<?php
class CitaModel {
    private $db;

    public function __construct($connection) {
        if (!$connection instanceof mysqli) {
            throw new Exception("CitaModel: parámetro inválido en el constructor");
        }
        $this->db = $connection;
    }

    // Crear cita (cliente)
    public function crearCita($idUsuario, $fecha, $hora, $motivo) {
        $sql = "INSERT INTO citas (idUsuario, fecha, hora, motivo, estado)
                VALUES (?, ?, ?, ?, 'pendiente')";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("isss", $idUsuario, $fecha, $hora, $motivo);
        return $stmt->execute();
    }

    // Citas de un cliente
    public function obtenerCitasPorUsuario($idUsuario) {
        $sql = "SELECT * FROM citas 
                WHERE idUsuario = ? 
                ORDER BY fecha DESC, hora DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Todas las citas para admin / entrenador (con datos de usuario)
    public function obtenerTodas() {
        $sql = "SELECT c.*, u.nombre, u.apePa, u.apeMa
                FROM citas c
                INNER JOIN usuarios u ON u.idUsuario = c.idUsuario
                ORDER BY c.fecha ASC, c.hora ASC";
        $res = $this->db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener una cita con info del usuario (para correo)
    public function obtenerDetalleCita($idCita) {
        $sql = "SELECT c.*, u.correo, u.nombre, u.apePa, u.apeMa
                FROM citas c
                INNER JOIN usuarios u ON u.idUsuario = c.idUsuario
                WHERE c.idCita = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idCita);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Cambiar estado (confirmar / rechazar)
    public function actualizarEstado($idCita, $nuevoEstado) {
        $sql = "UPDATE citas SET estado = ? WHERE idCita = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $nuevoEstado, $idCita);
        return $stmt->execute();
    }

    // Cancelar por cliente (sólo si es su cita)
    public function cancelarPorCliente($idCita, $idUsuario) {
        $sql = "UPDATE citas 
                SET estado = 'cancelada'
                WHERE idCita = ? AND idUsuario = ? AND estado IN ('pendiente','confirmada')";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $idCita, $idUsuario);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
