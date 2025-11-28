<?php
require_once __DIR__ . '/../../libraries/phplot/phplot.php';
require_once __DIR__ . '/../../../app/config/db_connection.php';

// Obtener datos
$sql = "SELECT genero, COUNT(*) AS total FROM usuarios GROUP BY genero";
$result = $connection->query($sql)->fetch_all(MYSQLI_ASSOC);

$data = [];
foreach ($result as $row) {
    $data[] = [$row['genero'], (int)$row['total']];
}

// Crear gráfica miniatura
$plot = new PHPlot(300, 200);
$plot->SetImageBorderType('plain');
$plot->SetPlotType('pie');
$plot->SetDataType('text-data-single');
$plot->SetDataValues($data);

$plot->SetDataColors([
    [255, 99, 132],   // rosa
    [54, 162, 235],   // azul
    [255, 206, 86],   // amarillo extra por si acaso
]);

$plot->SetTitle(utf8_decode("Género de Usuarios"));
$plot->SetShading(0);
$plot->SetFileFormat('png');
$plot->SetIsInline(true);

$plot->DrawGraph();
