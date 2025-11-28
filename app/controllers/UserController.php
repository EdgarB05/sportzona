<?php
session_start();
include_once __DIR__ . "/../models/UserModel.php";

class UserController {
    private $model;

    public function __construct($connection){
        $this->model = new UserModel($connection);
    }

    // ========================
    // REGISTRO DE CLIENTES 
    // ========================
    public function register() {
        $mensaje = "";

        if (isset($_POST['enviar'])) {
            $nombre    = trim($_POST['nombre']);
            $apePa     = trim($_POST['apePa']);
            $apeMa     = trim($_POST['apeMa']);
            $genero    = $_POST['genero'];
            $telefono  = trim($_POST['telefono']);
            $correo    = trim($_POST['correo']);
            $password  = trim($_POST['password']);
            $rol       = 'cliente';
            $confirm_password = trim($_POST['confirm_password']);

            if (!empty($nombre) && !empty($apePa) && !empty($correo) && !empty($password)) {

                if ($password !== $confirm_password) {
                    $mensaje = "Las contraseñas no coinciden";

                } elseif ($this->model->verificarCorreoExistente($correo)) {
                    $mensaje = "Este correo ya ha sido utilizado";

                } else {
                    $pass_hash = password_hash($password, PASSWORD_BCRYPT);
                    $insert = $this->model->insertarUsuario(
                        $nombre, $apePa, $apeMa, $genero, $telefono, $correo, $pass_hash, $rol
                    );

                    if ($insert) {
                        $mensaje = "El usuario se ha registrado correctamente";
                    } else {
                        $mensaje = "Error en el registro";
                    }
                }
            } else {
                $mensaje = "Por favor completa todos los campos obligatorios.";
            }
        }

        include_once __DIR__ . "/../views/register.php";
        exit;
    }

    public function insertarUsuario() {
        $this->register();
    }

    // ========================
    // CONSULTA
    // ========================
    public function consultarUsuarios() {
        $buscar   = $_GET['buscar'] ?? '';
        $usuarios = $this->model->obtenerUsuarios($buscar);
        include "app/views/consultarC.php";
    }

    public function editarUsuario() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            echo "Error: ID de usuario no válido.";
            return;
        }
        $id = (int) $_GET['id'];
        $usuario = $this->model->obtenerUsuarioPorId($id);

        if (!$usuario) {
            echo "No se encontró el usuario.";
            return;
        }

        include "app/views/editarC.php";
    }

    public function actualizarUsuario() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?controller=user&action=consult");
            exit;
        }

        $id     = (int) $_POST['idUsuario'];
        $nombre = trim($_POST['nombre']);
        $apePa  = $_POST['apePa'];
        $apeMa  = $_POST['apeMa'];
        $genero = $_POST['genero'];

        $ok = $this->model->actualizarUsuario($id, $nombre, $apePa, $apeMa, $genero);

        if ($ok) {
            header("Location: index.php?controller=user&action=consult");
            exit;
        } else {
            echo "Error al actualizar el usuario.";
        }
    }

    public function eliminarUsuario() {

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            echo "Error: ID inválido.";
            return;
        }

        $id = (int) $_GET['id'];

        $resultado = $this->model->eliminarUsuario($id);

        switch ($resultado) {

            case "TIENE_CITAS_PENDIENTES":
                $_SESSION['error'] = "No puedes eliminar este usuario porque tiene citas pendientes o confirmadas.";
                break;

            case "TIENE_MEMBRESIA_ACTIVA":
                $_SESSION['error'] = "No puedes eliminar este usuario porque tiene una membresía activa.";
                break;

            case "ELIMINADO":
                $_SESSION['success'] = "El usuario ha sido eliminado correctamente.";
                break;

            default:
                $_SESSION['error'] = "Ocurrió un error al eliminar el usuario.";
        }

        header("Location: index.php?controller=user&action=consult");
        exit;
    }

    // ========================
    // LOGIN GENERAL
    // ========================
    public function login() {
        $mensaje = "";

        if (isset($_POST['enviar'])) {
            $correo   = trim($_POST['correo']);
            $password = trim($_POST['password']);

            if (!empty($correo) && !empty($password)) {

                // 1) ADMIN
                $resultado = $this->model->verificarAdministrador($correo, $password);
                if (!empty($resultado['success']) && $resultado['success'] === true) {
                    $this->iniciarSesion($resultado);
                    $this->redirigirSegunRol($resultado['rol']); 
                }

                // 2) ENTRENADOR
                $resultado = $this->model->verificarEntrenador($correo, $password);
                if (!empty($resultado['success']) && $resultado['success'] === true) {
                    $this->iniciarSesion($resultado);
                    $this->redirigirSegunRol($resultado['rol']);
                }

                // 3) CLIENTE
                $resultado = $this->model->verificarUsuario($correo, $password);
                if (!empty($resultado['success']) && $resultado['success'] === true) {
                    $this->iniciarSesion($resultado);
                    $this->redirigirSegunRol($resultado['rol']);
                }

                $mensaje = "Correo o contraseña incorrectos";

            } else {
                $mensaje = "Por favor ingresa tu correo y contraseña.";
            }
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        if (isset($_SESSION['id'])) {
            switch ($_SESSION['rol']) {
                case 'cliente':
                    header("Location: index.php?controller=cliente&action=index");
                    exit;
                case 'administrador':
                    header("Location: index.php?controller=administrador&action=index");
                    exit;
                case 'entrenador':
                    header("Location: index.php?controller=coach&action=index");
                    exit;
            }
        }

        include_once __DIR__ . "/../views/login.php";
        exit;
    }


    private function iniciarSesion($datosUsuario) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['id']     = $datosUsuario['id'];
        $_SESSION['nombre'] = $datosUsuario['nombre'];
        $_SESSION['rol']    = $datosUsuario['rol'];
        $_SESSION['correo'] = $datosUsuario['correo'] ?? null;

        if ($datosUsuario['rol'] === 'entrenador') {
            $_SESSION['idCoach'] = $datosUsuario['id'];
        }
    }

    private function redirigirSegunRol($rol) {
        switch ($rol) {
            case 'admin':
                header('Location: index.php?controller=adminhome&action=index');
                break;

            case 'entrenador':
                header('Location: index.php?controller=coach&action=index');
                break;

            default:
                header('Location: index.php?controller=cliente&action=index');
                break;
        }
        exit;
    }


    // =====================================================
    // REGISTRO DE ENTRENADOR
    // =====================================================
    public function registrarEntrenador() {
        if (!isset($_SESSION['id']) || ($_SESSION['rol'] ?? '') !== 'admin') {
            header('Location: index.php?controller=user&action=login');
            exit;
        }
        include __DIR__ . '/../views/entrenador/registrar_entrenador.php';
    }

    public function guardarEntrenador() {
        if (!isset($_SESSION['id']) || ($_SESSION['rol'] ?? '') !== 'admin') {
            header('Location: index.php?controller=user&action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre'        => trim($_POST['nombre']),
                'apellidopater' => trim($_POST['apePa']),
                'apellidomater' => trim($_POST['apeMa']),
                'genero'        => $_POST['genero'],
                'telCoach'      => trim($_POST['telefono']),
                'correo'        => trim($_POST['correo']),
                'usuarioAsig'   => trim($_POST['especialidad']),
                'fechareg'      => date('Y-m-d'),
                'contraseña'    => $_POST['password'] // SIN HASH
            ];

            $ok = $this->model->insertarEntrenador($data);

            $_SESSION[$ok ? 'success' : 'error'] =
                $ok ? 'Entrenador registrado correctamente.' : 'No se pudo registrar el entrenador.';

            header("Location: index.php?controller=user&action=consult");
            exit;
        }
    }

    // =====================================================
    // REGISTRO DE ADMIN
    // =====================================================
    public function registrarAdmin() {
        if (!isset($_SESSION['id']) || ($_SESSION['rol'] ?? '') !== 'admin') {
            header('Location: index.php?controller=user&action=login');
            exit;
        }
        include __DIR__ . '/../views/administrador/registrar_admin.php';
    }

    public function guardarAdmin() {
        if (!isset($_SESSION['id']) || ($_SESSION['rol'] ?? '') !== 'admin') {
            header('Location: index.php?controller=user&action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombreAdmin' => trim($_POST['nombreAdmin']),
                'nomUsuario'  => trim($_POST['nomUsuario']),
                'correoUti'   => trim($_POST['correoUti']),
                'contraseña'  => $_POST['contraseña'], // SIN HASH
                'rol'         => 'admin'
            ];

            $ok = $this->model->insertarAdministrador($data);

            $_SESSION[$ok ? 'success' : 'error'] =
                $ok ? 'Administrador registrado correctamente.' : 'No se pudo registrar el administrador.';

            header("Location: index.php?controller=user&action=consult");
            exit;
        }
    }

    public function realizarRespaldoBD(){
        $server = "localhost";
        $user   = "root";
        $pass   = "";
        $db     = "sportzona";

        $backup = $this->model->backup_tables($server, $user, $pass, $db);
        echo $backup;

        $fecha = date("Y-m-d");

        header("Content-disposition: attachment; filename=db-backup-" . $fecha . ".sql");
        header("Content-type: MIME");
        readfile("config/backups/db-backup-" . $fecha . ".sql");
    }

    public function restaurarBD() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Sólo el administrador puede restaurar
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $fecha = $_GET['fecha'] ?? date("Y-m-d");
        $ruta  = "config/backups/db-backup-" . $fecha . ".sql";

        $mensaje = $this->model->restaurarBD($ruta);

        $_SESSION['backup_message'] = $mensaje;

        header("Location: index.php?controller=adminhome&action=index");
        exit;
    }

    public function listarRespaldos() {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $backupDir = __DIR__ . "/../../config/backups"; // ruta correcta

        if (!is_dir($backupDir)) {
            $_SESSION['error'] = "No existe la carpeta de respaldos.";
            header("Location: index.php?controller=user&action=backup");
            exit;
        }

        $archivos = array_diff(scandir($backupDir), ['.', '.']);

        $respaldos = [];

        foreach ($archivos as $archivo) {
            if (pathinfo($archivo, PATHINFO_EXTENSION) === "sql") {
                $respaldos[] = [
                    "nombre" => $archivo,
                    "fecha"  => date("Y-m-d H:i:s", filemtime($backupDir . "/" . $archivo)),
                    "ruta"   => $archivo
                ];
            }
        }

        include "app/views/administrador/listar-respaldos.php";
    }


    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Limpiar sesión
        $_SESSION = [];
        session_unset();
        session_destroy();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        header("Location: index.php?controller=user&action=login");
        exit;
    }


    public function restaurarArchivo() {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        if (!isset($_GET['file'])) {
            $_SESSION['error'] = "No se seleccionó ningún archivo para restaurar.";
            header("Location: index.php?controller=user&action=listarRespaldos");
            exit;
        }

        $archivo = basename($_GET['file']);
        $ruta = __DIR__ . "/../../config/backups/" . $archivo;

        if (!file_exists($ruta)) {
            $_SESSION['error'] = "El archivo de respaldo no existe.";
            header("Location: index.php?controller=user&action=listarRespaldos");
            exit;
        }

        $host = "localhost";
        $user = "root";
        $pass = "";  
        $db   = "sportzona";

        $mysqlPath = "C:\\xampp\\mysql\\bin\\mysql.exe"; 

        if ($pass === "") {
            $comando = "cmd /c \"$mysqlPath\" -h $host -u $user $db < \"$ruta\"";
        } else {
            $comando = "cmd /c \"$mysqlPath\" -h $host -u $user -p$pass $db < \"$ruta\"";
        }

        exec($comando, $output, $resultado);

        if ($resultado === 0) {
            $_SESSION['success'] = "La base de datos fue restaurada correctamente desde: $archivo";
        } else {
            $_SESSION['error'] = "Ocurrió un error restaurando este respaldo.";

            file_put_contents("error_restore.log", 
                "CMD:\n$comando\n\nOUTPUT:\n" . implode("\n", $output) . "\nRESULTADO:\n$resultado"
            );
        }

        header("Location: index.php?controller=user&action=listarRespaldos");
        exit;
    }



    public function eliminarRespaldo() {

        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        if (!isset($_GET['file'])) {
            $_SESSION['error'] = "No se seleccionó ningún archivo para eliminar.";
            header("Location: index.php?controller=user&action=listarRespaldos");
            exit;
        }

        $archivo = basename($_GET['file']);
        $ruta = __DIR__ . "/../../config/backups/" . $archivo;

        if (!file_exists($ruta)) {
            $_SESSION['error'] = "El archivo de respaldo no existe.";
            header("Location: index.php?controller=user&action=listarRespaldos");
            exit;
        }

        // ELIMINAR ARCHIVO
        if (unlink($ruta)) {
            $_SESSION['success'] = "El respaldo '$archivo' fue eliminado correctamente.";
        } else {
            $_SESSION['error'] = "No se pudo eliminar el respaldo.";
        }

        header("Location: index.php?controller=user&action=listarRespaldos");
        exit;
    }
}
?>
