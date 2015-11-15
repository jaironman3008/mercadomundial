<?php
include_once('../presentacion/ValidarForm.php');
include_once('ArticuloDominio.php');

class FrmNuevoArticulo{
	
	private $categoria;
	private $validarForm;
	private $articuloDominio;
	private $curUser;
	
	public function __construct(){
		$this->categoria=isset($_POST['vista'])?$_POST['vista']:"";
		$this->curUser=isset($_POST['curUser'])?$_POST['curUser']:"";
		$this->validarForm=new validarForm();
		$this->articuloDominio=new ArticuloDominio();
	}

	public function imprimirForm(){
		$texto=$this->validarForm->texto();
		$requerido=$this->validarForm->requerido();
		$html="<h1>Nuevo Articulo</h1><br>";
		$html.="
			<form id='FrmNuevoArticulo' Method='POST'>
			<input type='hidden' name='opcion' value='insertArticulo'>
			<input type='hidden' name='usuario' value='".$this->curUser."'>
				<table align='center'>
					<tr class='tablahead'>
						<td colspan='2'>Ingrese los datos</td>
					</tr>
					<tr class='tablaconten'>
						<td>Descripcion<br><span class='maxlength'></span></td>
						<td><textarea cols='17' name='descripcion' rows='3' $texto></textarea></td>						
					</tr>
					<tr class='tablaconten'>
						<td>Precio</td>
						<td><input type='number' size='3' name='precio' ".$this->validarForm->numerico(1,'')." required />".self::selectMoneda()."</td>
					</tr>
					<tr class='tablaconten'>
						<td>Estado</td>
						<td>							
							<select name='estado' $requerido >
								<option></option>
								<option value='nuevo'>Nuevo</option>
								<option value='usado'>Usado</option>
							</select>
						</td>
					</tr>
					<tr class='tablaconten'>
						<td>Categoria</td>
						<td><input name='categoria' type='text' readonly value='".$this->categoria."'/></td>
					</tr>
					<tr class='tablaconten'>
						<td>Ubicacion</td>
						<td>
							".self::selectDepartamento()."
						</td>
					</tr>
					<tr class='tablaconten'>						
						<td colspan='2'>
							Seleccionar imagen<br><input type='file' name='archivo' id='imagen' />
						</td>
					</tr>
					<tr class='tablaconten'>
						<td colspan='2' align='center'>
							<input type='submit' value='Guardar'/>
							<input type='button' id='cancelarFrmNuevoArticulo' value='Cancelar'/>
						</td>
					</tr>
				</table>
			</form>
		";
		$curStock=$this->articuloDominio->getCountMisArticulos($this->curUser);
		/*if(count($curStock)<=20)
			echo $html;
		else
			echo$html="<br><br><br><br><h1>Has llegado a tu limite de 20 Articulos</h1>";*/
		echo $html;
	}

	public  function selectDepartamento(){
		$lista=$this->articuloDominio->departamentos();
		$html="<select required name='ubicacion'>
				<option></option>			";
		
			for($i=0;$i<count($lista);$i++){			
				$html.="<option value='".$lista[$i]['iddepartamento']."'>".$lista[$i]['departamento']."</option>";
			}		
		$html.="</select>";
		return $html;
	}
	public  function selectMoneda(){
		$lista=$this->articuloDominio->getMonedas();
		$html="<select required name='moneda'>
				<option></option>			";
		
			for($i=0;$i<count($lista);$i++){			
				$html.="<option value='".$lista[$i]['idmoneda']."'>".$lista[$i]['abrev']."</option>";
			}		
		$html.="</select>";
		return $html;
	}

}
$fna= new FrmNuevoArticulo();
$fna->imprimirForm();