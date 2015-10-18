<?php 
include_once('../DBManager.php');
require_once('jpgraph-3.5.0b1/src/jpgraph.php');
require_once('jpgraph-3.5.0b1/src/jpgraph_line.php');
include_once('classAnalisis.php');


class classgrafico{

	public function __construct(){
		
	}
	public function graficofecha($gestion){
		if(Conectar::con()){
			//$gestion='2013';
			$objetoanalisis=new classAnalisis();
			$anio=$gestion;
			for($i=0;$i<12;$i++)
			$dat[]= $objetoanalisis->ventamensual($anio,$i);
			
			$datos = $dat;
			//$datos =array('1','4','3','3','5');
			$grafico = new Graph(400, 300, "auto");
			$grafico->SetScale("textlin");
			$grafico->title->Set("Resumen de ventas por gestion");
			$grafico->xaxis->title->Set("");
			$grafico->yaxis->title->Set("");
			// Un gradiente Horizontal de rojo a azul

			// 25 pixeles de ancho para cada barra
			$lineplot = new LinePlot($datos);
			$lineplot->SetColor("green");
			$lineplot->SetWeight(2);
			$grafico->Add($lineplot);
		 	return $grafico->Stroke();
						
			
		}		
	} 
}
/*$objetografico=new classgrafico();
$objetografico->graficofecha('2013');*/
//echo"<img src='$objetografico->graficofecha('2013')' width='400' height='360'/>";
?>