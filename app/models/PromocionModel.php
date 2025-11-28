<?php
class PromocionModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerPromociones() {
        $sql = "SELECT * FROM promocion ORDER BY fechaInicio DESC";
        $result = mysqli_query($this->conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function buscarPromociones($buscar) {
        $like = "%$buscar%";
        $sql = "SELECT * FROM promocion 
                WHERE nombrePromo LIKE ? 
                OR descripcionPromo LIKE ? 
                OR etiquetas LIKE ?
                ORDER BY fechaInicio DESC";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $like, $like, $like);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function crearPromocion($titulo, $descripcion, $tipo, $fechaInicio, $fechaFin, $etiquetas, $estado, $idAdministrador) {
        $sql = "INSERT INTO promocion 
                (nombrePromo, descripcionPromo, tipoPromo, fechaInicio, fechaFin, etiquetas, estadoAct, idAdministrador) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "sssssssi",
            $titulo,
            $descripcion,
            $tipo,
            $fechaInicio,
            $fechaFin,
            $etiquetas,
            $estado,
            $idAdministrador
        );
        return mysqli_stmt_execute($stmt);
    }

    public function actualizarPromocion($id, $titulo, $descripcion, $tipo, $fechaInicio, $fechaFin, $etiquetas, $estado) {
        $sql = "UPDATE promocion SET 
                    nombrePromo = ?, 
                    descripcionPromo = ?, 
                    tipoPromo = ?, 
                    fechaInicio = ?, 
                    fechaFin = ?, 
                    etiquetas = ?, 
                    estadoAct = ?
                WHERE idPromocion = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "sssssssi",
            $titulo,
            $descripcion,
            $tipo,
            $fechaInicio,
            $fechaFin,
            $etiquetas,
            $estado,
            $id
        );
        return mysqli_stmt_execute($stmt);
    }

    public function eliminarPromocion($id) {
        $sql = "DELETE FROM promocion WHERE idPromocion = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }

    public function obtenerPromocionPorId($id) {
        $sql = "SELECT * FROM promocion WHERE idPromocion = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    public function cambiarEstado($id, $nuevoEstado) {
        $sql = "UPDATE promocion SET estadoAct = ? WHERE idPromocion = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $nuevoEstado, $id);
        return mysqli_stmt_execute($stmt);
    }

    public function obtenerPromocionesVigentesCliente($limite = 4) {
        $sql = "SELECT * FROM promocion
                WHERE LOWER(estadoAct) = 'activo'
                AND DATE(fechaInicio) <= CURDATE()
                AND DATE(fechaFin) >= CURDATE()
                ORDER BY fechaFin ASC
                LIMIT ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $limite);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $promos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $promos[] = $row;
        }

        return $promos;
    }

}
?>
