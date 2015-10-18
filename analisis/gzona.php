<?php 
require_once ('jpgraph-3.5.0b1/src/jpgraph.php');
require_once ('jpgraph-3.5.0b1/src/jpgraph_pie.php');
require_once ('jpgraph-3.5.0b1/src/jpgraph_pie3d.php');
include_once('classAnalisis.php');
// Some data
$anio=$_GET['anio'];if(!isset($anio))$anio=date('Y');
$objetoanalisis=new classAnalisis();
$dat=$objetoanalisis->topzonas($anio);

for($i=0;$i<count($dat);$i++)
$data[]=$dat[$i]['comprado'];

for($i=0;$i<count($dat);$i++)
$labels[]=$dat[$i]['zona'];

$graph = new PieGraph(400,300);
$graph->SetShadow();

$graph->title->Set("Año ".$anio);
 
$p1 = new PiePlot3D($data);
$p1->SetSize(0.3);
$p1->SetCenter(0.5);
$p1->SetLegends($labels);
 
$graph->Add($p1);
$graph->Stroke();
?>
