<?
include_once('MensajeDominio.php');
class VistaMisMensajes{
	
	private $mensajeDominio;
	private $mensajeDominio2;	
	private $mensajeDominio3;	
	
	public function __construct(){
		
		$this->mensajeDominio=new MensajeDominio();
		$this->mensajeDominio2=new MensajeDominio();
		$this->mensajeDominio3=new MensajeDominio();
	}
	public function paginar(){
		
		$tipo=$_POST['tipo'];if($tipo=='')$tipo=$_GET['tipo'];
		$vista=$_POST['vista'];if($vista=='')$vista=$_GET['vista'];		
		$RegistrosAMostrar=10;
		
		if(isset($_GET['pag'])){
			$RegistrosAEmpezar=($_GET['pag']-1)*$RegistrosAMostrar;
			$PagAct=$_GET['pag'];
		
		}
		elseif(isset($_POST['pag'])){
			$RegistrosAEmpezar=($_POST['pag']-1)*$RegistrosAMostrar;
			$PagAct=$_POST['pag'];
		}
		else{
			$RegistrosAEmpezar=0;
			$PagAct=1;	
		}
		
		$lista=$this->mensajeDominio->paginarMisMensajes($RegistrosAEmpezar,$RegistrosAMostrar,$vista,$tipo);		
		$NroRegistros=count($unRead=$this->mensajeDominio2->selectMisMensajes($vista,$tipo));
		$PagAnt=$PagAct-1;
		$PagSig=$PagAct+1;
		$PagUlt=$NroRegistros/$RegistrosAMostrar;
		
		$Res=$NroRegistros%$RegistrosAMostrar;	
		if($Res>0) $PagUlt=floor($PagUlt)+1;
		switch($tipo){			
				case 'recibidos':
					$direccion='De';
					$sinLeer=0;
					for($i=0;$i<count($unRead);$i++){/*mensajes sin leer*/
						
						if($unRead[$i]['estado']=='sin leer')
							$sinLeer=$sinLeer+1;
					}
					$total="($sinLeer/$NroRegistros)";
					break;
				case 'enviados':
					$direccion='Para';
					$total="($NroRegistros)";
					break;		
		}
		
		$html="<div id='result'>
				<h1>Mensajes $tipo $total</h1><br>
				<table width='85%' align='center'>	
					<tr class='tablahead'>
						<td>Nº</td>
						<td>$direccion</td>
						<td width='auto'>Asunto</td>						
						<td width='155px'>Fecha</td>						
					</tr>";
		for($i=0;$i<count($lista);$i++){
			switch($tipo){			
				case 'recibidos':
					$direccion='De';
					$idUsuario=$lista[$i]['idSendFrom'];
					if($lista[$i]['estado']=='sin leer'){
						$bgcolor="style='background-color: #E7E7E7'";
						$mouseOut="#E7E7E7";
						$imagen='sobre';
						$title='Marcar como leído';
						$href="href='javascript: void()'";
						$onclick="onclick=\"msgRead('".$lista[$i]['idmensaje']."','".$PagAct."','".$vista."')\"";
						$sobre="<a $href $onclick><img src='images/$imagen.png' title='$title' width='15px' height='auto'/></a>.::.";
					}
					else{
						$bgcolor='';
						$mouseOut="#FAFAFA";
						$imagen='sobreAbierto';
						$title='Leído';	
						$sobre="<a $href $onclick><img src='images/$imagen.png' title='$title' width='15px' height='auto'/></a>.::.";
					}
					break;
				case 'enviados':
					$direccion='Para';
					$idUsuario=$lista[$i]['idSendTo'];
					break;
			}
			$from=$this->mensajeDominio->getUsuarioFromId($idUsuario);					
						
			if($PagAct==1)$n=$i+$PagAct;
			else $n=((($PagAct-1)*$RegistrosAMostrar)+1)+$i;
			
			$html.="<tr $bgcolor class='tablaconten' id='id_".$i."' onmousemove=\"cambiar(this.id,'#E7E7E7');\" onmouseout=\"cambiar(this.id,'$mouseOut')\">
						<td align='center'>".$n."</td>
						<td>".self::evaluarRemitente($from[0]['rol'],$from[0]['usuario'])."</td>
						<td>".$lista[$i]['asunto']."...
							<div style='float:right'>
							<a href='javascript: void()' onclick=\"leerMensaje('".$lista[$i]['idmensaje']."','".$tipo."')\">Leer</a>...
							$sobre
							<a href='javascript: void()' onclick=\"borrarMensaje('".$lista[$i]['idmensaje']."','".$PagAct."','".$vista."','".$tipo."')\"><img src='images/eliminar.png' title='$title' width='15px' height='auto'/></a>
							</div>
						</td>							
						<td align='center'>".self::fecha($lista[$i]['fecha'])." a las ".$lista[$i]['hora']."</td>							
					</tr>";
			
		}
		if(count($lista)>0){
			$html.="<tr class='tablaconten'>
						<td colspan='12' align='center'>
							<font class='hora'>
								<a href='javascript: void();' onclick=\"pagina(1,'VistaMisMensajes','".$vista."','".$tipo."')\">PRIMERO</a>";
								if ($PagAct>1){$html.="<a href='javascript: void();' onclick=\"pagina('".$PagAnt."','VistaMisMensajes','".$vista."','".$tipo."')\"> ANTERIOR </a>";}
								$html.="<i>Pagina</i> <i id='pagAct'>".$PagAct."</i>/<i>".$PagUlt." </i>";
								if ($PagAct<$PagUlt){$html.="<a href='javascript: void();' onclick=\"pagina('".$PagSig."','VistaMisMensajes','".$vista."','".$tipo."')\">SIGUIENTE </a>";}
								$html.="<a href='javascript: void();' onclick=\"pagina('".$PagUlt."','VistaMisMensajes','".$vista."','".$tipo."')\">ULTIMO</a>
							</font>
						</td>
					</tr>";
		}
		echo $html;
	}
	public function fecha($fecha){
		if(date('d/m/Y',strtotime($fecha))==date('d/m/Y'))
			return $fecha='Hoy';
		elseif(date('d/m/Y',strtotime($fecha))==date('d/m/Y', mktime(0,0,0,date('m'),date('d')-1,date('Y'))))
			return $fecha='Ayer';
		else return$fecha=date('d/m/Y',strtotime($fecha));
	}
	public function evaluarRemitente($rol,$user){
		if($rol=='admin' || $rol=='superadmin'){			
			return 'Administracion';
		}
		else return $user;
	}
}
$vmm=new VistaMisMensajes();
$vmm->paginar();