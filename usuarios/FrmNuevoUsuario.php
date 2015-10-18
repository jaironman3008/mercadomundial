<?
include_once('../presentacion/ValidarForm.php');
include_once('UsuarioDominio.php');
include_once('../articulos/ArticuloDominio.php');
include_once('../contratos/ContratoDominio.php');

class FrmNuevoUsuario{
	
	private $validarForm;
	private $opcion;
	private $curUser;
	private $articuloDominio;
	private $usuarioDominio;
	private $contratoDominio;
	
	public function __construct($sw=''){
		$this->validarForm=new ValidarForm();
		$this->opcion=$sw;
		$this->curUser=$_POST['curUser'];
		$this->articuloDominio=new ArticuloDominio();
		$this->usuarioDominio=new UsuarioDominio();
		$this->contratoDominio=new ContratoDominio();
	}
	
	public function imprimirForm(){
		$texto=$this->validarForm->texto();
		$requerido=$this->validarForm->requerido();
		$docIdentidad=$this->validarForm->docIdentidad();
		$password=$this->validarForm->contrasenia();
		$cuentaB=$this->validarForm->cuentaBancaria();
		$email=$this->validarForm->email('si');//recibe si, si es obligatorio y no si no es
		$form="
			<h1>Nuevo Usuario</h1>											
			<form id='frmNuevoUsuario' enctype='multipart/form-data'>
				<center>
				<p><input type='checkbox' name='aceptoTerminos' value='si'>Acepto los terminos y condiciones de uso. <a href='javascript: void()' id='verTerminos'>Ver los terminos</a></p>
					<table width='550'>
						<tr class='tablahead'>
							<td colspan='4'><font>Datos Basicos</font></td>
						</tr>
						<tr class='tablaconten'>
							<td><font>Nombres(*): </font></td>		
							<td><input name='nombres' $texto /></td>
							<input type='hidden' value='".$this->curUser."' name='curUser'/>
							<input type='hidden' value='insertUsuario' name='opcion'/>
							<td><font>Dirección(*): </font></td>		
							<td rowspan='2'><textarea name='direccion' cols='15' rows='2' $requerido></textarea></td>
						</tr>
						<tr class='tablaconten'>
							<td><font>Ap. Paterno(*): </font></td>		
							<td><input name='appaterno' $texto/></td>				
							<td><span class='maxlength'></span></td>
						</tr>
						<tr class='tablaconten'>
							<td><font>Ap. Materno: </font></td>		
							<td><input name='apmaterno' type='text' placeholder='Solo Texto' title='Este campo solo admite texo' pattern='|^[a-zA-Z ñÑáéíóúüç]*$|' /></td>
							<td><font>Tel. cel.(*): </font></td>		
							<td><input name='telefonocel' ".$this->validarForm->telefono('celular')." /></td>
						</tr>
						<tr class='tablaconten'>
							<td><font>Nº Cuenta(*): </font></td>		
							<td><input name='numcuenta' $cuentaB /></td>							
							<td><font>Telef fij.: </font></td>		
							<td><input name='telefonofij' ".$this->validarForm->telefono('fijo')." /></td>
						</tr>
						<tr class='tablaconten'>
							<td><font>C.I.(*): </font></td>		
							<td><input name='ci' $docIdentidad /></td>
							<td colspan='2'><div id='verificaCi'></div></td>							
						</tr>
						<tr>
							<td><font>Expedido en(*)</font></td>
							<td>".self::selectDepartamento()."</td>
							<td><font>E-mail(*)</font></td>
							<td><input name='email' $email/></td>
						</tr>
						<tr class='tablahead'>
							<td colspan='4'><font>Datos para acceder al Sistema</font></td>
						</tr>
						<tr class='tablaconten'>
							<td><font>Usuario(*): </font></td>		
							<td><input name='usuario' type='text' $requerido/></td>
							<td colspan='2'><div id='verificausuario'></div></td>
						</tr>
						<tr class='tablaconten'>
							<td><font>Contraseña(*): </font></td>		
							<td><input name='password' $password/></td>
							<td colspan='2'><div id='verificalenghtpass'></div></td>
						</tr>
						<tr class='tablaconten'>
							<td><font>Confir contraseña(*): </font></td>		
							<td><input name='cpassword' $password/></td>
							<td colspan='2'><div id='verificapass'></div></td>
						</tr>";						
						if($_SESSION['rolusuario']=='superadmin'){
							$form.="<tr class='tablaconten'>
								<td><font>Rol(*): </font></td>		
								<td>
									<select name='rol' $requerido>
										<option>
										<option value='usuario'>Usuario
										<option value='admin'>Administrador
										<option value='superadmin'>SuperAdmin
									</select>
								</td>
								<td colspan='2'></td>
							</tr>";
						}
						$form.="
								<tr class='tablaconten'>
									<td colspan='4'>
										<h2>Cargar Constancias de depositos!!</h2>
										<u><b>Requisitos</b></u><br>
											<b>Dimensiones: </b>960x360 pixeles(recomendado).<br>
											<b>Tamaño: </b>No mayor a 500KB.<br>
											<b>Tipo de Imagen: </b>JPG, PNG o GIF.									
									<input type='file' name='archivo' $requerido/>				
									</td>
								</tr>
								<tr class='tablaconten'>
							<td colspan='4' align='center'><input type='Submit' value='Guardar' /><input type='button' id='cancelarFrmNuevoUsuario' value='Cancelar' /></td>
						</tr>
					</table>
				</center>
			</form>
			<div id='error'></div>
			<div id='texto'  class='ventana' style='display:none' title='Terminos y Condiciones de Uso'>
			".html_entity_decode($this->contratoDominio->getContrato())."
			</div>
			";
			$curStock=$this->articuloDominio->getCountMisArticulos($this->curUser);
			$curInvited=$this->usuarioDominio->selectMisInvitados($this->curUser);
			//AKI ESTOY ESCOGIENDO A LOS ARTICULO ACEPTADOS
			$curStockAceptado=0;
			for($i=0;$i<count($curStock);$i++){
				if($curStock[0]['revisado']=='aceptado')
					$curStockAceptado=$curStockAceptado+1;
			}
			//AKI SELECCIONO LOS INVITADOS QUE HAN SIDO ACEPTADOS
			$curInvitedAceptado=0;
			for($i=0;$i<count($curInvited);$i++){
				if($curInvited[0]['revisado']=='aceptado')
					$curInvitedAceptado=$curInvitedAceptado+1;
			}
			
			if($this->curUser!='eliseo'){
				
				if($curStockAceptado==0)
					echo $form;
				else 
					echo$html="<br><br><br><br><h1>Debes registra almenos un articulo para comenzar a inscribir usuarios</h1>";			
			}
			else{
			echo $form;
			}
			
	}
	public  function selectDepartamento(){
		$lista=$this->usuarioDominio->departamentos();
		$html="<select required name='expedidoen'>
				<option></option>			";
		
			for($i=0;$i<count($lista);$i++){			
				$html.="<option value='".$lista[$i]['iddepartamento']."'>".$lista[$i]['departamento']."</option>";
			}		
		$html.="</select>";
		return $html;
	}
	public function main(){
		switch($this->opcion){
			case 'openFrmNuevoUsuario': self::imprimirForm();break;
			default: echo "<script type='text/javascript'>alert('Acceso no autorizado!!!');	window.history.back();
						</script>";
		}
	}
}
$fnu=new FrmNuevoUsuario($_POST['opcion']);
$fnu->main();