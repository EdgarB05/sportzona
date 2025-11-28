<?php
class MembresiaModel {
    /** @var mysqli */
    private $db;

    public function __construct($connection) {
        if (!$connection instanceof mysqli) {
            throw new Exception("MembresiaModel: el parámetro \$connection no es una instancia de mysqli");
        }

        $this->db = $connection;
    }

    public function obtenerUsuarios() {
        $sql = "SELECT idUsuario, nombre, apePa, apeMa
                FROM usuarios
                ORDER BY nombre";
        return $this->db->query($sql);
    }

    // Tipos de membresía (mensual, anual, etc.)
    public function obtenerTiposMembresia() {
        $sql = "SELECT idTipoMembresia, nombre, duracion_meses
                FROM tipo_membresia
                ORDER BY nombre";
        return $this->db->query($sql);
    }

    public function obtenerMembresias($buscar = '') {
        $sqlBase = "SELECT m.*, 
                           u.nombre AS nombreUsuario, u.apePa, u.apeMa,
                           t.nombre AS tipoNombre, t.duracion_meses
                    FROM membresia m
                    INNER JOIN usuarios u ON m.idUsuario = u.idUsuario
                    INNER JOIN tipo_membresia t ON m.idTipoMembresia = t.idTipoMembresia";

        if ($buscar !== '') {
            $sql = $sqlBase . " 
                    WHERE CONCAT(u.nombre, ' ', u.apePa, ' ', u.apeMa) LIKE ? 
                       OR t.nombre LIKE ?
                    ORDER BY m.fechaInicio DESC";

            $stmt = $this->db->prepare($sql);
            $like = "%$buscar%";
            $stmt->bind_param("ss", $like, $like);
            $stmt->execute();
            return $stmt->get_result();
        } else {
            $sql = $sqlBase . " ORDER BY m.fechaInicio DESC";
            return $this->db->query($sql);
        }
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM membresia WHERE idMembresia = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    private function obtenerDuracionMeses($idTipoMembresia) {
        $stmt = $this->db->prepare("SELECT duracion_meses FROM tipo_membresia WHERE idTipoMembresia = ?");
        $stmt->bind_param("i", $idTipoMembresia);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ? (int)$row['duracion_meses'] : 1;
    }

    public function crearMembresia($idUsuario, $idTipoMembresia, $fechaInicio, $estado) {
        $meses = $this->obtenerDuracionMeses($idTipoMembresia);
        $fechaFin = date('Y-m-d', strtotime("+$meses months", strtotime($fechaInicio)));

        $idAdministrador = $_SESSION['idAdministrador'] ?? ($_SESSION['id'] ?? 1);

        $stmt = $this->db->prepare("
            INSERT INTO membresia (idUsuario, idTipoMembresia, fechaInicio, fechaFin, estado, idAdministrador)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("iisssi", $idUsuario, $idTipoMembresia, $fechaInicio, $fechaFin, $estado, $idAdministrador);
        return $stmt->execute();
    }

    public function actualizarMembresia($idMembresia, $idUsuario, $idTipoMembresia, $fechaInicio, $estado) {
        $meses = $this->obtenerDuracionMeses($idTipoMembresia);
        $fechaFin = date('Y-m-d', strtotime("+$meses months", strtotime($fechaInicio)));

        $stmt = $this->db->prepare("
            UPDATE membresia
            SET idUsuario = ?, idTipoMembresia = ?, fechaInicio = ?, fechaFin = ?, estado = ?
            WHERE idMembresia = ?
        ");
        $stmt->bind_param("iisssi", $idUsuario, $idTipoMembresia, $fechaInicio, $fechaFin, $estado, $idMembresia);
        return $stmt->execute();
    }

    public function eliminarMembresia($id) {
        $stmt = $this->db->prepare("DELETE FROM membresia WHERE idMembresia = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function actualizarEstadosVencidos() {
        $hoy = date('Y-m-d');
        $stmt = $this->db->prepare("
            UPDATE membresia
            SET estado = 'vencida'
            WHERE fechaFin < ? AND estado = 'activa'
        ");
        $stmt->bind_param("s", $hoy);
        $stmt->execute();
    }

    public function usuarioTieneMembresiaActiva($idUsuario) {
        $sql = "SELECT COUNT(*) AS total
                FROM membresia
                WHERE idUsuario = ?
                  AND estado = 'activa'
                  AND fechaFin >= CURDATE()";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return ($res['total'] ?? 0) > 0;
    }

    // Versión para el dashboard del cliente
    public function obtenerMembresiaUsuario($idUsuario) {
        $sql = "SELECT m.*, t.nombre AS tipoNombre, u.correo
                FROM membresia m
                INNER JOIN tipo_membresia t ON m.idTipoMembresia = t.idTipoMembresia
                INNER JOIN usuarios u ON m.idUsuario = u.idUsuario
                WHERE m.idUsuario = ? AND m.estado = 'activa'
                ORDER BY m.fechaFin DESC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    public function obtenerMembresiasPorVencer($diasAntes = 3) {
        $sql = "
            SELECT m.*, u.correo, u.nombre
            FROM membresia m
            INNER JOIN usuarios u ON m.idUsuario = u.idUsuario
            WHERE m.estado = 'activa'
            AND m.fechaFin >= CURDATE()
            AND m.fechaFin <= DATE_ADD(CURDATE(), INTERVAL ? DAY)
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $diasAntes);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

}
