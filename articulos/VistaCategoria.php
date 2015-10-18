<?
include_once('CategoriaDominio.php');
include_once('../presentacion/ValidarForm.php');

class VistaCategoria{

	private $vista;
	private $filtro;
	private $categoria;
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
		$this->categorias=new CategoriaDominio();	
		$this->categorias2=new CategoriaDominio();		
		$this->pag=$_GET['pag'];
		$this->registrosAMostrar=7;
		$this->validarForm=new ValidarForm();
		
	}
	
	public function paginar(){
		$requerido=$this->validarForm->requerido();
		
		if(isset($this->pag)){
			$this->registrosAEmpezar=($this->pag-1)*$this->registrosAMostrar;
			$this->pagAct=$this->pag;		
		}else{
			$this->registrosAEmpezar=0;
			$this->pagAct=1;	
		}
		$this->lista=$this->categorias->selectCategorias($this->registrosAEmpezar, $this->registrosAMostrar);//lista de categorias
		$this->nroRegistros=count($this->categorias2->selectCountCategorias());//total categorias
		$this->pagAnt=$this->pagAct-1;
		$this->pagSig=$this->pagAct+1;
		$this->pagUlt=$this->nroRegistros/$this->registrosAMostrar;
		$this->res=$this->nroRegistros%$this->registrosAMostrar;
		if($this->res>0) $this->pagUlt=floor($this->pagUlt)+1;
	
		$tabla="		
		<div id='result'>
		<h1>Categorias (".$this->nroRegistros.")</h1><br>
		<form id='FrmNuevaCategoria'>		
		<table>
				<tr class='tablahead'>
					<td>Nueva Categoria: </td>
					<td><input type='text' $requerido name='categoria'/><input type='submit' value='Agregar'/></td>					
				</tr>				
		</table><br>
		</form>";
		$tabla.="<table align='center'>
				<tr class='tablahead'>
					<td colspan='3'>Todas las Categorias</td>
				</tr>
				<tr class='tablahead'>
					<td>Nº</td>
					<td>Categoria</td>
					<td>Ver</td>
				</tr>";
		if(count($this->lista)>0){			
			for($i=0;$i<count($this->lista);$i++){				
				$ver=$this->lista[$i]['ver'];
				if($ver=='si')$checked='checked';
				else $checked='';
				
				if($this->pagAct==1)$n=$i+$this->pagAct;
				else $n=((($this->pagAct-1)*$this->registrosAMostrar)+1)+$i;
				$tabla.="<tr class='tablaconten' id='id_".$i."' onmousemove=\"cambiar(this.id,'#E7E7E7');\" onmouseout=\"cambiar(this.id,'#FAFAFA')\">
						<td align='center'>".$n."</td>
						<td>".$this->lista[$i]['categoria']."</td>
						<td align='center'><input type='checkbox' $checked onclick=\"actualizarCategoria()\" value='".$this->lista[$i]['idcategoria']."_".$this->lista[$i]['ver']."'/></td>
						<input type='hidden' value='".$this->lista[$i]['ver']."' name='ver'/> 
						</tr>";
			}
				
		$tabla.="<tr class='tablaconten'>
					<td colspan='3' align='center'>
						<font>
							<a href='javascript: void();' onclick=\"pagina(1,'VistaCategoria')\">PRIMERO</a>";
							if($this->pagAct>1){$tabla.="<a href='javascript: void();' onclick=\"pagina('".$this->pagAnt."','VistaCategoria')\"> ANTERIOR </a>";}
							$tabla.="<i> Pagina ".$this->pagAct."/".$this->pagUlt." </i>";
							if($this->pagAct<$this->pagUlt){$tabla.="<a href='javascript: void();' onclick=\"pagina('".$this->pagSig."','VistaCategoria')\">SIGUIENTE </a>";}
							$tabla.="<a href='javascript: void();' onclick=\"pagina('".$this->pagUlt."','VistaCategoria')\">ULTIMO</a>
						</font>
					</td>
				</tr>";
		}				
		else{
			$tabla.="<tr class='tablaconten'>
						<td colspan='2'><h2>No existen Categorias!!</h2></td>
					</tr>";			
			$tabla.="</table>";					
		}
		$tabla.="<div>Actualiza la Pagina para ver los cambios</div>";
		echo $tabla;
	}
}
$pe=new VistaCategoria();
$pe->paginar();