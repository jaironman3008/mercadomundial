<?
include_once('Articulo.php');

class MisVistaArticulo{

	private $vista;	
	private $filtro;
	private $articulo;
	private $articulo2;
	private $usuario;
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
	
		$this->vista=$_POST['vista'];		
		$this->articulo=new Articulo();	
		$this->articulo2=new Articulo();		
		$this->pag=$_GET['pag'];
		$this->registrosAMostrar=6;
		
	}
	
	public function paginar(){
		if(!isset($this->vista))$this->vista=$_GET['vista'];
		if(isset($this->pag)){
			$this->registrosAEmpezar=($this->pag-1)*$this->registrosAMostrar;
			$this->pagAct=$this->pag;		
		}else{
			$this->registrosAEmpezar=0;
			$this->pagAct=1;	
		}
		$id=$this->articulo->getId($this->vista);
		$openFrom=$_POST['openFrom'];/*********VARIABLE QUE DEFINE SI SE VA CARGA LA VISTA DE REVISION DE ARTICULOS*/
		if(!isset($openFrom))$openFrom=$_GET['openFrom'];
		if($_POST['openFrom']=='' && $_GET['openFrom']==''){			
			$idUser=$id[0]['idusuario'];
			$titulo="<h1>Mis Publicaciones</h1>";
			$accion="Editar";
			$usuario="";
			$img="editar";			
		}
		else{
			$titulo="<h1>Certificaciones</h1>";
			$idUser=$id[0]['idusuario']."/".$openFrom;
			$accion="Revisar";			
			$img="buscar";
			$usuario="<td>Usuario</td>";
		}
		
		$this->lista=$this->articulo->getMisArticulos($this->registrosAEmpezar, $this->registrosAMostrar,$idUser);
		$this->nroRegistros=count($this->articulo2->getCountMisArticulos($idUser));
		$this->pagAnt=$this->pagAct-1;
		$this->pagSig=$this->pagAct+1;
		$this->pagUlt=$this->nroRegistros/$this->registrosAMostrar;
		$this->res=$this->nroRegistros%$this->registrosAMostrar;
		if($this->res>0) $this->pagUlt=floor($this->pagUlt)+1;
				
		$tabla.="<div id='result'>
				$titulo<br>
				<table width='95%' align='center'>
				<tr class='tablahead'>
					<td>Imagen</td>
					<td>Descripcion</td>
					<td>Categoria</td>
					<td>Precio</td>
					<td>Oferta</td>
					<td>Estado</td>
					$usuario
					<td>$accion</td>
				</tr>
				";				
		
		
		if(count($this->lista)>0){
			
			for($i=0;$i<count($this->lista);$i++){
				if($openFrom==''){
					$onclick="onclick='openEditarMisArticulos(".$this->lista[$i]['idarticulo'].")'";				
					$usuariodata="";
				}

				else{
					$onclick="onclick='openRevisarArticulo(".$this->lista[$i]['idarticulo'].")'";
					$usuariodata="<td>".$this->lista[$i]['usuario']."</td>";		
				}
				$this->usuario=$this->articulo->getUsuario($this->lista[$i]['idusuario']);
					$tabla.="<tr class='tablaconten' id='id_".$i."' onmousemove='cambiar(this.id,'#C5E847');' onmouseout='cambiar(this.id,'#98FB98')'>		
								<td align='center'><img width='40' height='auto' src='images/".$this->lista[$i]['categoria']."/".$this->lista[$i]['img']."'/></td>
								<td>".$this->lista[$i]['descripcion']."</td>
								<td>".$this->lista[$i]['categoria']."</td>
								<td>".$this->lista[$i]['precio']."</td>
								<td>".$this->lista[$i]['oferta']."</td>
								<td>".$this->lista[$i]['estado']."</td>
								$usuariodata
								<td align='center'><a href='javascript:void()' $onclick ><img src='images/$img.png'/></a></td>
							</tr>";							
			}
			
			$tabla.="<tr class='tablaconten'>
					<td colspan='8' align='center'>
						<font class='hora'>
							<a href='javascript: void();' onclick=\"pagina(1,'VistaMisArticulo','".$this->vista."','".$openFrom."')\">PRIMERO</a>";
							if ($this->pagAct>1){$tabla.="<a href='javascript: void();' onclick=\"pagina('".$this->pagAnt."','VistaMisArticulo','".$this->vista."','".$openFrom."')\"> ANTERIOR </a>";}
							$tabla.="<i> Pagina ".$this->pagAct."/".$this->pagUlt." </i>";
							if ($this->pagAct<$this->pagUlt){$tabla.="<a href='javascript: void();' onclick=\"pagina('".$this->pagSig."','VistaMisArticulo','".$this->vista."','".$openFrom."')\">SIGUIENTE </a>";}
							$tabla.="<a href='javascript: void();' onclick=\"pagina('".$this->pagUlt."','VistaMisArticulo','".$this->vista."','".$openFrom."')\">ULTIMO</a>
						</font>
					</td>					
				</tr>";
		}				
		else{
			$tabla.="<tr class='tablaconten'>
						<td colspan='8'><h2>Ningun articulo en lista</h2></td>
					</tr>";	
		}
		if($_POST['openFrom']=='' && $_GET['openFrom']==''){
		$porcentaje=($this->nroRegistros*100)/20;
		/*$tabla.="</table><br>
				".$porcentaje."% (".$this->nroRegistros." articulos de 20)<br> <progress id='progress' value='".$this->nroRegistros."' max='20'/>
				</div>";*/
		}		
		
		echo $tabla;
	}
}
$pe=new MisVistaArticulo();
$pe->paginar();