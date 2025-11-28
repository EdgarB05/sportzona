<?php
include_once "config/db_connection.php";

// ========================
// Resolución de controlador / acción
// ========================
$controller = $_GET['controller'] ?? null;
$action     = $_GET['action']     ?? 'index';

// Si no hay controlador, mostramos la página pública de inicio
if ($controller === null) {
    include_once "app/controllers/HomeController.php";
    $home = new HomeController($connection);
    $home->index();
    exit;
}

// ========================
// Carga del controlador
// ========================
switch ($controller) {
    case 'home':
        include_once "app/controllers/HomeController.php";
        $controllerInstance = new HomeController($connection);
        break;

    case 'user':
        include_once "app/controllers/UserController.php";
        $controllerInstance = new UserController($connection);
        break;

    case 'avisos':
        include_once "app/controllers/AvisosController.php";
        $controllerInstance = new AvisosController($connection);
        break;

    case 'promociones':
        include_once "app/controllers/PromocionesController.php";
        $controllerInstance = new PromocionesController($connection);
        break;

    case 'adminhome':
        include_once "app/controllers/AdminHomeController.php";
        $controllerInstance = new AdminHomeController($connection);
        break;

    case 'coach':
        include_once "app/controllers/CoachController.php";
        $controllerInstance = new CoachController($connection);
        break;

    case 'cliente':
        include_once "app/controllers/ClienteController.php";
        $controllerInstance = new ClienteController($connection);
        break;

    case 'membresias':
        include_once "app/controllers/MembresiasController.php";
        $controllerInstance = new MembresiasController($connection);
        break;

    case 'PlanAlimentacion':
        include_once "app/controllers/PlanAlimentacionController.php";
        $controllerInstance = new PlanAlimentacionController($connection);
        break;

    case 'entrenamientos':
        include_once "app/controllers/EntrenamientosController.php";
        $controllerInstance = new EntrenamientosController($connection);
        break;

    case 'citas':
        include_once "app/controllers/CitasController.php";
        $controllerInstance = new CitasController($connection);
        break;

    case 'reportes':
        include_once "app/controllers/ReportesController.php";
        $controllerInstance = new ReportesController($connection);
        break;

    case 'reportesGraficos':
        include_once "app/controllers/ReportesGraficosController.php";
        $controllerInstance = new ReportesGraficosController($connection);
        break;

    case 'ajustes':
        // Para el enlace: index.php?controller=ajustes&action=index
        include_once "app/controllers/AjustesController.php";
        $controllerInstance = new AjustesController($connection);
        break;

    default:
        echo "Controlador no encontrado.";
        exit;
}

// ========================
// Enrutamiento de acciones
// ========================
switch ($action) {
        // -------- REGISTRO DESDE LA PÁGINA PÚBLICA --------
    case 'register':
        if ($controller === 'user' && method_exists($controllerInstance, 'register')) {
            $controllerInstance->register();
        } else {
            echo "La acción 'register' no existe en este controlador.";
        }
    break;

    // -------- CRUD usuarios (cliente) --------
    case 'insert':
        if ($controller === 'user') {
            $controllerInstance->insertarUsuario();
        } else {
            echo "La acción 'insert' no existe en este controlador.";
        }
        break;

    case 'consult':
        if ($controller === 'user' && method_exists($controllerInstance, 'consultarUsuarios')) {
            $controllerInstance->consultarUsuarios();
        } else {
            echo "La acción 'consult' no existe en este controlador.";
        }
        break;

    case 'login':
        if ($controller === 'user' && method_exists($controllerInstance, 'login')) {
            $controllerInstance->login();
        } else {
            echo "La acción 'login' no existe en este controlador.";
        }
        break;

    case 'update':
        // UPDATE para ENTRENAMIENTOS
        if ($controller === 'entrenamientos' && method_exists($controllerInstance, 'update')) {
            $controllerInstance->update();
        }
        // UPDATE para USUARIOS
        elseif ($controller === 'user' && method_exists($controllerInstance, 'actualizarUsuario')) {
            $controllerInstance->actualizarUsuario();
        }
        else {
            echo "<br>Acción 'update' no implementada para el controlador '$controller'.";
        }
        break;

    case 'delete':
        if ($controller === 'entrenamientos' && method_exists($controllerInstance, 'delete')) {
            $controllerInstance->delete();
        } elseif ($controller === 'avisos' && method_exists($controllerInstance, 'eliminarAviso')) {
            $id = $_GET['id'] ?? null;
            if ($id) $controllerInstance->eliminarAviso($id);
        } elseif ($controller === 'promociones' && method_exists($controllerInstance, 'delete')) {
            $controllerInstance->delete();
        } elseif ($controller === 'user' && method_exists($controllerInstance, 'eliminarUsuario')) {
            $controllerInstance->eliminarUsuario();
        } elseif ($controller === 'membresias' && method_exists($controllerInstance, 'delete')) {
            $controllerInstance->delete();
        } else {
            echo "<br>Acción 'delete' no implementada para el controlador '$controller'.";
        }
        break;

    case 'edit':
        if ($controller === 'entrenamientos' && method_exists($controllerInstance, 'edit')) {
            $controllerInstance->edit();
        } elseif ($controller === 'avisos' && method_exists($controllerInstance, 'edit')) {
            $controllerInstance->edit();
        } elseif ($controller === 'promociones' && method_exists($controllerInstance, 'edit')) {
            $controllerInstance->edit();
        } elseif ($controller === 'user' && method_exists($controllerInstance, 'editarUsuario')) {
            $controllerInstance->editarUsuario();
        } elseif ($controller === 'membresias' && method_exists($controllerInstance, 'edit')) {
            $controllerInstance->edit();
        } else {
            echo "<br>Acción 'edit' no implementada para el controlador '$controller'.";
        }
        break;

    // -------- Guardados / creación --------
    case 'save':
        if ($controller === 'avisos' && method_exists($controllerInstance, 'guardarAviso')) {
            $controllerInstance->guardarAviso();
        } elseif ($controller === 'promociones' && method_exists($controllerInstance, 'save')) {
            $controllerInstance->save();
        } elseif ($controller === 'membresias' && method_exists($controllerInstance, 'save')) {
            $controllerInstance->save();
        } else {
            echo "<br>Acción 'save' no implementada para el controlador '$controller'.";
        }
        break;

    case 'toggle':
        if ($controller === 'avisos' && method_exists($controllerInstance, 'cambiarEstado')) {
            $id      = $_GET['id'] ?? null;
            $estado  = $_GET['estado'] ?? null;
            if ($id && $estado) {
                $controllerInstance->cambiarEstado($id, $estado);
            } else {
                echo "<br>Faltan parámetros para cambiar el estado.";
            }
        } elseif ($controller === 'promociones' && method_exists($controllerInstance, 'toggle')) {
            $controllerInstance->toggle();
        } else {
            echo "<br>Acción 'toggle' no implementada para el controlador '$controller'.";
        }
        break;

    case 'index':
        if (method_exists($controllerInstance, 'index')) {
            $controllerInstance->index();
        } else {
            echo "<br>Acción 'index' no existe en el controlador '$controller'.";
        }
        break;

    case 'create':
        if (method_exists($controllerInstance, 'create')) {
            $controllerInstance->create();
        } else {
            echo "<br>Acción 'create' no existe en el controlador '$controller'.";
        }
        break;

    // -------- Planes de alimentación --------
    case 'clienteFormulario':
        if ($controller === 'PlanAlimentacion') {
            $controllerInstance->clienteFormulario();
        } else {
            echo "Acción 'clienteFormulario' no disponible para '$controller'.";
        }
        break;

    case 'guardarCuestionario':
        if ($controller === 'PlanAlimentacion' && method_exists($controllerInstance, 'guardarCuestionario')) {
            $controllerInstance->guardarCuestionario();
        } else {
            echo "<br>Acción 'guardarCuestionario' no implementada para el controlador '$controller'.";
        }
        break;

    case 'listar':
        if (method_exists($controllerInstance, 'listar')) {
            $controllerInstance->listar();
        } else {
            echo "Acción 'listar' no implementada para '$controller'.";
        }
        break;

    case 'eliminar':
        if (method_exists($controllerInstance, 'eliminar')) {
            $controllerInstance->eliminar();
        } else {
            echo "Acción 'eliminar' no implementada para '$controller'.";
        }
        break;

    case 'ver':
        if ($controller === 'PlanAlimentacion' && method_exists($controllerInstance, 'ver')) {
            $controllerInstance->ver();
        } else {
            echo "<br>Acción 'ver' no implementada para el controlador '$controller'.";
        }
        break;

    // -------- Nuevos registros admin / entrenador --------
    case 'registrar_admin':
        if ($controller === 'user' && method_exists($controllerInstance, 'registrarAdmin')) {
            $controllerInstance->registrarAdmin();
        } else {
            echo "<br>Acción 'registrar_admin' no disponible.";
        }
        break;

    case 'registrar_entrenador':
        if ($controller === 'user' && method_exists($controllerInstance, 'registrarEntrenador')) {
            $controllerInstance->registrarEntrenador();
        } else {
            echo "<br>Acción 'registrar_entrenador' no disponible.";
        }
        break;

    case 'guardar_admin':
        if ($controller === 'user' && method_exists($controllerInstance, 'guardarAdmin')) {
            $controllerInstance->guardarAdmin();
        } else {
            echo "<br>Acción 'guardar_admin' no disponible.";
        }
        break;

    case 'guardar_entrenador':
        if ($controller === 'user' && method_exists($controllerInstance, 'guardarEntrenador')) {
            $controllerInstance->guardarEntrenador();
        } else {
            echo "<br>Acción 'guardar_entrenador' no disponible.";
        }
        break;

    // -------- Respaldo y restauración BD --------
    case 'backup':
        if ($controller === 'user' && method_exists($controllerInstance, 'realizarRespaldoBD')) {
            $controllerInstance->realizarRespaldoBD();
        } else {
            echo "Acción 'backup' no implementada para '$controller'.";
        }
        break;

    case 'restaurar':
        if ($controller === 'user' && method_exists($controllerInstance, 'restaurarBD')) {
            $controllerInstance->restaurarBD();
        } else {
            echo "Acción 'restaurar' no implementada para el controlador '$controller'.";
        }
        break;

    // -------- Entrenamientos --------
    case 'store':
        if ($controller === 'entrenamientos' && method_exists($controllerInstance, 'store')) {
            $controllerInstance->store();
        } else {
            echo "<br>Acción 'store' no implementada para el controlador '$controller'.";
        }
        break;

    case 'public':
        if ($controller === 'entrenamientos' && method_exists($controllerInstance, 'public')) {
            $controllerInstance->public();
        } else {
            echo "<br>Acción 'public' no implementada para el controlador '$controller'.";
        }
        break;

    case 'publicList':
        if ($controller === 'entrenamientos' && method_exists($controllerInstance, 'publicList')) {
            $controllerInstance->publicList();
        } else {
            echo "<br>Acción 'publicList' no implementada para el controlador '$controller'.";
        }
        break;

    case 'cliente':
        if ($controller === 'entrenamientos' && method_exists($controllerInstance, 'cliente')) {
            $controllerInstance->cliente();
        } else {
            echo "<br>Acción 'cliente' no implementada para el controlador '$controller'.";
        }
        break;

    case 'verEntrenamiento':
        if ($controller === 'entrenamientos' && method_exists($controllerInstance, 'ver')) {
            $controllerInstance->ver();
        } else {
            echo "<br>Acción 'ver' no implementada para entrenamientos.";
        }
        break;

    // -------- Membresías: recordatorios --------
    case 'enviarRecordatorios':
        if ($controller === 'membresias' && method_exists($controllerInstance, 'enviarRecordatoriosManual')) {
            $controllerInstance->enviarRecordatoriosManual();
        } else {
            echo "Acción de recordatorio no disponible.";
        }
        break;

    // -------- Citas --------
    case 'agendar':
        if ($controller === 'citas' && method_exists($controllerInstance, 'agendar')) {
            $controllerInstance->agendar();
        } else {
            echo "Acción 'agendar' no implementada.";
        }
        break;

    case 'guardar':
        if ($controller === 'citas' && method_exists($controllerInstance, 'guardar')) {
            $controllerInstance->guardar();
        } else {
            echo "Acción 'guardar' no implementada para '$controller'.";
        }
        break;

    case 'listaCliente':
        if ($controller === 'citas' && method_exists($controllerInstance, 'listaCliente')) {
            $controllerInstance->listaCliente();
        } else {
            echo "Acción 'listaCliente' no implementada.";
        }
        break;

    case 'lista':
        if ($controller === 'citas' && method_exists($controllerInstance, 'lista')) {
            $controllerInstance->lista();
        } elseif (method_exists($controllerInstance, 'lista')) {
            $controllerInstance->lista();
        } else {
            echo "Acción 'lista' no implementada.";
        }
        break;

    case 'actualizarEstado':
        if ($controller === 'citas' && method_exists($controllerInstance, 'actualizarEstado')) {
            $controllerInstance->actualizarEstado();
        } else {
            echo "Acción 'actualizarEstado' no implementada.";
        }
        break;

    case 'cancelar':
        if ($controller === 'citas' && method_exists($controllerInstance, 'cancelar')) {
            $controllerInstance->cancelar();
        } else {
            echo "Acción 'cancelar' no implementada.";
        }
        break;

    // -------- Reportes --------
    case 'generar':
        if ($controller === 'reportes' && method_exists($controllerInstance,'generar')) {
            $controllerInstance->generar();
        } elseif ($controller === 'reportesGraficos' && method_exists($controllerInstance,'generar')) {
            $controllerInstance->generar();
        } else {
            echo "Acción 'generar' no disponible.";
        }
        break;

    case 'graficas':
        if ($controller === 'reportesGraficos' && method_exists($controllerInstance,'graficas')) {
            $controllerInstance->graficas();
        } else {
            echo "Acción 'graficas' no disponible.";
        }
        break;

    case 'planAlimentacionInfo':
        // Página de plan de alimentación (información)
        if ($controller === 'home' && method_exists($controllerInstance, 'planAlimentacionInfo')) {
            $controllerInstance->planAlimentacionInfo();
        } else {
            echo "La acción 'planAlimentacionInfo' no existe en este controlador.";
        }
        break;

    case 'logout':
        if ($controller === 'user' && method_exists($controllerInstance, 'logout')) {
            $controllerInstance->logout();
        } else {
            echo "Acción 'logout' no implementada para el controlador '$controller'.";
        }
        break;

    case 'horarios':
        if ($controller === 'cliente' && method_exists($controllerInstance, 'horarios')) {
            $controllerInstance->horarios();
        } elseif ($controller === 'home' && method_exists($controllerInstance, 'horarios')) {
            $controllerInstance->horarios();
        } else {
            echo "La acción 'horarios' no existe en este controlador.";
        }
        break;

    case 'planes':
        if ($controller === 'home' && method_exists($controllerInstance, 'planes')) {
            $controllerInstance->planes();
        } else {
            echo "La acción 'planes' no existe en este controlador.";
        }
        break;

    case 'membresia':
        if ($controller === 'cliente' && method_exists($controllerInstance, 'membresia')) {
            $controllerInstance->membresia();
        } else {
            echo "La acción 'membresia' no existe en este controlador.";
        }
        break;

    case 'ejerciciosInfo':
        if ($controller === 'home' && method_exists($controllerInstance, 'ejerciciosInfo')) {
            $controllerInstance->ejerciciosInfo();
         } else {
            echo "La acción 'ejerciciosInfo' no existe en este controlador.";
            }
        break;
    case 'listarRespaldos':
        if ($controller === 'user' && method_exists($controllerInstance, 'listarRespaldos')) {
            $controllerInstance->listarRespaldos();
         } else {
            echo "La acción 'listarRespaldos' no existe en este controlador.";
            }
        break;
    case 'eliminarRespaldo':
        if ($controller === 'user' && method_exists($controllerInstance, 'eliminarRespaldo')) {
            $controllerInstance->eliminarRespaldo();
        } else {
            echo "Acción 'eliminarRespaldo' no existe en este controlador.";
        }
        break;
    case 'restaurarArchivo':
        if ($controller === 'user' && method_exists($controllerInstance, 'restaurarArchivo')) {
            $controllerInstance->restaurarArchivo();
        } else {
            echo "Acción 'restaurarArchivo' no existe en este controlador.";
        }
        break;

    // =========================
    // POR DEFECTO
    // =========================
    default:
        echo "<br>Acción no reconocida o no implementada.";
        break;
}

exit;
?>




