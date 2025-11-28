<?php

require_once __DIR__ . '/../../public/libraries/phplot/phplot.php';

class AdminHomeController
{
    private $db;

    public function __construct($connection){

        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $this->db = $connection;
    }

    public function index()
    {
        // TOTAL USUARIOS
        $usuarios = $this->db->query("SELECT COUNT(*) AS total FROM usuarios")->fetch_assoc()['total'];

        // AVISOS PUBLICADOS
        $avisos = $this->db->query("SELECT COUNT(*) AS total FROM avisos WHERE estado='publicado'")->fetch_assoc()['total'];

        // PROMOCIONES ACTIVAS
        $promos = $this->db->query("SELECT COUNT(*) AS total FROM promocion WHERE estadoAct='activo'")->fetch_assoc()['total'];

        // ======================
        // GENERAR MINI GRÁFICA
        // ======================
        $generos = $this->db->query("SELECT genero, COUNT(*) AS total FROM usuarios GROUP BY genero")
                            ->fetch_all(MYSQLI_ASSOC);

        $plotData = [];
        foreach ($generos as $g) {
            $plotData[] = array($g['genero'], (int)$g['total']);
        }

        $imgMini = "public/media/graphs/pastel-mini.png";

        $dir = dirname(__DIR__ . '/../../' . $imgMini);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // Crear mini gráfica
        $plot = new PHPlot(240, 240);
        $plot->SetImageBorderType('plain');
        $plot->SetPlotType('pie');
        $plot->SetDataType('text-data-single');
        $plot->SetDataValues($plotData);
        $plot->SetTitle('');

        $plot->SetDataColors(array(
            array(255, 99, 132),
            array(54, 162, 235),
            array(255, 206, 86),
            array(75, 192, 192),
        ));

        $plot->SetLegend(array_column($plotData, 0));

        $plot->SetFileFormat('png');
        $plot->SetIsInline(true);
        $plot->SetOutputFile($imgMini);
        $plot->DrawGraph();

        // ======================
        // MINI-GRAFICA 2: AVISOS POR ESTADO
        // ======================
        $avisosData = $this->db->query("
            SELECT estado, COUNT(*) AS total 
            FROM avisos 
            GROUP BY estado
        ")->fetch_all(MYSQLI_ASSOC);

        $plotDataAvisos = [];
        foreach ($avisosData as $a) {
            $plotDataAvisos[] = array($a['estado'], (int)$a['total']);
        }

        $imgAvisos = "public/media/graphs/avisos-mini.png";

        $plot = new PHPlot(240, 240);
        $plot->SetImageBorderType('plain');
        $plot->SetPlotType('pie');
        $plot->SetDataType('text-data-single');
        $plot->SetDataValues($plotDataAvisos);

        $plot->SetDataColors(array(
            array(54, 162, 235), 
            array(255, 99, 132), 
        ));

        $plot->SetLegend(array_column($plotDataAvisos, 0));

        $plot->SetFileFormat('png');
        $plot->SetIsInline(true);
        $plot->SetOutputFile($imgAvisos);
        $plot->DrawGraph();

        // ======================
        // MINI-GRAFICA 3: PROMOCIONES ACTIVAS VS INACTIVAS
        // ======================
        $promosData = $this->db->query("
            SELECT estadoAct AS estado, COUNT(*) AS total
            FROM promocion
            GROUP BY estadoAct
        ")->fetch_all(MYSQLI_ASSOC);

        $plotDataPromos = [];
        foreach ($promosData as $p) {
            $plotDataPromos[] = array($p['estado'], (int)$p['total']);
        }

        $imgPromos = "public/media/graphs/promos-mini.png";

        $plot = new PHPlot(240, 240);
        $plot->SetImageBorderType('plain');
        $plot->SetPlotType('pie');
        $plot->SetDataType('text-data-single');
        $plot->SetDataValues($plotDataPromos);

        $plot->SetDataColors(array(
            array(75, 192, 192),  
            array(255, 159, 64),  
        ));

        $plot->SetLegend(array_column($plotDataPromos, 0));

        $plot->SetFileFormat('png');
        $plot->SetIsInline(true);
        $plot->SetOutputFile($imgPromos);
        $plot->DrawGraph();

        // ======================
        // MINI-GRAFICA 4: MEMBRESIAS POR ESTADO
        // ======================
        $membresiasData = $this->db->query("
            SELECT estado, COUNT(*) AS total
            FROM membresia
            GROUP BY estado
        ")->fetch_all(MYSQLI_ASSOC);

        $plotDataMembresias = [];
        foreach ($membresiasData as $m) {
            $plotDataMembresias[] = array($m['estado'], (int)$m['total']);
        }

        $imgMembresias = "public/media/graphs/membresias-mini.png";

        $plot = new PHPlot(240, 240);
        $plot->SetImageBorderType('plain');
        $plot->SetPlotType('pie');
        $plot->SetDataType('text-data-single');
        $plot->SetDataValues($plotDataMembresias);

        $plot->SetDataColors(array(
            array(153, 102, 255),  
            array(255, 206, 86),   
        ));

        $plot->SetLegend(array_column($plotDataMembresias, 0));

        $plot->SetFileFormat('png');
        $plot->SetIsInline(true);
        $plot->SetOutputFile($imgMembresias);
        $plot->DrawGraph();



        include "app/views/administrador/dashboard.php";


    }
}
