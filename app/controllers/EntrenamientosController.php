<?php
require_once __DIR__ . '/../models/EntrenamientosModel.php';

class EntrenamientosController {
    private $model;

    public function __construct($db) {
        $this->model = new EntrenamientosModel($db);
    }

    // ============================
    // LISTADO PARA COACH (CRUD)
    // ============================
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'entrenador') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $buscar = $_GET['buscar'] ?? '';
        $lista = $this->model->obtenerTodos($buscar);

        require __DIR__ . '/../views/entrenador/entrenamientos-lista.php';
    }

    // ============================
    // FORMULARIO CREAR
    // ============================
    public function create() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SESSION['rol'] !== 'entrenador') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        require __DIR__ . '/../views/entrenador/entrenamientos-form.php';
    }

    // ============================
    // GUARDAR NUEVO
    // ============================
    public function store() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SESSION['rol'] !== 'entrenador') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $data = [
            'nombreRutina'   => trim($_POST['nombreRutina'] ?? ''),
            'descripcionEje' => trim($_POST['descripcionEje'] ?? ''),
            'dificultad'     => $_POST['dificultad'] ?? 'Media',
            'videoURL'       => trim($_POST['videoURL'] ?? ''),
            'idCoach'        => $_SESSION['id']
        ];

        $this->model->crear($data);

        header("Location: index.php?controller=entrenamientos&action=index");
        exit;
    }

    // ============================
    // EDITAR
    // ============================
    public function edit() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SESSION['rol'] !== 'entrenador') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?controller=entrenamientos&action=index");
            exit;
        }

        $entrenamiento = $this->model->obtenerPorId($id);
        require __DIR__ . '/../views/entrenador/entrenamientos-edit.php';
    }

    // ============================
    // ACTUALIZAR
    // ============================
    public function update() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SESSION['rol'] !== 'entrenador') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $data = [
            'idEntrenamiento' => $_POST['idEntrenamiento'],
            'nombreRutina'    => trim($_POST['nombreRutina'] ?? ''),
            'descripcionEje'  => trim($_POST['descripcionEje'] ?? ''),
            'dificultad'      => $_POST['dificultad'] ?? 'Media',
            'videoURL'        => trim($_POST['videoURL'] ?? '')
        ];

        $this->model->actualizar($data);

        header("Location: index.php?controller=entrenamientos&action=index");
        exit;
    }

    // ============================
    // ELIMINAR
    // ============================
    public function delete() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SESSION['rol'] !== 'entrenador') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->eliminar($id);
        }

        header("Location: index.php?controller=entrenamientos&action=index");
        exit;
    }

    // ============================
    // VISTA PÚBLICA (HOME, SIN LOGIN)
    // ============================
    public function public() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $buscar = $_GET['buscar'] ?? '';
        $entrenamientos = $this->model->obtenerPublicos($buscar);

        require __DIR__ . '/../views/entrenamientos-public.php';
    }

    // ============================
    // VISTA PÚBLICA (CLIENTE LOGUEADO)
    // ============================
    public function publicList() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $buscar = $_GET['buscar'] ?? '';
        $entrenamientos = $this->model->obtenerPublicos($buscar);

        if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'cliente') {
            require __DIR__ . '/../views/cliente/entrenamientos-cliente.php';
        } else {
            require __DIR__ . '/../views/entrenamientos-public.php';
        }
    }

}
