<?php
class UserModel {
    private $connection;
    
    public function __construct($connection) {
        $this->connection = $connection;
    }

    // =====================================================
    // CRUD PARA USUARIOS CLIENTES
    // =====================================================

    public function insertarUsuario($nombre, $apePa, $apeMa, $genero, $telefono, $correo, $password, $rol) {
        $statement = $this->connection->prepare(
            "INSERT INTO usuarios (nombre, apePa, apeMa, genero, telefono, correo, contrasena, rol)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $statement->bind_param("ssssssss", $nombre, $apePa, $apeMa, $genero, $telefono, $correo, $password, $rol);
        $result = $statement->execute();
        $statement->close();
        return $result;
    }

    public function verificarCorreoExistente($correo) {
        $statement = $this->connection->prepare("SELECT idUsuario FROM usuarios WHERE correo = ?");
        $statement->bind_param("s", $correo);
        $statement->execute();
        $statement->store_result();
        $existe = $statement->num_rows > 0;
        $statement->close();
        return $existe;
    }

    public function obtenerUsuarios($buscar = '') {
        if ($buscar !== '') {
            $like = "%{$buscar}%";
            $sql = "SELECT * FROM usuarios WHERE CONCAT(nombre, ' ', apePa, ' ', apeMa) LIKE ? OR correo LIKE ?";
            $statement = $this->connection->prepare($sql);
            $statement->bind_param("ss", $like, $like);
        } else {
            $statement = $this->connection->prepare("SELECT * FROM usuarios");
        }

        $statement->execute();
        $result = $statement->get_result();
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
        $statement->close();
        return $usuarios;
    }

    public function obtenerUsuarioPorId($id) {
        $statement = $this->connection->prepare("SELECT * FROM usuarios WHERE idUsuario = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        $usuario = $result->fetch_assoc();
        $statement->close();
        return $usuario;
    }

    public function actualizarUsuario($id, $nombre, $apePa, $apeMa, $genero) {
        $statement = $this->connection->prepare("UPDATE usuarios SET nombre = ?, apePa = ?, apeMa = ?, genero = ? WHERE idUsuario = ?");
        $statement->bind_param("ssssi", $nombre, $apePa, $apeMa, $genero, $id);
        $ok = $statement->execute();
        $statement->close();
        return $ok;
    }

    public function eliminarUsuario($id) {

        /* =============================
        1. Verificar citas pendientes
        ============================= */

        $sqlCheckCitas = "
            SELECT idCita 
            FROM citas 
            WHERE idUsuario = ? 
            AND estado IN ('pendiente', 'confirmada')
        ";

        $stmt = $this->connection->prepare($sqlCheckCitas);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            return "TIENE_CITAS_PENDIENTES";
        }
        $stmt->close();


        /* =============================
        2. Verificar membresía activa
        ============================= */

        $sqlCheckMem = "
            SELECT idMembresia 
            FROM membresia 
            WHERE idUsuario = ? 
            AND estado = 'activa'
        ";

        $stmt = $this->connection->prepare($sqlCheckMem);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            return "TIENE_MEMBRESIA_ACTIVA";
        }
        $stmt->close();


        /* =============================
        3. Eliminar citas del usuario
        ============================= */
        $sqlCitas = "DELETE FROM citas WHERE idUsuario = ?";
        $stmtCitas = $this->connection->prepare($sqlCitas);
        $stmtCitas->bind_param("i", $id);
        $stmtCitas->execute();
        $stmtCitas->close();


        /* =============================
        4. Eliminar membresías del usuario
        ============================= */
        $sqlMems = "DELETE FROM membresia WHERE idUsuario = ?";
        $stmtMems = $this->connection->prepare($sqlMems);
        $stmtMems->bind_param("i", $id);
        $stmtMems->execute();
        $stmtMems->close();

        //Eliminar Citas
        $sqlAlim = "DELETE FROM cuestionario_alimentacion WHERE idUsuario = ?";
        $sqlAlim = $this->connection->prepare($sqlAlim);
        $sqlAlim->bind_param("i", $id);
        $sqlAlim->execute();
        $sqlAlim->close();

        /* =============================
        5. Finalmente eliminar usuario
        ============================= */
        $stmt = $this->connection->prepare("DELETE FROM usuarios WHERE idUsuario = ?");
        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok ? "ELIMINADO" : "ERROR";
    }



    // =====================================================
    // LOGIN GENERAL
    // =====================================================

    // --- CLIENTE ---
    public function verificarUsuario($correo, $password) {
        $statement = $this->connection->prepare("SELECT idUsuario, nombre, contrasena, rol FROM usuarios WHERE correo = ?");
        $statement->bind_param("s", $correo);
        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows > 0) {
            $statement->bind_result($idUsuario, $nombre, $hash, $rol);
            $statement->fetch();

            if (password_verify($password, $hash)) {
                $statement->close();
                return ['success' => true, 'id' => $idUsuario, 'nombre' => $nombre, 'rol' => $rol];
            }
        }
        $statement->close();
        return ['success' => false];
    }

    // ENTRENADOR 
    public function verificarEntrenador($correo, $password) {
        $statement = $this->connection->prepare(
            "SELECT idCoach, nombre, correo, contrasena FROM coach WHERE correo = ?"
        );
        $statement->bind_param("s", $correo);
        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows > 0) {
            $statement->bind_result($idCoach, $nombreCoach, $correoCoach, $hash);
            $statement->fetch();

            if (password_verify($password, $hash)) {
                $statement->close();
                return [
                    'success' => true,
                    'id'      => $idCoach,
                    'nombre'  => $nombreCoach,
                    'correo'  => $correoCoach,
                    'rol'     => 'entrenador'
                ];
            }
        }

        $statement->close();
        return ['success' => false];
    }


    // =====================================================
    // NUEVO: REGISTRO DE ENTRENADOR Y ADMIN
    // =====================================================

    public function verificarAdministrador($correo, $password) {
        $statement = $this->connection->prepare("SELECT idAdministrador, nombreAdmin, contrasena FROM administrador WHERE correoUti = ?");
        $statement->bind_param("s", $correo);
        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows > 0) {
            $statement->bind_result($idAdmin, $nombreAdmin, $passDB);
            $statement->fetch();

            // 1) Intentar como hash
            $ok = password_verify($password, $passDB);

            // 2) Compatibilidad con registros viejos sin hash (admin123)
            if (!$ok && hash_equals($passDB, $password)) {
                $ok = true;
            }

            if ($ok) {
                $statement->close();
                return ['success' => true, 'id' => $idAdmin, 'nombre' => $nombreAdmin, 'rol' => 'admin'];
            }
        }
        $statement->close();
        return ['success' => false];
    }

    public function insertarEntrenador($data) {
        $sql = "INSERT INTO coach (nombre, apellidopater, apellidomater, genero, telCoach, correo, usuarioAsig, fechaing, contrasena)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param(
            "sssssssss",
            $data['nombre'], $data['apellidopater'], $data['apellidomater'], $data['genero'],
            $data['telCoach'], $data['correo'], $data['usuarioAsig'], $data['fechareg'], $data['contrasena']
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function insertarAdministrador($data) {
        $sql = "INSERT INTO administrador (nombreAdmin, nomUsuario, correoUti, contrasena, rol)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssss", $data['nombreAdmin'], $data['nomUsuario'], $data['correoUti'], $data['contrasena'], $data['rol']);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    // Método para realizar script de bd
    public function backup_tables($host, $user, $pass, $name, $tables = '*') {
        // Desactivar revisión de llaves foráneas
        $return = "SET FOREIGN_KEY_CHECKS = 0;\n\n";

        // Conexión directa para generar el backup
        $link = new mysqli($host, $user, $pass, $name);
        if ($link->connect_error) {
            die("Error de conexión para backup: " . $link->connect_error);
        }

        // Se obtienen los nombres de las tablas de datos si se eligen todas
        if ($tables == '*') {
            $tables = array();
            $result = $link->query('SHOW TABLES');
            // Guardar tablas de la base de datos
            while ($row = mysqli_fetch_row($result)) {
                $tables[] = $row[0];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        // Obtener los registros de cada tabla
        foreach ($tables as $table) {
            $result      = $link->query('SELECT * FROM ' . $table);
            $num_fields  = mysqli_num_fields($result);

            // Estructura de la tabla
            $row2 = mysqli_fetch_row($link->query('SHOW CREATE TABLE ' . $table));

            // Eliminar la tabla si existe
            $return .= "\n\nDROP TABLE IF EXISTS `$table`;\n";
            // Crear la tabla
            $return .= "\n" . $row2[1] . ";\n\n";

            // Insertar datos
            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $return .= 'INSERT INTO `' . $table . '` VALUES(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = preg_replace("/\n/", "\\n", $row[$j]);
                        if (isset($row[$j])) { 
                            $return .= '"' . $row[$j] . '"'; 
                        } else { 
                            $return .= '""'; 
                        }
                        if ($j < ($num_fields - 1)) { 
                            $return .= ','; 
                        }
                    }
                    $return .= ");\n";
                }
            }
            $return .= "\n\n\n";
        }

        // Reactivar llaves foráneas al final del script
        $return .= "SET FOREIGN_KEY_CHECKS = 1;\n";

        // Guardar el archivo de backup
        $fecha  = date("Y-m-d");
        $ruta   = 'config/backups/db-backup-' . $fecha . '.sql';


        // Asegurarse de que la carpeta exista
        if (!is_dir('config/backups')) {
            mkdir('config/backups', 0777, true);
        }

        $handle = fopen($ruta, 'w+');
        fwrite($handle, $return);
        fclose($handle);

        // Cerrar conexión auxiliar
        $link->close();

        return $ruta; // Por si quieres mostrar la ruta del archivo generado
    }


    // Método para la restauración de la bd
    public function restaurarBD($ruta){
        // Verificar que exista el archivo
        if (!file_exists($ruta)) {
            return "No se encontró el archivo de respaldo: $ruta";
        }

        // Leer el archivo del script
        $query_archivo = file_get_contents($ruta);

        // Ejecutar todas las consultas del .sql
        if ($this->connection->multi_query($query_archivo)) {

            do {
                if ($result = $this->connection->store_result()) {
                    $result->free();
                }
            } while ($this->connection->more_results() && $this->connection->next_result());

            return "Restauración exitosa";
        } else {
            return "Error en la restauración: " . $this->connection->error;
        }
    }
        
}
?>
