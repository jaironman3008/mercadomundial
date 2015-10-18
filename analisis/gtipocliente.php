<?php
require_once('jpgraph-3.5.0b1/src/jpgraph.php');
require_once('jpgraph-3.5.0b1/src/jpgraph_bar.php');
include_once('classAnalisis.php');

$anio=$_GET['anio'];if(!isset($anio))$anio=date('Y');
$objetoanalisis=new classAnalisis();
$dat=$objetoanalisis->tipocliente($anio);

for($i=0;$i<count($dat);$i++)
$datos[]=$dat[$i]['comprado'];
for($i=0;$i<count($dat);$i++)
$labels[]=strtoupper($dat[$i]['tipo']);
// Creamos el grafico
$grafico = new Graph(400, 300, 'auto');
$grafico->SetScale("textlin");
$grafico->title->Set("Año ".$anio);
$grafico->xaxis->title->Set("");
$grafico->xaxis->SetTickLabels($labels);
$grafico->yaxis->title->Set("");

$barplot1 =new BarPlot($datos);
$barplot1->SetWidth(30); // 30 pixeles de ancho para cada barra

$grafico->Add($barplot1);
$barplot1->value->Show();
$grafico->Stroke();

?>