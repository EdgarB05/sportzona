<?php
class PlanAlimentacionModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // ===============================
    // Guarda las respuestas del cliente
    // ===============================
    public function guardarCuestionario($data) {
        $sql = "INSERT INTO cuestionario_alimentacion (
            idUsuario, nombreCompleto, edad, peso, estatura, objetivo, enfermedades,
            deporte, diasSemana, horasDia, tiempoEjercicio, horarioGym, fumaAlcohol,
            comidasDia, alimentacionHabitos, comidasDisponibles, alimentosNoGustan,
            alimentosDificilesDejar, alimentosDisponibles, suplementos, horarioSueno
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->db->error);
        }

        $stmt->bind_param(
            "isidssssiidssssisssss",
            $data['idUsuario'],
            $data['nombreCompleto'],
            $data['edad'],
            $data['peso'],
            $data['estatura'],
            $data['objetivo'],
            $data['enfermedades'],
            $data['deporte'],
            $data['diasSemana'],
            $data['horasDia'],
            $data['tiempoEjercicio'],
            $data['horarioGym'],
            $data['fumaAlcohol'],
            $data['comidasDia'],
            $data['alimentacionHabitos'],
            $data['comidasDisponibles'],
            $data['alimentosNoGustan'],
            $data['alimentosDificilesDejar'],
            $data['alimentosDisponibles'],
            $data['suplementos'],
            $data['horarioSueno']
        );

        if (!$stmt->execute()) {
            die("Error al ejecutar el INSERT: " . $stmt->error);
        }

        $stmt->close();
    }

    // ===============================
    // Obtener todos los cuestionarios
    // ===============================
    public function obtenerCuestionarios() {
        $sql = "SELECT ca.*, u.nombre AS nombreUsuario
                FROM cuestionario_alimentacion ca
                JOIN usuarios u ON ca.idUsuario = u.idUsuario
                ORDER BY ca.idCuestionario DESC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ===============================
    // Obtener cuestionario de un cliente
    // ===============================
    public function obtenerPorUsuario($idUsuario) {
        $sql = "SELECT * FROM cuestionario_alimentacion WHERE idUsuario = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $cuestionario = $result->fetch_assoc();
        $stmt->close();
        return $cuestionario;
    }

    // ===============================
    // Eliminar un cuestionario
    // ===============================
    public function eliminar($id) {
        $sql = "DELETE FROM cuestionario_alimentacion WHERE idCuestionario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function obtenerPorIdCuestionario($idCuestionario) {
        $sql = "SELECT ca.*, u.nombre AS nombreUsuario, u.apePa, u.apeMa
                FROM cuestionario_alimentacion ca
                JOIN usuarios u ON u.idUsuario = ca.idUsuario
                WHERE ca.idCuestionario = ?
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idCuestionario);
        $stmt->execute();
        $result = $stmt->get_result();
        $fila = $result->fetch_assoc();
        $stmt->close();
        return $fila;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT ca.*, 
                u.nombre AS nombreUsuario,
                u.apePa AS apellidoPaterno,
                u.apeMa AS apellidoMaterno
                FROM cuestionario_alimentacion ca
                JOIN usuarios u ON ca.idUsuario = u.idUsuario
                WHERE ca.idCuestionario = ?
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cuestionario = $result->fetch_assoc();
        $stmt->close();
        return $cuestionario;
    }

    public function obtenerCuestionarioPorId($idCuestionario) {
        $sql = "SELECT ca.*, u.nombre AS nombreUsuario, u.apePa, u.apeMa
                FROM cuestionario_alimentacion ca
                INNER JOIN usuarios u ON u.idUsuario = ca.idUsuario
                WHERE ca.idCuestionario = ? LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idCuestionario);
        $stmt->execute();
        $result = $stmt->get_result();
        $cuestionario = $result->fetch_assoc();
        $stmt->close();

        return $cuestionario;
    }


    public function obtenerCuestionariosParaEntrenador(int $idCoach, string $buscar = '') {

        $sql = "SELECT ca.*, u.nombre AS nombreUsuario
                FROM cuestionario_alimentacion ca
                INNER JOIN usuarios u ON u.idUsuario = ca.idUsuario
                WHERE (ca.idCoach = ? OR ca.idCoach IS NULL)";

        $params = [$idCoach];
        $types  = "i";

        if ($buscar !== '') {
            $sql .= " AND (ca.nombreCompleto LIKE ? OR u.nombre LIKE ?)";
            $like = "%$buscar%";
            $params[] = $like;
            $params[] = $like;
            $types .= "ss";
        }

        $sql .= " ORDER BY ca.fechaRegistro DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $lista = [];
        while ($row = $result->fetch_assoc()) {
            $lista[] = $row;
        }

        $stmt->close();
        return $lista;
    }

}
