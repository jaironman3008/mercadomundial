<?
include_once('ArticuloDominio.php');
include_once('../presentacion/ValidarForm.php');

class FrmEditarArticulo{
	
	private $articuloDominio;
	private $idArticulo;
	private $validarForm;
	private $openFrom;
	
	public function __construct(){
	
		$this->articuloDominio=new ArticuloDominio();
		$this->idArticulo=$_POST['idArticulo'];
		$this->validarForm=new ValidarForm();
		$this->openFrom=$_POST['openFrom'];
	}
	
	public function imprimirForm(){
	
		$articulo=$this->articuloDominio->getArticuloFromId($this->idArticulo);
		$texto=$this->validarForm->texto();
		$requerido=$this->validarForm->requerido();
		
		$vOpenFrom=self::openFrom($articulo[0]['revisado']);
		$titulo=$vOpenFrom['titulo'];
		$readOnly=$vOpenFrom['readOnly'];
		$precioReadOnly=$vOpenFrom['precioReadOnly'];
		$button=$vOpenFrom['button'];
		$subirImagen=$vOpenFrom['subirImagen'];
		
		$estado=self::estado($articulo[0]['estado'],$articulo[0]['revisado']);
		
		$html="<h1>$titulo</h1><br>";
		$html.="<form id='FrmEditarArticulo' enctype='multipart/form-data' class='formulario'>				
				<table align='center'>
					<tr class='tablahead'>
						<td colspan='4'>Datos actuales</td>
					</tr>";

			$html.="<tr class='tablaconten'>
						<td  rowspan='2'>Descripcion<span class='maxlength'></span></td>
						<td  rowspan='2'><textarea $readOnly cols='17' name='descripcion' rows='3' $requerido>".$articulo[0]['descripcion']."</textarea></td>
						<td>Estado</td>
						<td>".$estado."</td>
					</tr>
					<tr class='tablaconten'>
						<td>Precio</td>
						<td><input $precioReadOnly name='precio' value='".$articulo[0]['precio']."' ".$this->validarForm->numerico(1,'')." required /></td>
						<input name='idArticulo' value='".$articulo[0]['idarticulo']."' type='hidden'/>
						<input name='opcion' value='actualizarArticulo' type='hidden'/>
					</tr>
					<tr class='tablaconten'>
						<td>Oferta</td>
						<td><input $readOnly name='oferta' value='".$articulo[0]['oferta']."' ".$this->validarForm->numerico(0,'')."/></td>						
						<td>Categoria</td>
						<td><input $readOnly id='categoria' name='categoria' value='".$articulo[0]['categoria']."' type='text' readonly value='".$this->categoria."' id='categoria'/></td>
					</tr>
					<!--
					<tr class='tablaconten'>
						<td>Subastar</td>
						<td><input name='subastar' value='".$articulo[0]['subasta']."' ".$this->validarForm->numerico(0,'')."/></td>												
						<td colspan='2'></td>
					</tr>-->
					<tr class='tablaconten'>
						<td align='center' colspan='4'><div class='showImage'><img src='images/".$articulo[0]['categoria']."/".$articulo[0]['img']."' width='200' height='auto'/></div></td>
					</tr>";
					if($articulo[0]['img']==''){
						$html.="$subirImagen";
					}
					if($estado!='vendido'){
						$html.="<tr class='tablaconten'>
							<td colspan='4' align='center'>$button</td>
						</tr>";
					}
				$html.="</table>";
		
		echo $html;
	}
	public function openFrom($revisado){
		switch($this->openFrom){
			case'revisarArticulo':
				$titulo='Certificar Articulo';
				$readOnly='readonly';
				$button="<input id='aceptar' type='button' value='Aceptar'/>
						<input id='rechazar' type='button' value='Rechazar'/>
						<input id='sugerencia' type='button' value='Sugerencia'/>
						<input id='cancelarFrmRevisarArticulo' type='button' value='Cancelar'/>";
						
				$vOpenFrom['titulo']=$titulo;			
				$vOpenFrom['readOnly']=$readOnly;
				$vOpenFrom['button']=$button;				
				return $vOpenFrom;break;
				
			default:
				if($revisado=='aceptado' || $revisado=='rechazado')$precioReadOnly="readonly='true'";
				
				$titulo='Editar Articulo';				
				$button="<input type='submit' value='Guardar'/><input type='button' id='cancelarfrmEditarArticulo' value='Cancelar'/>";
				$subirImagen="<tr class='tablaconten'>
							<td colspan='4'>Subir Imagen<input type='file' name='archivo' id='imagen' /></td>
						</tr>";
				
				$vOpenFrom['subirImagen']=$subirImagen;
				$vOpenFrom['titulo']=$titulo;	
				$vOpenFrom['precioReadOnly']=$precioReadOnly;	
				$vOpenFrom['button']=$button;
				return $vOpenFrom;break;						
		}
	}
	
	public function estado($estado,$revisado){
		
		switch($revisado){
			case'aceptado':
				$estados=array('nuevo','usado','vendido');
				if($estado=='vendido'){//si el articulo esta vendido no hay mas opciones
					$html="<select name='estado'>
							<option value='vendido'>vendido</option>
						</select>";
				}
				else{//si no esta vendido le queda la opcion de colocarlo como vendido
					$html="
						<select name='estado'>";
						$html.="<option value='".$estado."'>".$estado."</option>
								<option value='vendido'>vendido</option>";
						/*for($i=0;$i<count($estados);$i++){
							if($estados[$i]!=$estado)
							$html.="<option value='".$estados[$i]."'>".$estados[$i]."</option>";
						}		*/			
					$html.="</select>";
				}
				return $html;
				break;
			case'rechazado'://no existen opciones
				$html="<select name='estado'>
							<option value='".$estado."'>".$estado."</option>
						</select>";
				return $html;
				break;
			case'no':// tiene todas las opciones menos la de colocar como vendido
				$estados=array('nuevo','usado');
				$html="
					<select name='estado'>";
					$html.="<option value='".$estado."'>".$estado."</option>";
					for($i=0;$i<count($estados);$i++){
						if($estados[$i]!=$estado)
						$html.="<option value='$estados[$i]'>$estados[$i]</option>";
					}					
				$html.="</select>";
				return $html;
				break;				
		}	
	}
}
$fea= new FrmEditarArticulo();
$fea->imprimirForm();