<?php
 require_once ('jpgraph-3.5.0b1/src/jpgraph.php');
 require_once ('jpgraph-3.5.0b1/src/jpgraph_bar.php');

 $nombre=$_GET["nom"];
 $horas=$_GET["hrs"];

// Creamos el grafico

$datos=array($horas);
$labels=array($nombre);

$grafico = new Graph(500, 400, 'auto');
$grafico->SetScale("textint");
$grafico->title->Set("Ejemplo de Grafica");
$grafico->xaxis->title->Set("Trabajadores");
$grafico->xaxis->SetTickLabels($labels);
$grafico->yaxis->title->Set("Horas Trabajadas");
$barplot1 =new BarPlot($datos);
// Un gradiente Horizontal de morados
$barplot1->SetFillGradient("#BE81F7", "#E3CEF6", GRAD_HOR);
// 30 pixeles de ancho para cada barra
$barplot1->SetWidth(30);
$grafico->Add($barplot1);
$grafico->Stroke();
?>