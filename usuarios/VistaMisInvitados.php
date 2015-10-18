<?
include_once('classUsuario.php');
class VistaMisInvitados{
	
	private $usuario;
	private $usuario2;
	private $user;
	
	public function __construct(){
		$this->usuario=new classUsuario();
		$this->usuario2=new classUsuario();		
		$this->user=$_POST['usuario'];
	}
	public function paginar(){
		
		$vista=$_POST['vista'];if($vista=='')$vista=$_GET['vista'];
		$porusuario=$_POST['porusuario'];if($porusuario=='')$porusuario=$_GET['porusuario'];
		$RegistrosAMostrar=10;
		
		if(isset($_GET['pag'])){
			$RegistrosAEmpezar=($_GET['pag']-1)*$RegistrosAMostrar;
			$PagAct=$_GET['pag'];
		
		}else{
			$RegistrosAEmpezar=0;
			$PagAct=1;	
		}
		/*AQUI SE DETERMINA SI SE VA A REVISAR UN USUARIO O NO*/		
		$openFrom=$_POST['openFrom'];
		if(!isset($openFrom))$openFrom=$_GET['openFrom'];
		if($_POST['openFrom']=='' && $_GET['openFrom']==''){			
			$titulo="Mis Invitados";			
		}
		else{
			$vista=$vista."/".$openFrom;
			$titulo="Certificar Usuarios";
			$head="<td>Revisar</td>";			
		}
		
		$lista=$this->usuario->paginarMisInvitados($RegistrosAEmpezar,$RegistrosAMostrar,$vista);
		
		$registros=$this->usuario2->selectMisInvitados($vista);
		$NroRegistros=count($registros);
		$PagAnt=$PagAct-1;
		$PagSig=$PagAct+1;
		$PagUlt=$NroRegistros/$RegistrosAMostrar;
				
		$Res=$NroRegistros%$RegistrosAMostrar;	
		if($Res>0) $PagUlt=floor($PagUlt)+1;
		
		$html="<div id='result'>
				<h1>$titulo ($NroRegistros)</h1><br>
				<table width='85%' align='center'>	
					<tr class='tablahead'>
						<td>Nº</td>
						<td>Nombre</td>
						<td>Ap.Pat.</td>
						<td>Ap.Mat.</td>		
						<td>Celular</td>		
						<td>Direccion</td>		
						<td>Deposito</td>
						$head
					</tr>";
		if(count($lista)>0){
			for($i=0;$i<count($lista);$i++){
				
				if($openFrom=='revisar'){				
					$conten="<td align='center'><a href='javascript:void()' onclick=\"openRevisarUsuario('".$lista[$i]['usuario']."')\"><img src='images/buscar.png' width='20' height='auto'/></a></td>";
				}
				$user=$this->usuario->returnUsuario($lista[$i]['addedby']);
				if($PagAct==1)$n=$i+$PagAct;
				else $n=((($PagAct-1)*$RegistrosAMostrar)+1)+$i;
				$imgen = file_get_contents("../images/depositos/".$lista[$i]['depositoImg']);  //dato_importante.jpg es el nombres de la foto (puede ir la ruta de ubicacion  "images/story/dato_importante.jpg")
				$img_base64 = chunk_split(base64_encode($imgen )); //Codifica la imagen en base 64
				$html.="<tr class='tablaconten' id='id_".$i."' onmousemove=\"cambiar(this.id,'#E7E7E7');\" onmouseout=\"cambiar(this.id,'#FAFAFA')\">
							<td align='center'>".($n)."</td>
							<td>".$lista[$i]['nombre']."</td>
							<td>".$lista[$i]['appaterno']."</td>
							<td>".$lista[$i]['apmaterno']."</td>		
							<td>".$lista[$i]['telefonocel']."</td>		
							<td>".$lista[$i]['direccion']."</td>		
							<td><a href=\"data:image/jpeg;base64,$img_base64\" target='_blank'>Ver</a></td>
							$conten
						</tr>";
			}
			
			$html.="<tr class='tablaconten'>
						<td colspan='11' align='center'>
							<font>
								<a href='javascript: void();' onclick=\"pagina(1,'VistaMisInvitados','".$vista."','".$openFrom."')\">PRIMERO</a>";
								if ($PagAct>1){$html.="<a href='javascript: void();' onclick=\"pagina('".$PagAnt."','VistaMisInvitados','".$vista."','".$openFrom."')\"> ANTERIOR </a>";}
								$html.="<i> Pagina ".$PagAct."/".$PagUlt." </i>";
								if ($PagAct<$PagUlt){$html.="<a href='javascript: void();' onclick=\"pagina('".$PagSig."','VistaMisInvitados','".$vista."','".$openFrom."')\">SIGUIENTE </a>";}
								$html.="<a href='javascript: void();' onclick=\"pagina('".$PagUlt."','VistaMisInvitados','".$vista."','".$openFrom."')\">ULTIMO</a>
							</font>
						</td>
					</tr>";
			
		}
		else{
			$html.="<tr class='tablaconten'>
						<td colspan='8'><h2>Ningun usuario en lista</h2></td>
					</tr>";	
		}
		echo $html;
	}	
}
$vmi=new VistaMisInvitados();
$vmi->paginar();