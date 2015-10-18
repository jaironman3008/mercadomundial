<?php // content="text/plain; charset=utf-8"
// $Id: horizbarex4.php,v 1.4 2002/11/17 23:59:27 aditus Exp $
require_once('jpgraph-3.5.0b1/src/jpgraph.php');
require_once('jpgraph-3.5.0b1/src/jpgraph_bar.php');
include_once('classAnalisis.php');

$anio=$_GET['anio'];if(!isset($anio))$anio=date('Y');
$objetoanalisis=new classAnalisis();
$dat=$objetoanalisis->topclientes($anio);

for($i=0;$i<count($dat);$i++)
$datay[]=$dat[$i]['comprado'];

for($i=0;$i<count($dat);$i++)
$lbl[]=$dat[$i]['nombre']."\nC.I.: ".$dat[$i]['ci'];
 
// Size of graph
$width=400;
$height=400;
 
// Set the basic parameters of the graph
$graph = new Graph($width,$height);
$graph->SetScale('textlin');
 
$top = 60;
$bottom = 20;
$left = 90;
$right = 30;
$graph->Set90AndMargin($left,$right,$top,$bottom);
 
// Nice shadow
$graph->SetShadow();
 
// Setup labels

$graph->xaxis->SetTickLabels($lbl);
//$graph->yaxis->SetTickLabels($datay);
 
// Label align for X-axis
$graph->xaxis->SetLabelAlign('right','center','right');
 
// Label align for Y-axis
$graph->yaxis->SetLabelAlign('center','bottom');
$graph->yaxis->SetLabelAngle(60); 
// Titles
$graph->title->Set('Año '.$anio);
 
// Create a bar pot
$bplot = new BarPlot($datay);
$bplot->SetFillColor('orange');
$bplot->SetWidth(0.5);
$bplot->SetYMin(1990);
 
$graph->Add($bplot); 
$bplot->value->Show();
$graph->Stroke();
?>