<?php 
class AvisoModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerAvisos() {
        $sql = "SELECT * FROM avisos ORDER BY fecha_creacion DESC";
        $result = mysqli_query($this->conn, $sql);
        $avisos = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $avisos[] = $row;
            }
        }
        return $avisos;
    }

    public function buscarAvisos($buscar) {
        $like = "%$buscar%";
        $sql = "SELECT * FROM avisos 
                WHERE titulo LIKE ? OR mensaje LIKE ? 
                ORDER BY fecha_creacion DESC";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $like, $like);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $avisos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $avisos[] = $row;
        }
        return $avisos;
    }

    public function obtenerAvisoPorId($id) {
        $sql = "SELECT * FROM avisos WHERE idAviso = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    public function crearAviso($titulo, $mensaje, $audiencia, $etiquetas, $nivel, $programacion, $fecha_programada, $id_admin) {
        if ($programacion === 'now') {
            $estado = 'publicado';
            $fecha_envio = date('Y-m-d H:i:s');
        } else {
            $estado = 'programado';
            $fecha_envio = $fecha_programada;
        }

        $sql = "INSERT INTO avisos 
                (titulo, mensaje, audiencia, etiquetas, nivel, fecha_envio, estado, idAdministrador, fecha_creacion)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssi",
            $titulo, $mensaje, $audiencia, $etiquetas, $nivel,
            $fecha_envio, $estado, $id_admin
        );

        return mysqli_stmt_execute($stmt);
    }


    public function actualizarAviso($id, $titulo, $mensaje, $audiencia, $etiquetas, $nivel, $programacion, $fecha_programada) {

        if ($programacion === 'now') {
            $estado = 'publicado';
            $fecha_envio = date('Y-m-d H:i:s');
        } else {
            $estado = 'programado';
            $fecha_envio = $fecha_programada;
        }

        $sql = "UPDATE avisos SET 
                titulo=?, mensaje=?, audiencia=?, etiquetas=?, nivel=?, 
                fecha_envio=?, estado=?, fecha_creacion=NOW()
                WHERE idAviso=?";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssi",
            $titulo, $mensaje, $audiencia, $etiquetas, $nivel,
            $fecha_envio, $estado, $id
        );

        return mysqli_stmt_execute($stmt);
    }


    public function eliminarAviso($id) {
        $sql = "DELETE FROM avisos WHERE idAviso = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }

    public function cambiarEstadoAviso($id, $estado) {
        $sql = "UPDATE avisos SET estado=?, fecha_envio=NOW() WHERE idAviso=?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $estado, $id);
        return mysqli_stmt_execute($stmt);
    }

    public function obtenerAvisosPublicadosCliente() {
        $sql = "SELECT * FROM avisos
                WHERE estado = 'publicado'
                AND fecha_envio <= NOW()
                ORDER BY fecha_creacion DESC";

        $result = mysqli_query($this->conn, $sql);
        $avisos = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $avisos[] = $row;
            }
        }
        return $avisos;
    }


}
?>
