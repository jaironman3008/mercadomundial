<?php
include_once('Articulo.php');

class VistaArticulo{

	private $vista;
	private $rolUsuario;
	private $contador;
	private $filtro;
	private $articulo;
	private $articulo2;
	private $articulo3;
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
	
		$this->vista=isset($_POST['vista'])?$_POST['vista']:"";
		$this->rolUsuario=isset($_POST['rolUsuario'])?$_POST['rolUsuario']:"";
		$this->contador=isset($_POST['contadorDeVisitas'])?$_POST['contadorDeVisitas']:"";
		$this->articulo=new Articulo();	
		$this->articulo2=new Articulo();
		$this->articulo3=new Articulo();		
		$this->pag=isset($_GET['pag'])?$_GET['pag']:"";
		$this->registrosAMostrar=2;
		
	}
	
	public function paginar(){
		if($this->contador=='si')
		$this->articulo3->incrementarVisitaDeArticulo($this->vista);
		
		if(!isset($this->vista))$this->vista=$_GET['vista'];
		if(isset($this->pag)){
			$this->registrosAEmpezar=($this->pag)*$this->registrosAMostrar;//echo "<pre>";var_dump($this->pag,$this->registrosAEmpezar);exit;
			$this->pagAct=$this->pag;		
		}else{
			$this->registrosAEmpezar=0;
			$this->pagAct=1;	
		}
		$this->lista=$this->articulo->getArticulos($this->registrosAEmpezar, $this->registrosAMostrar,$this->vista);
		$this->nroRegistros=count($this->articulo2->getCountArticulos($this->vista));
		$this->pagAnt=$this->pagAct-1;
		$this->pagSig=$this->pagAct+1;
		$this->pagUlt=$this->nroRegistros/$this->registrosAMostrar;
		$this->res=$this->nroRegistros%$this->registrosAMostrar;
		if($this->res>0) $this->pagUlt=floor($this->pagUlt)+1;
		
		
		$tabla="";
		$tabla.="<table width='95%' align='center' id='result'>
				<tr class='tablahead'>
					<td colspan='3'><h1>".$this->vista."</h1>";
		if($this->vista!='ofertas' && $this->vista!='subastas' && $this->vista!='recienPublicados' && $this->rolUsuario=='usuario'){
			$tabla.="<a href='javascript:void(0)' onclick=\"openFrmNuevoArticulo('".$this->vista."')\"> Publicar en esta categoria</a>";
		}
		$tabla.="</td>
				</tr>";		
		
		if(count($this->lista)>0){			
			for($i=0;$i<count($this->lista);$i++){
				$this->usuario=$this->articulo->getUsuario($this->lista[$i]['idusuario']);
				$tabla.="<tr class='tablaconten' id='id_".$i."' onmousemove='cambiar(this.id,'#C5E847');' onmouseout='cambiar(this.id,'#98FB98')'>		
							<td align='center'><img width='140' height='auto' src='images/".$this->lista[$i]['categoria']."/".$this->lista[$i]['img']."'/></td>
							<td>
								<font>DESCRIPCION:</font>".$this->lista[$i]['descripcion']."<br>								
								";
							if($this->lista[$i]['subasta']>0){
								$tabla.="<h2>ESTE ARTICULO SE ESTA SUBASTANDO</h2>";
								$tabla.="<font>OFERTA MINIMA: </font>".$this->lista[$i]['subasta']." Bs.<br>";
								$tabla.="<font><a href='javascript:void(0)' id='linkOfertar'>OFERTAR</a></font><br>";
							}
							else{
								if($this->lista[$i]['oferta']>0){
									$tabla.="<font>ANTES: </font><s>".$this->lista[$i]['precio']."</s> Bs.<br>
									<font>AHORA: </font>".$this->lista[$i]['oferta']."<br>";
								}
								else{								
									$tabla.="<font>PRECIO: </font>".$this->lista[$i]['precio']." Bs.<br>";
								}
							}
								$tabla.="<font>ESTADO: </font>".$this->lista[$i]['estado']."<br>
								<font>PUBLICADO POR EL USUARIO: </font>".$this->usuario[0]['usuario']."<br>
								<font>FECHA DE PUBLICACIÓN: </font>".$this->lista[$i]['fechareg']." ".$this->lista[$i]['horareg']."<br>";
								if($this->rolUsuario=='usuario'){
									$tabla.="<font><a href='javascript:void(0)' id='va-send-msg' data-categoria='".$this->lista[$i]['categoria']."' data-id='".$this->lista[$i]['idarticulo']."'>Enviar mensaje</a><br></font>";
								}
								$tabla.="<!--<font><a href='#'>Este articulo no pertenece a esta categoria</a></font>-->
							</td>";
							
							if($this->lista[$i]['subasta']>0){
								$tabla.="<td>
									<font>5 Mejores Ofertas</font>
									</td>
								</tr>";
							}						
			}
				
		$tabla.="<tr class='tablaconten'>
					<td colspan='3' align='center'>
						<font>
							<a href='javascript: void(0);' onclick=\"pagina(1,'VistaArticulo','".$this->vista."')\">PRIMERO</a>";
							if ($this->pagAct>1){$tabla.="<a href='javascript: void(0);' onclick=\"pagina('".$this->pagAnt."','VistaArticulo','".$this->vista."')\"> ANTERIOR </a>";}
							$tabla.="<i> Pagina ".$this->pagAct."/".$this->pagUlt." </i>";
							if ($this->pagAct<$this->pagUlt){$tabla.="<a href='javascript: void(0);' onclick=\"pagina('".$this->pagSig."','VistaArticulo','".$this->vista."')\">SIGUIENTE </a>";}
							$tabla.="<a href='javascript: void(0);' onclick=\"pagina('".$this->pagUlt."','VistaArticulo','".$this->vista."')\">ULTIMO</a>
						</font>
					</td>
				</tr>";
		}				
		else{
			$tabla.="<tr class='tablaconten'>
						<td colspan='2'><h2>No existen articulos en esta categoria</h2></td>
					</tr>";	
		
		$tabla.="</table>";
			
		}
		echo $tabla;
	}
}
$pe=new VistaArticulo();
$pe->paginar();