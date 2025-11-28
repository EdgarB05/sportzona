<?php
require_once __DIR__ . '/../../public/libraries/fpdf/fpdf.php';
require_once __DIR__ . '/../models/ReportesModel.php';
require_once __DIR__ . '/../../public/libraries/phplot/phplot.php';

class ReportesGraficosController
{
    private $model;

    public function __construct($connection)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $this->model = new ReportesModel($connection);
    }

    // Vista del menú de reportes gráficos
    public function index()
    {
        include "app/views/administrador/reportesGraficos.php";
    }

    // Acción principal que genera las imágenes y el PDF
    public function generar(){
        $generos    = $this->model->obtenerClientesGenero();
        $membresias = $this->model->obtenerMembresiasResumen();

        $imgPastel = "public/media/graphs/pastel.png";
        $imgBarras = "public/media/graphs/barras.png";

        $this->crearGraficaPastel($generos, $imgPastel);
        $this->crearGraficaBarras($membresias, $imgBarras);

        // Mini gráfica para dashboard
        $imgMini = "public/media/graphs/pastel-mini.png";
        $this->crearGraficaPastelMini($generos, $imgMini);


        $pdf = new FPDF();
        $pdf->AddPage();

        // ---------- TÍTULO GENERAL ----------
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, utf8_decode("Reportes Gráficos - Sport Zona"), 0, 1, "C");
        $pdf->Ln(5);

        // ========== PÁGINA 1: PASTEL ==========
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, utf8_decode("Distribución de clientes por género"), 0, 1);

        // obtenemos la posición Y actual y dejamos un pequeño espacio
        $y = $pdf->GetY() + 5;   // prueba con 5–8 para ajustar el espacio
        $pdf->Image($imgPastel, 25, $y, 160);

        // --------- NUEVA PÁGINA ----------
        $pdf->AddPage();

        // ========== PÁGINA 2: BARRAS ==========
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, utf8_decode("Membresías por tipo y estado"), 0, 1);

        $y = $pdf->GetY() + 5;
        $pdf->Image($imgBarras, 15, $y, 180);

        $pdf->Output("I", "Reportes-Graficos.pdf");
    }

    public function graficas()
    {
        $this->generar();
    }

    // ======================================================
    //  GRÁFICA DE PASTEL: CLIENTES POR GÉNERO
    // ======================================================
    private function crearGraficaPastel(array $data, string $path): void
    {

        $plotData = [];
        foreach ($data as $row) {
            $plotData[] = array($row['genero'], (int)$row['total']);
        }

        $plot = new PHPlot(600, 450);
        $plot->SetImageBorderType('plain');

        $plot->SetPlotAreaPixels(50, 80, 550, 420);
        
        $plot->SetPlotType('pie');
        $plot->SetDataType('text-data-single');
        $plot->SetDataValues($plotData);

        $plot->SetTitle(utf8_decode('Distribución de clientes por género'));

        $plot->SetDataColors([
            [255, 99, 132],   
            [54, 162, 235],   
            [255, 206, 86],   
            [75, 192, 192],   
        ]);

        $plot->SetLegend(array_column($plotData, 0));

        $plot->SetFileFormat('png');
        $plot->SetIsInline(true);
        $plot->SetOutputFile($path);
        $plot->DrawGraph();
    }

    // ======================================================
    //  GRÁFICA DE BARRAS: MEMBRESÍAS POR TIPO Y ESTADO
    // ======================================================
    private function crearGraficaBarras(array $data, string $path): void
    {
        $tipos   = [];
        $estados = [];
        $map     = [];

        foreach ($data as $row) {
            $tipo   = $row['tipo'];

            $estado = ucfirst(strtolower($row['estado']));
            $total  = (int)$row['total'];

            if (!in_array($tipo, $tipos, true)) {
                $tipos[] = $tipo;
            }
            if (!in_array($estado, $estados, true)) {
                $estados[] = $estado;
            }
            if (!isset($map[$tipo])) $map[$tipo] = [];
            $map[$tipo][$estado] = $total;
        }

        $plotData = [];
        foreach ($tipos as $tipo) {
            $row = [$tipo];
            foreach ($estados as $estado) {
                $row[] = isset($map[$tipo][$estado]) ? $map[$tipo][$estado] : 0;
            }
            $plotData[] = $row;
        }

        $plot = new PHPlot(700, 450);
        $plot->SetImageBorderType('plain');
        $plot->SetPlotType('bars');
        $plot->SetDataType('text-data');
        $plot->SetDataValues($plotData);
        $plot->SetTitle(utf8_decode("Membresías por tipo y estado"));

        $plot->SetDataColors(array(
            array(75, 192, 192),   
            array(255, 159, 64),   
            array(153, 102, 255),  
        ));

        $plot->SetXTickLabelPos('none');
        $plot->SetXTickPos('none');

        $plot->SetLegend($estados);

        $plot->SetFileFormat('png');
        $plot->SetIsInline(true);
        $plot->SetOutputFile($path);
        $plot->DrawGraph();
    }

    private function crearGraficaPastelMini(array $data, string $path): void{

        $plotData = [];
        foreach ($data as $row) {
            $plotData[] = array($row['genero'], (int)$row['total']);
        }

        $plot = new PHPlot(200, 200);
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

        $plot->SetLabelScalePosition(0); 
        $plot->SetLegend(array_column($plotData, 0));

        $plot->SetFileFormat('png');
        $plot->SetIsInline(true);
        $plot->SetOutputFile($path);
        $plot->DrawGraph();
    }

}
