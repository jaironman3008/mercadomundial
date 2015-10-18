<?
require_once('PaqueteArticuloDominio.php');
class VistaPaquetesArticulo{
	
	private $paqueteArticuloDominio;
	
	public function __construct(){
		$this->paqueteArticuloDominio=new PaqueteArticuloDominio();
	}
	public function imprimirVista(){
		$listaPaquetes=$this->paqueteArticuloDominio->verPaquetes();
		$html="
			<h1>Paquetes de articulos (".count($listaPaquetes).")</h1><br>
		";
		$html.="
			<table align='center'>
				<tr class='tablahead'>
					<td>Nº</td><td width='300px'>Detalle</td><td colspan='2'>Fecha creacion</td>
				</tr>
			";
		for($i=0;$i<count($listaPaquetes);$i++){
			$id=$listaPaquetes[$i]['idpaquetearticulo'];
			$fecha=$listaPaquetes[$i]['fechacreacion'];
			$hora=$listaPaquetes[$i]['horacreacion'];
			$total=$listaPaquetes[$i]['total'];
			if($total>10)$mensaje="Paquete lleno";
			else $mensaje="$total articulo(s) en este paquete";
			
			$distribuir='';
			if(count($this->paqueteArticuloDominio->listAdminPack())>0)
				$distribuir="...
								<a href='javascript:void();' onclick=\"paqueteUsuarios($id,'distribuirPaqueteUsuarios')\">
									Distribuir
								</a>";
			$html.="<tr>
						<td>".($i+1)."</td><td>$mensaje...
											<div style='float:right' id='respuestaOpcion'>
												<a id='abrirPaqueteArticulos' href='javascript: void();' onclick=\"paqueteArticulos($id,'abrirPaqueteArticulos')\">
													<img src='images/paquete.png' title='Abrir' width=20px height='auto'/>
												</a>
												".$distribuir."
											</div>
										</td>
						<td>".self::fechaCreacion($fecha,$hora)."</td>
					</tr>";
			
		}
		$html.="</table><br>";
		
		echo $html;
	}
	public function fechaCreacion($fecha,$hora){
		if(date('d/m/Y',strtotime($fecha)==date('d/m/Y')))
			$fecha='Hoy';
		elseif(date('d/m/Y',strtotime($fecha))==date('d/m/Y', mktime(0,0,0,date('m'),date('d')-1,date('Y'))))
			$fecha='Ayer';
		else$fecha=date('d/m/Y',strtotime($fecha));
		
		$format=$fecha." a las ".$hora;
		return $format;
	}	
}
$vau=new VistaPaquetesArticulo();
$vau->imprimirVista();