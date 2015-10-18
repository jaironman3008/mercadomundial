<?php 
require_once('jpgraph-3.5.0b1/src/jpgraph.php');
require_once('jpgraph-3.5.0b1/src/jpgraph_line.php');
include_once('Analisis.php');
$objetoanalisis=new Analisis();
$anio=$_GET['anio'];if($anio=='')$anio=date('Y');
for($i=0;$i<12;$i++)
	$dat[]= $objetoanalisis->incrementoDeVentas($anio,$i);
$lbl=array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
	$datos = $dat;	
	$grafico = new Graph(500, 300, "auto");
	$grafico->SetScale("textlin");
	$grafico->title->Set("Año ".$anio);
	$grafico->xaxis->title->Set("");
	$grafico->xaxis->SetTickLabels($lbl);
	$grafico->yaxis->title->Set("");

	$lineplot = new LinePlot($datos);
	$lineplot->SetColor("green");
	$lineplot->SetWeight(2);
	$grafico->Add($lineplot);
	$lineplot->value->Show();
	$grafico->Stroke();