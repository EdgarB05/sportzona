<?php
class HomeController {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
    }

    public function index() {
        $ruta = "public/media/GaleriaResultados/";
        $imagenes = [];

        if (is_dir($ruta)) {
            $archivos = scandir($ruta);

            foreach ($archivos as $archivo) {
                if (preg_match('/\.(jpg|jpeg|png|webp)$/i', $archivo)) {
                    $imagenes[] = $ruta . $archivo;
                }
            }
        }

        require "app/views/home.php";
    }


    public function planes() {
        include_once "app/views/planes.php";
    }

    public function horarios() {
        include_once "app/views/horarios.php";
    }

    public function planAlimentacionInfo() {
        include_once "app/views/plan-alimentacion-info.php";
    }

    public function ejerciciosInfo() {
        include_once "app/views/ejercicios-info.php";
    }

}
?>
