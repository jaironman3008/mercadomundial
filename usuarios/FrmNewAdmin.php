<?
include_once('../presentacion/ValidarForm.php');
include_once('UsuarioDominio.php');

class NewAdmin{

	private $validarForm;
	private $opcion;
	private $curUser;	
	private $usuarioDominio;
	
	public function __construct($sw=''){
	
		$this->validarForm=new ValidarForm();
		$this->opcion=$sw;
		$this->curUser=$_POST['curUser'];		
		$this->usuarioDominio=new UsuarioDominio();
		
	}
	public function frmNewUser(){
	
		$texto=$this->validarForm->texto();
		$requerido=$this->validarForm->requerido();
		$docIdentidad=$this->validarForm->docIdentidad();
		$password=$this->validarForm->contrasenia();
		$cuentaB=$this->validarForm->cuentaBancaria();
		$email=$this->validarForm->email('si');
	
		$form="
			<h1>Nuevo Administrador</h1><br>
			<form id='FrmNewAdmin'>
				<center>
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
						</tr>								
						<tr class='tablaconten'>
							<td colspan='4' align='center'><input type='Submit' value='Guardar' /><input type='button' id='cancelarFrmNewAdmin' value='Cancelar' /></td>
						</tr>
					</table>
				</center>
			</form>
		";
		echo $form;
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
	public function ejecutar(){
		switch($this->option){
			case'frmNewUser':self::frmNewUser();break;
		}
	}
}
$na=new NewAdmin();
$na->frmNewUser();