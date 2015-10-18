<?
include_once('Banner.php');
include_once('ValidarForm.php');
class VistaBanner{
	private $vista;
	private $filtro;
	private $banner;
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
	private $validarForm;
	
	public function __construct(){
	
		$this->vista=$_POST['vista'];		
		$this->banner=new Banner();	
		$this->banner2=new Banner();		
		$this->pag=$_GET['pag'];
		$this->registrosAMostrar=3;
		$this->validarForm=new ValidarForm();
		
	}
	
	public function paginar(){
		$requerido=$this->validarForm->requerido();
		if(!isset($this->vista))$this->vista=$_GET['vista'];
		if(isset($this->pag)){
			$this->registrosAEmpezar=($this->pag-1)*$this->registrosAMostrar;
			$this->pagAct=$this->pag;		
		}else{
			$this->registrosAEmpezar=0;
			$this->pagAct=1;	
		}
		$this->lista=$this->banner->getBanners($this->registrosAEmpezar, $this->registrosAMostrar);
		$this->nroRegistros=count($this->banner2->getCountBanners());
		$this->pagAnt=$this->pagAct-1;
		$this->pagSig=$this->pagAct+1;
		$this->pagUlt=$this->nroRegistros/$this->registrosAMostrar;
		$this->res=$this->nroRegistros%$this->registrosAMostrar;
		if($this->res>0) $this->pagUlt=floor($this->pagUlt)+1;
		$tabla='';
		$tabla.="		
		<div id='result'>
		<form id='FrmBanner' enctype='multipart/form-data' class='formulario'>		
		<table align='center'>
			<tr class='tablahead'>
				<td colspan='2'>Nuevo Banner</td>
			</tr>
			<tr class='tablaconten'>
				<td colspan='2'><input type='file' name='archivo' id='imagen' $requerido/></td>
			</tr>
			<tr class='tablaconten'>
				<td>Titulo</td>
				<td><input type='text' $requerido name='titulo'></td>
				<input type='hidden' name='opcion' value='guardarBanner'>
			</tr>
			<tr class='tablaconten'>
				<td colspan='2' align='center'><input type='submit' value='Guardar' /></td>
			</tr>
		</table><br>";
		$tabla.="<table align='center'>
				<tr class='tablahead'>
					<td colspan='3'>Banners (".$this->nroRegistros.")</td>
				</tr>
				<tr class='tablahead'>
					<td>Imagen</td>
					<td>Titulo</td>
					<td>Ver</td>
				</tr>";		
		if(count($this->lista)>0){			
			for($i=0;$i<count($this->lista);$i++){				
			$ver=$this->lista[$i]['ver'];
				if($ver=='si')$checked='checked';
				else $checked='';
				$tabla.="<tr align='center' class='tablaconten' id='id_".$i."' onmousemove='cambiar(this.id,'#C5E847');' onmouseout='cambiar(this.id,'#98FB98')'>
							<td width='150' align='center'><img width='140' height='auto' src='images/banner/tooltips/".$this->lista[$i]['img']."'/></td>
							<td width='150'>".$this->lista[$i]['title']."</td>
							<td width='50'><input type='checkbox' class='check' $checked value='".$this->lista[$i]['idbanner']."' onclick='marcarDesmarcar(this.value,\"$ver\")'/></td>";
			}
				
		$tabla.="<tr class='tablaconten'>
					<td colspan='3' align='center'>
						<font class='hora'>
							<a href='javascript: void();' onclick=\"pagina(1,'VistaBanner')\">PRIMERO</a>";
							if($this->pagAct>1){$tabla.="<a href='javascript: void();' onclick=\"pagina('".$this->pagAnt."','VistaBanner')\"> ANTERIOR </a>";}
							$tabla.="<i> Pagina ".$this->pagAct."/".$this->pagUlt." </i>";
							if($this->pagAct<$this->pagUlt){$tabla.="<a href='javascript: void();' onclick=\"pagina('".$this->pagSig."','VistaBanner')\">SIGUIENTE </a>";}
							$tabla.="<a href='javascript: void();' onclick=\"pagina('".$this->pagUlt."','VistaBanner')\">ULTIMO</a>
						</font>
					</td>
				</tr>";
		}				
		else{
			$tabla.="<tr class='tablaconten'>
						<td colspan='2'><h2>No existen Banners!!</h2></td>
					</tr>";			
			$tabla.="</table>";					
		}
		$tabla.="</form></div>Actualiza la Pagina para ver los cambios";
		echo $tabla;
	}
}
$pe=new VistaBanner();
$pe->paginar();