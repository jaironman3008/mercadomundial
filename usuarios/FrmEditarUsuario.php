<?
include_once('classUsuario.php');
include_once('../presentacion/ValidarForm.php');
class VerUsuario{
		
	private $usuario;
	private $usuario2;
	private $usuario3;
	private $curUser;
	private $validarForm;
	private $userToEdit;
	private $vista;
	private $openFrom;	

    public function __construct(){
		$this->usuario=new classUsuario();
		$this->usuario2=new classUsuario();
		$this->usuario3=new classUsuario();
		$this->curUser=$_POST['curUser'];
		$this->userToEdit=$_POST['userToEdit'];	
		$this->vista=$_POST['vista'];
		$this->openFrom=$_POST['openFrom'];		
		$this->validarForm=new ValidarForm();
		
	}
	public function imprimirVista(){
		if($this->userToEdit=='')$this->userToEdit=$this->curUser;
		
		$lista2=$this->usuario2->selectusuarios($this->curUser);
		$lista=$this->usuario->selectusuarios($this->userToEdit);		                
		$texto=$this->validarForm->texto();				
		$requerido=$this->validarForm->requerido();		
		$password=$this->validarForm->contrasenia();
		
		$vOpenFrom=self::openFrom($lista[0]['depositoImg']);
		$titulo=$vOpenFrom['titulo'];
		$changePass=$vOpenFrom['changePass'];
		$readOnly=$vOpenFrom['readOnly'];
		$button=$vOpenFrom['button'];
		$direccionReadOnly=$vOpenFrom['direccionReadOnly'];
				
		$vOpenBy=self::openBy($lista[0]['rol'],$lista[0]['estado'],$lista[0]['addedby']);
		$editUser=$vOpenBy['editUser'];		
		$depositos=$vOpenBy['depositos'];
		
		$curPass="<table align='left'>
								<tr class='tablaconten'>
									<td height='24'><font>Password actual(*): </font></td>		
									<td><input $requerido id='oldPass' name='oldPass' type='password'/></td>
									<td><p id='ingresaPass'>Ingresa tu password para hacer modificaciones</p></td>				
								</tr>
					</table><br><br>";
		if($lista[0]['rol']!='superadmin' && $lista[0]['rol']!='admin'){
		$imgen = file_get_contents("../images/depositos/".$lista[0]['depositoImg']);  //dato_importante.jpg es el nombres de la foto (puede ir la ruta de ubicacion  "images/story/dato_importante.jpg")
				
		$img_base64 = chunk_split(base64_encode($imgen)); //Codifica la imagen en base 64
		}
		$html="<h1>$titulo</h1><br>
			<form id='FrmUpdateUser' enctype='multipart/form-data'>						
			$curPass			
			<table width='550' align='center'>
			<tr class='tablahead'>
				<td colspan='4'>Datos Basicos</td>
			</tr>
			<tr class='tablaconten'>
				<td><font>Nombres(*): </font></td>		
				<input name='usuario' type='hidden' value='".$lista[0]['usuario']."' />
				<input name='opcion' type='hidden' value='updateUsuario' />
				<input name='idUsuario' type='hidden' value='".$lista[0]['idusuario']."' />
				<td><input $readOnly name='nombres' value='".$lista[0]['nombre']."' $texto/></td>
				<td><font>Dirección(*): </font></td>		
				<td rowspan='2'><textarea $direccionReadOnly name='direccion' cols='15' rows='2' $requerido>".$lista[0]['direccion']."</textarea></td>
			</tr>
			<tr class='tablaconten'>
				<td><font>Ap. Paterno(*): </font></td>		
				<td><input $readOnly name='appaterno' value='".$lista[0]['appaterno']."' $texto/></td>				
				<td><span class='maxlength'></span></td>
			</tr>
			<tr class='tablaconten'>
				<td><font>Ap. Materno(*): </font></td>		
				<td><input $readOnly name='apmaterno' value='".$lista[0]['apmaterno']."' $texto/></td>
				<td><font>Telef. cel.: </font></td>		
				<td><input $readOnly name='telefonocel' value='".$lista[0]['telefonocel']."' ".$this->validarForm->telefono('celular')."/></td>
			</tr>
			<tr class='tablaconten'>
				<td><font>C.I.(*): </font></td>		
				<td><input $readOnly name='ci' type='text' value='".$lista[0]['ci']."' $requerido/></td>
				<td><font>Telef fij.: </font></td>		
				<td><input $readOnly name='telefonofij' value='".$lista[0]['telefonofijo']."' ".$this->validarForm->telefono('fijo')."/></td>
			</tr>
			<tr class='tablaconten'>
				<td><font>Nº Cuenta(*): </font></td>		
				<td><input readonly name='numcuenta' type='text' value='".$lista[0]['numcuenta']."' $requerido/></td>
				<td colspan='2'><a href=\"data:image/jpeg;base64,$img_base64\" target='_blank'>Ver Deposito</a></td>
			</tr>	
			$changePass
			$editUser
			<tr class='tablaconten'>
				<td colspan='4' align='center'>$button</td>
			</tr>
		</table>
		</form>
		";
		
		echo $html.$depositos;
	}
	public function openFrom($depositoImg){/*****ESTA FUNCION EVALUA DESDE DONDE FUE ABIERTO EL FRMEDITARUSUARIO*/
		
		switch($this->openFrom){
			case'miPerfil'://abre el usuario desde la opcion Mi perfil
				$titulo='Mi Perfil';			
				$changePass="<tr class='tablaconten'>
								<td height='24'><font>Nuevo Pass: </font></td>		
								<td><input name='newPass' type='password'/></td>
								<td colspan='2'><div id='ingresaNuevoPass'></div></td>
							</tr>
							<tr class='tablaconten'>
								<td height='24'><font>Confirmar Pass: </font></td>		
								<td><input name='confirNewPass' type='password'/></td>
								<td colspan='2'><p id='confirmaNuevoPass'></p></td>
							</tr>";
				$button="<input type='submit' value='Actualizar'/><input type='button' id='cancelarFrmEditarUsuario' value='Cancelar'/>";
				$readOnly='';
				
				$vOpenFrom['titulo']=$titulo;
				$vOpenFrom['readOnly']=$readOnly;
				$vOpenFrom['changePass']=$changePass;
				$vOpenFrom['button']=$button;
				return $vOpenFrom;
				break;				
			case'revisarUsuario'://abre el usuario desde la opcion certificar usuario
				$imgen = file_get_contents("../images/depositos/$depositoImg");  //dato_importante.jpg es el nombres de la foto (puede ir la ruta de ubicacion  "images/story/dato_importante.jpg")
				$img_base64 = chunk_split(base64_encode($imgen )); //Codifica la imagen en base 64
				$titulo='Datos de '.$this->userToEdit;
				$readOnly='readonly';
				$direccionReadOnly='readonly';
				$button="<input id='aceptar' type='button' value='Aceptar'/>
						<input id='rechazar' type='button' value='Rechazar'/>
						<input id='cancelarFrmRevisarUsuario' type='button' value='Cancelar'/>
						<!--<input id='pdf' type='button' value='Pdf'/>-->
						<a href=\"data:image/jpeg;base64,$img_base64\" target='_blank'>Ver Deposito</a>";						
				$vOpenFrom['titulo']=$titulo;			
				$vOpenFrom['readOnly']=$readOnly;
				$vOpenFrom['direccionReadOnly']=$direccionReadOnly;
				$vOpenFrom['button']=$button;
				return $vOpenFrom;
				break;
			case'allUsers': //abre el usuario desde la lista general de usuarios
				$titulo='Datos de '.$this->userToEdit;
				$button="<input type='submit' value='Actualizar'/><input type='button' id='cancelarFrmEdit' value='Cancelar'/>";
				$readOnly='readonly';
				$direccionReadOnly='readonly';
				$vOpenFrom['titulo']=$titulo;
				$vOpenFrom['button']=$button;
				$vOpenFrom['readOnly']=$readOnly;
				$vOpenFrom['direccionReadOnly']=$direccionReadOnly;
				return $vOpenFrom;
				break;
		}		
	}
	public function tablaUsuario($addedby){
		
		//$userSpecial[0]='ELISEO Villca Luna';
		$userSpecial[0]='Ruth Villca Luna';
		$userSpecial[1]='Abigail Cordero Nina';
		$userSpecial[2]='Ivith Nancy nina';
		$userSpecial[3]='Javier Jair Cussy Saucedo';		
				
		//$cuenta[0]='301-50692419-3-80';
		$cuenta[0]='10000016802048';
		$cuenta[1]='10000017251179';
		$cuenta[2]='10000015760081';
		$cuenta[3]='10000010208135';
		
		/*
		This table is same to BeneficiosPorUsuario with a difference:
		$curUser to be parent of user on revision. This way we'll know 
		the count numbers to should be deposit.
		*/
		$parent=$this->usuario->returnUsuario($addedby);
		$curUser=$this->usuario->selectusuarios($parent[0]['usuario']);
		
		$tabla="<table align='center' width='35%'>";		
			$tabla.="<tr class='tablahead'>
					<td colspan='2'>Numeros de cuenta</td>
				</tr>";
		$hijo=$curUser[0]['addedby'];	
		//if($hijo!=$curUser[0]['idusuario']){
		if($curUser[0]['usuario']!='eliseosuper'){
		//SI UN USUARIO OBSERVA LA TABLA
			$tabla.="				
				<tr class='tablahead'>
					<td rowspan='2'>1</td>
					<td>".$curUser[0]['numcuenta']."</td>
				</tr>
				<tr class='tablaconten'>				
					<td align='center'><b>".$curUser[0]['nombre']." ".$curUser[0]['appaterno']." ".$curUser[0]['apmaterno']."</b></td>
				</tr>
			";
			$desde=2;
		}else $desde=1;
			
			for($i=$desde;$i<6;$i++){
				
				$this->usuario2=new classUsuario();
				$padre=$this->usuario2->returnUsuario($hijo);//OBTENGO EL ANFITRION
				$user=$this->usuario2->returnUsuario($padre[0]['idusuario']);//OBTENGO AL USUARIO
				if($padre[0]['usuario']=='eliseosuper'){
					for($j=0;$j<(6-$i);$j++){
						$tabla.="
							<tr class='tablahead'>
								<td rowspan='2'>".($j+$i)."</td>
								<td>".$cuenta[$j]."</td>
							</tr>
							<tr class='tablaconten'>
								<td align='center'><b>".$userSpecial[$j]."</b></td>
							</tr>
						";
					}
					break;
				}
				else{
					$tabla.="<tr class='tablahead'>
								<td rowspan='2'>".$i."</td>
								<td>".$user[0]['numcuenta']."</td>
							</tr>
							<tr class='tablaconten'>				
								<td align='center'><b>".$user[0]['nombre']." ".$user[0]['appaterno']." ".$user[0]['apmaterno']."</b></td>
							</tr>";
					if($padre[0]['addedby']==$hijo)
					break;
					else
					$hijo=$padre[0]['addedby'];
				}
				
			}
			$tabla.="
					<tr class='tablahead'>
						<td rowspan='2'>6</td>
						<td>10000016803517</td>
					</tr>
					<tr class='tablaconten'>				
						<td align='center'><b>Mercado Mundial</b></td>
					</tr>
			";
			
		$tabla.="</table>";
		return $tabla;
	}
	public function openBy($curRol, $curEstado,$addedby){//evalua quien abre el formulario para editar usuarios
		if($this->openFrom=='revisarUsuario')//los numeros de cuentas solo se muestran si se revisa desde certificaciones
		$depositos=self::tablaUsuario($addedby);
		switch($this->vista){
			case'superadmin':				
				
				if($curRol=='usuario')$rol='admin';else$rol='usuario';
				if($curEstado=='activo')$estado='inactivo';else$estado='activo';
				
				if($this->openFrom=='allUsers')
				$editUser="<!--<p id='ingresaPass'>OK!!!</p>
							<tr class='tablaconten'>
								<td><font>Rol</font></td>
												<td><select name='rol'>
														<option value='".$curRol."'>".$curRol."</option>
														<option value='$rol'>$rol</option>										
													</select>
												</td>
								<td colspan='2'></td>
							</tr>-->
							<tr class='tablaconten'>
								<td><font>Estado</font></td>
								<td>".self::estado($curEstado)."</td>
								<td colspan='2'></td>									
							</tr>";
				$vOpenBy['editUser']=$editUser;				
				$vOpenBy['depositos']=$depositos;
				return $vOpenBy;
				break;
			case'admin':
				$vOpenBy['depositos']=$depositos;
				return $vOpenBy;
				break;
		}
	}
	public function estado($estado){
		$estados=array('activo','inactivo');
		if($estado=='inactivo'){
			$html="inactivo";
		}
		else{
			$html="
				<select name='estado'>";
				$html.="<option value='$estado'>$estado</option>";
				for($i=0;$i<count($estados);$i++){
					if($estados[$i]!=$estado)
					$html.="<option value='$estados[$i]'>$estados[$i]</option>";
				}					
			$html.="
				</select>";
		}
		return $html;
	}
	function permisosParaEditar(){
		
	}
}
$vu=new VerUsuario();
$vu->imprimirVista();