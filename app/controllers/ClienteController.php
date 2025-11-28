<?php
require_once __DIR__ . '/../models/MembresiaModel.php';

class ClienteController {

    private $db;
    private $membresiaModel;
    
    public function __construct($connection) {
        if (!isset($_SESSION)) session_start();
        $this->db = $connection;
        $this->membresiaModel = new MembresiaModel($connection);
    }

    public function index() {

        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'cliente') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $expiraPronto = false;
        $diasRestantes = null;

        $membresia = $this->membresiaModel->obtenerMembresiaUsuario($_SESSION['id']);

        if ($membresia) {
            $hoy = new DateTime();
            $vence = new DateTime($membresia['fechaFin']);
            
            $diff = $hoy->diff($vence);

            $diasRestantes = $diff->days;
            $esFuturo = ($diff->invert === 0);

            $expiraPronto = ($esFuturo && $diasRestantes <= 3);

        }

        require_once __DIR__ . '/../models/AvisoModel.php';
        $avisoModel = new AvisoModel($this->db);
        $avisosDestacados = $avisoModel->obtenerAvisosPublicadosCliente();

        require_once __DIR__ . '/../models/PromocionModel.php';
        $promoModel = new PromocionModel($this->db);
        $promosVigentes = $promoModel->obtenerPromocionesVigentesCliente();


        require __DIR__ . '/../views/cliente/dashboard.php';
    }

    public function membresia() {

        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'cliente') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $idUsuario = $_SESSION['id'];
        $membresia = $this->membresiaModel->obtenerMembresiaUsuario($idUsuario);

        include "app/views/cliente/membresia-cliente.php";
    }

    public function horarios() {

        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'cliente') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        include "app/views/cliente/horarios-cliente.php";
    }

}
