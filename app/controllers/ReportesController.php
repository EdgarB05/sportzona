<?php
require_once __DIR__ . '/../../public/libraries/fpdf/fpdf.php';
require_once __DIR__ . '/../models/ReportesModel.php';

class ReportesController {

    private $model;

    public function __construct($connection) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $this->model = new ReportesModel($connection);
    }

    /* ===========================
       REPORTE PDF
       =========================== */
    public function generar() {
        $inicio = $_GET['inicio'] ?? date("Y-m-01");
        $fin    = $_GET['fin']    ?? date("Y-m-d");

        // Obtener datos
        $avisos       = $this->model->obtenerAvisosPorFecha($inicio, $fin);
        $generos      = $this->model->obtenerClientesGenero();
        $membresias   = $this->model->obtenerMembresiasResumen();
        $citas        = $this->model->obtenerCitas($inicio, $fin);

        $pdf = new FPDF();
        $pdf->AddPage();

        /* --- ENCABEZADO PRINCIPAL --- */
        $pdf->SetFillColor(50, 50, 50);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 12, utf8_decode("Reporte General ($inicio a $fin)"), 0, 1, 'C', true);

        $pdf->Ln(5);
        $pdf->SetTextColor(0, 0, 0);

        /* ====================================================
        SECCIÓN 1: AVISOS ENVIADOS (TABLA)
        ==================================================== */
        $pdf->SetFont('Arial','B',12);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(0, 10, "Avisos enviados", 0, 1, 'L');

        // Encabezado tabla
        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(180, 180, 180);
        $pdf->Cell(70, 8, "Titulo", 1, 0, 'C', true);
        $pdf->Cell(30, 8, "Estado", 1, 0, 'C', true);
        $pdf->Cell(50, 8, "Fecha envio", 1, 1, 'C', true);

        $pdf->SetFont('Arial','',10);

        if (!empty($avisos)) {
            foreach ($avisos as $a) {

                $titulo = utf8_decode($a['titulo'] ?? 'N/A');
                $estado = utf8_decode($a['estado'] ?? 'N/A');
                $fecha  = utf8_decode($a['fecha_envio'] ?? 'N/A');

                $pdf->Cell(70, 8, $titulo, 1);
                $pdf->Cell(30, 8, $estado, 1);
                $pdf->Cell(50, 8, $fecha, 1, 1);
            }
        } else {
            $pdf->Cell(150, 8, "No hubo avisos enviados.", 1, 1);
        }

        $pdf->Ln(5);


        /* ====================================================
        SECCIÓN 2: CLIENTES POR GÉNERO (TABLA)
        ==================================================== */
        $pdf->SetFont('Arial','B',12);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(0, 10, "Clientes por genero", 0, 1, 'L');

        // Encabezado
        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(180, 180, 180);
        $pdf->Cell(80, 8, "Genero", 1, 0, 'C', true);
        $pdf->Cell(30, 8, "Total", 1, 1, 'C', true);

        $pdf->SetFont('Arial','',10);

        foreach ($generos as $g) {
            $pdf->Cell(80, 8, utf8_decode($g['genero']), 1);
            $pdf->Cell(30, 8, utf8_decode($g['total']), 1, 1);
        }

        $pdf->Ln(5);


        /* ====================================================
        SECCIÓN 3: RESUMEN DE MEMBRESIAS
        ==================================================== */
        $pdf->SetFont('Arial','B',12);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(0, 10, "Resumen de Membresías", 0, 1, 'L');

        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(180, 180, 180);
        $pdf->Cell(70, 8, "Tipo", 1, 0, 'C', true);
        $pdf->Cell(40, 8, "Estado", 1, 0, 'C', true);
        $pdf->Cell(30, 8, "Total", 1, 1, 'C', true);

        $pdf->SetFont('Arial','',10);
        foreach ($membresias as $m) {
            $pdf->Cell(70, 8, utf8_decode($m['tipo']), 1);
            $pdf->Cell(40, 8, utf8_decode($m['estado']), 1);
            $pdf->Cell(30, 8, utf8_decode($m['total']), 1, 1);
        }

        $pdf->Ln(5);


        /* ====================================================
        SECCIÓN 4: CITAS PROGRAMADAS
        ==================================================== */
        $pdf->SetFont('Arial','B',12);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(0, 10, "Citas programadas", 0, 1, 'L');

        $pdf->SetFont('Arial','B',10);
        $pdf->SetFillColor(180, 180, 180);
        $pdf->Cell(30, 8, "Fecha", 1, 0, 'C', true);
        $pdf->Cell(25, 8, "Hora", 1, 0, 'C', true);
        $pdf->Cell(55, 8, "Cliente", 1, 0, 'C', true);
        $pdf->Cell(30, 8, "Estado", 1, 1, 'C', true);

        $pdf->SetFont('Arial','',10);

        if (!empty($citas)) {
            foreach ($citas as $c) {
                $pdf->Cell(30, 8, utf8_decode($c['fecha']), 1);
                $pdf->Cell(25, 8, utf8_decode($c['hora']), 1);
                $pdf->Cell(55, 8, utf8_decode($c['cliente']), 1);
                $pdf->Cell(30, 8, utf8_decode($c['estado']), 1, 1);
            }
        } else {
            $pdf->Cell(140, 8, "No hubo citas programadas.", 1, 1);
        }

        $pdf->Output("I", "Reporte-General.pdf");
    }


    public function index() {
        include "app/views/administrador/reportes.php";
    }
}
?>
