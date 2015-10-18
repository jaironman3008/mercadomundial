<?
include_once('Analisis.php');

class Grafico{

	private $sw;
	private $anio;
	
	public function __construct(){
		$this->sw=$_POST['grafico'];
		$this->analisis=new Analisis();		
		$this->anio=$this->analisis->anios($this->sw);
	}
	public function pintarGrafico(){
		switch($this->sw){
			case 'incrementoUsuarios':self::incrementoUsuarios();break;
			case 'incrementoVentas':self::incrementoVentas();break;
			case 'incrementoVentasBs':self::incrementoVentasBs();break;
		}		
	}
	public function incrementoUsuarios(){
		
		$html="
			<p class='grafico'>".$this->sw."</p>
			<h1>Incremento de Usuarios</h1>
				<p>Examina el crecimiento de usuarios segun un año
				</p>				
				<table align='left'>
					<tr class='tablahead'>
						<td colspan='".count($this->anio)."'>Año</td>							
					</tr>
					<tr class='tablaconten'>	
				";						
					for($i=0;$i<count($this->anio);$i++){
					$html.="<td><a class='anios' href='javascript: void(0)'>".$this->anio[$i]['anio']."</a></td>";
					}						
		$html.="</tr>					
		</table><br><br><br>				
			<div id='grafica'><img src='analisis/gIncrementoUsuarios.php'/></div>
		";
		echo $html;
	}
	public function incrementoVentas(){
		$html="
			<p class='grafico'>".$this->sw."</p>
			<h1>Incremento de Ventas</h1>
				<p>Examina el crecimiento de Ventas segun el año
				</p>
				<table align='left'>
					<tr class='tablahead'>
						<td colspan='".count($this->anio)."'>Año</td>							
					</tr>
					<tr class='tablaconten'>
				";
				for($i=0;$i<count($this->anio);$i++){
					$html.="<td><a class='anios' href='javascript: void(0)'>".$this->anio[$i]['anio']."</a></td>";
					}
		$html.="</tr>					
		</table><br><br><br>				
			<div id='grafica'><img src='analisis/gIncrementoVentas.php'/></div>
		";
		echo$html;
	}
	public function incrementoVentasBs(){
		$html="
			<p class='grafico'>".$this->sw."</p>
			<h1>Incremento de Ventas segun el precio</h1>
				<p>Examina el crecimiento de Ventas teniendo en cuenta el precio del producto. Este valor es
					aproximado ya que el vendedor puede acordar un precio distinto al que se muestra en el sistema.
				</p>
				<table align='left'>
					<tr class='tablahead'>
						<td colspan='".count($this->anio)."'>Año</td>							
					</tr>
					<tr class='tablaconten'>
				";
				for($i=0;$i<count($this->anio);$i++){
					$html.="<td><a class='anios' href='javascript: void(0)'>".$this->anio[$i]['anio']."</a></td>";
					}
		$html.="</tr>					
		</table><br><br><br>				
			<div id='grafica'><img src='analisis/gIncrementoVentasBs.php'/></div>
		";
		echo$html;
	}
}
$g=new Grafico();
$g->pintarGrafico();