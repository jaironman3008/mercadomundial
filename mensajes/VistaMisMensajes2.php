<?
include_once('MensajeDominio.php');

class VistaMisMensajes{

	private $mensajeDominio;
	private $mensajeDominio2;
	private $user;
	private $registrosAMostrar;
	private $registrosAEmpezar;
	private $pagAct;
	private $pagAnt;
	private $pagSig;
	private $pagUlt;
	private $lista;
	private $registros;
	private $nroRegistros;
	private $res;
	private $pag;
	
	public function __construct(){
	
		$this->user=$_POST['usuario'];
		$this->mensajeDominio=new MensajeDominio();			
		$this->mensajeDominio2=new MensajeDominio();			
		$this->pag=$_GET['pag'];
		$this->registrosAMostrar=3;	
		
	}
	
	public function paginar(){
		
		if(isset($this->pag)){
			$this->registrosAEmpezar=($this->pag-1)*$this->registrosAMostrar;
			$this->pagAct=$this->pag;		
		}
		else{
			$this->registrosAEmpezar=0;
			$this->pagAct=1;	
		}
		$this->lista=$this->mensajeDominio->paginarusuarios($this->registrosAEmpezar,$this->registrosAMostrar,$this->user);
		$this->nroRegistros=count($this->usuario2->selectusuarios($this->user));
		$this->pagAnt=$this->pagAct-1;
		$this->pagSig=$this->pagAct+1;
		$this->pagUlt=$this->nroRegistros/$this->registrosAMostrar;
		$this->res=$this->nroRegistros%$this->registrosAMostrar;
		if($this->res>0) $this->pagUlt=floor($this->pagUlt)+1;		
			
		$tabla="<div id='result'>
				<h1>Usuarios del Sistema</h1><br>
				<table width='95%' align='center' >
				<tr class='tablahead'>
					<td>Nº</td>
					<td>Nombre</td>
					<td>Ap.Pat.</td>
					<td>Ap.Mat.</td>		
					<td>C.I.</td>		
					<td>Usuario</td>
					<td>Tel.Cel.</td>		
					<td>Rol</td>
					<td>Padre</td>
					<td>Editar</td>
				</tr>";
		
		if(count($this->lista)>0){			
			for($i=0;$i<count($this->lista);$i++){
			$addedby=$this->usuario->returnUsuario($this->lista[$i]['addedby']);
				$tabla.="<tr class='tablaconten' id='id_".$i."' onmousemove=\"cambiar(this.id,'#E7E7E7');\" onmouseout=\"cambiar(this.id,'#FAFAFA')\">		
							<td>".($i+1)."</td>
							<td>".$this->lista[$i]['nombre']."</td>
							<td>".$this->lista[$i]['appaterno']."</td>
							<td>".$this->lista[$i]['apmaterno']."</td>
							<td>".$this->lista[$i]['ci']."</td>
							<td>".$this->lista[$i]['usuario']."</td>
							<td>".$this->lista[$i]['telefonocel']."</td>
							<td>".$this->lista[$i]['rol']."</td>
							<td>".$addedby[$i]['usuario']."</td>                                                         
							<td align='center'><a href='javascript:void(0)' onclick=\"openFrmEditarUsuario('".$this->lista[$i]['usuario']."')\"><img src='images/editar.png'/></a></td>
						</tr>";
							
													
			}
				
		$tabla.="<tr class='tablaconten'>
					<td colspan='11' align='center'>
						<font class='hora'>
							<a href='javascript: void();' onclick=\"pagina(1,'VistaUsuario','".$this->vista."')\">PRIMERO</a>";
							if ($this->pagAct>1){$tabla.="<a href='javascript: void();' onclick=\"pagina('".$this->pagAnt."','VistaUsuario','".$this->vista."')\"> ANTERIOR </a>";}
							$tabla.="<i> Pagina ".$this->pagAct."/".$this->pagUlt." </i>";
							if ($this->pagAct<$this->pagUlt){$tabla.="<a href='javascript: void();' onclick=\"pagina('".$this->pagSig."','VistaUsuario','".$this->vista."')\">SIGUIENTE </a>";}
							$tabla.="<a href='javascript: void();' onclick=\"pagina('".$this->pagUlt."','VistaUsuario','".$this->vista."')\">ULTIMO</a>
						</font>
					</td>
				</tr>";
		}				
		else{
			$tabla.="<tr class='tablaconten'>
						<td colspan='11'><h2>No existen usuarios</h2></td>
					</tr>";	
		
		$tabla.="</table></div>";
			
		}
		echo $tabla;
	}
}
$pe=new VistaUsuario();
$pe->paginar();