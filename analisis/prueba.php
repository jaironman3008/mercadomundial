<?
//Este es mi codigo:
/*include("../sesion.php");
include("../bd.php");*/
require_once('jpgraph-3.5.0b1/src/jpgraph.php');
require_once('jpgraph-3.5.0b1/src/jpgraph_bar.php');
include_once('classAnalisis.php');
/*//$result = mysql_query("SELECT * FROM tabla", $bd); 
$anio=$_GET['anio'];if(!isset($anio))$anio=date('Y');
$objetoanalisis=new classAnalisis();
$dat=$objetoanalisis->tipocliente($anio);

$fecha = strftime("%d de $mes del %Y");

for($i=0;$i<count($dat);$i++)
$datos[]=$dat[$i]['comprado'];
for($i=0;$i<count($dat);$i++)
$labels[]=strtoupper($dat[$i]['tipo']);

$maximo=max(array_values($datos));
$total3=$maximo;
$graph = new Graph(400,300, "auto"); 
$graph->SetScale("textlin",0,$total3);

$graph->img->SetMargin(70, 50, 60, 130);
//$graph->SetBackgroundGradient($aFrom='white',$aTo='blue',$aGradType=2,$aStyle=BGRAD_MARGIN);
$graph->title->Set("Sexo\n");
$graph->title->SetFont(FF_ARIAL,FS_NORMAL,20, "center", "center");
$graph->xaxis->title->Set("Total registros\n$fecha");
$graph->title->SetMargin(25);
$graph->xaxis->SetTitlemargin(80);
$graph->yaxis->title->Set("Total" );
$graph->yaxis->SetTitlemargin(50);
// Setup font for axis
//$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,10);
//$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,10);

// Show 0 label on Y-axis (default is not to show)
$graph->yscale->ticks->SupressZeroLabel(false);
$graph->xaxis->SetTickLabels($labels); 
$graph->xaxis->SetLabelAngle(50);
$barplot =new BarPlot($datos);
$barplot->SetColor("orange");
$barplot->SetFillColor('blue');
$barplot->SetValuePos('center');
$barplot->value->Show();

$graph->Add($barplot);
$graph->Stroke();*/
// Se define el array de datos

$datosy=array(25,16,24,5,8,31);

// Creamos el grafico

$grafico = new Graph(500,250);

$grafico->SetScale('textlin');
// Ajustamos los margenes del grafico-----    (left,right,top,bottom)

$grafico->SetMargin(40,30,30,40);
// Creamos barras de datos a partir del array de datos
$bplot = new BarPlot($datosy);
// Configuramos color de las barras
$bplot->SetFillColor('#479CC9');
//Añadimos barra de datos al grafico
$grafico->Add($bplot);
// Queremos mostrar el valor numerico de la barra
$bplot->value->Show();
// Configuracion de los titulos
$grafico->title->Set('Mi primer grafico de barras');
$grafico->xaxis->title->Set('Titulo eje X');
$grafico->yaxis->title->Set('Titulo eje Y');

 

$grafico->title->SetFont(FF_FONT1,FS_BOLD);

$grafico->yaxis->title->SetFont(FF_FONT1,FS_BOLD);

$grafico->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

 

// Se muestra el grafico

$grafico->Stroke();