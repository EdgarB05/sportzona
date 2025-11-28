<?php
class EntrenamientosModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // ============================
    // LISTADO PARA COACH 
    // ============================
    public function obtenerTodos($buscar = '') {
        if ($buscar !== '') {
            $buscar = "%$buscar%";
            $sql = "SELECT e.*, c.nombre AS nombreCoach
                    FROM entrenamiento e
                    LEFT JOIN coach c ON e.idCoach = c.idCoach
                    WHERE e.nombreRutina LIKE ?
                       OR e.descripcionEje LIKE ?
                       OR e.dificultad LIKE ?
                    ORDER BY e.fechaCreacion DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sss", $buscar, $buscar, $buscar);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } else {
            $sql = "SELECT e.*, c.nombre AS nombreCoach
                    FROM entrenamiento e
                    LEFT JOIN coach c ON e.idCoach = c.idCoach
                    ORDER BY e.fechaCreacion DESC";
            $result = $this->db->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    // ============================
    // CREAR
    // ============================
    public function crear($data) {
        $sql = "INSERT INTO entrenamiento
                (nombreRutina, descripcionEje, dificultad, videoURL, idCoach)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "ssssi",
            $data['nombreRutina'],
            $data['descripcionEje'],
            $data['dificultad'],
            $data['videoURL'],
            $data['idCoach']
        );

        return $stmt->execute();
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM entrenamiento WHERE idEntrenamiento = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ============================
    // ACTUALIZAR
    // ============================
    public function actualizar($data) {
        $sql = "UPDATE entrenamiento
                SET nombreRutina = ?, descripcionEje = ?, dificultad = ?, videoURL = ?
                WHERE idEntrenamiento = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "ssssi",
            $data['nombreRutina'],
            $data['descripcionEje'],
            $data['dificultad'],
            $data['videoURL'],
            $data['idEntrenamiento']
        );

        return $stmt->execute();
    }

    // ============================
    // ELIMINAR
    // ============================
    public function eliminar($id) {
        $sql = "DELETE FROM entrenamiento WHERE idEntrenamiento = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // ============================
    // LISTADO PÚBLICO (HOME / CLIENTE)
    // ============================
    public function obtenerPublicos($buscar = '') {
        if ($buscar !== '') {
            $buscar = "%$buscar%";
            $sql = "SELECT e.*, c.nombre AS nombreCoach
                    FROM entrenamiento e
                    LEFT JOIN coach c ON e.idCoach = c.idCoach
                    WHERE e.nombreRutina LIKE ?
                       OR e.descripcionEje LIKE ?
                       OR e.dificultad LIKE ?
                    ORDER BY e.fechaCreacion DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sss", $buscar, $buscar, $buscar);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } else {
            $sql = "SELECT e.*, c.nombre AS nombreCoach
                    FROM entrenamiento e
                    LEFT JOIN coach c ON e.idCoach = c.idCoach
                    ORDER BY e.fechaCreacion DESC";
            $result = $this->db->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }
}
