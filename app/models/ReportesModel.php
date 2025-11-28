<?php
class ReportesModel {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
    }

    /* ===========================
       REPORTE 1: Avisos enviados
       =========================== */
    public function obtenerAvisosPorFecha($inicio, $fin) {
        $sql = "SELECT titulo, estado, fecha_envio 
                FROM avisos 
                WHERE estado = 'publicado'
                AND DATE(fecha_envio) BETWEEN ? AND ?
                ORDER BY fecha_envio ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $inicio, $fin);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }



    /* ===========================
       REPORTE 2: Clientes por género
       =========================== */
    public function obtenerClientesGenero() {
        $sql = "SELECT genero, COUNT(*) AS total
                FROM usuarios
                GROUP BY genero";

        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    /* ===========================
       REPORTE 3: Membresías por tipo y estado
       =========================== */
    public function obtenerMembresiasResumen() {
        $sql = "SELECT t.nombre AS tipo, m.estado, COUNT(*) AS total
                FROM membresia m
                INNER JOIN tipo_membresia t ON m.idTipoMembresia = t.idTipoMembresia
                GROUP BY t.nombre, m.estado";

        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    /* ===========================
       REPORTE 4: Citas programadas
       =========================== */
    public function obtenerCitas($inicio, $fin) {
        $sql = "SELECT c.fecha, c.hora, c.estado, u.nombre AS cliente
                FROM citas c
                INNER JOIN usuarios u ON u.idUsuario = c.idUsuario
                WHERE c.fecha BETWEEN ? AND ?
                ORDER BY c.fecha ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $inicio, $fin);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
