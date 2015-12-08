<?php
include_once('Usuario.php');
include_once('PaqueteUsuarioDominio.php');
@include_once('../mensajes/MensajeDominio.php');

class UsuarioDominio{

	private $usuario;
	private $usuario2;
	private $usuario3;
	private $paqueteUsuarioDominio;
	private $mensajeDominio;
	private $mensaje;
	private $img;
	private $imgTemp;
	private $opcion;
	private $ruta;
	private $idUsuario;
	private $user;
	private $nombres;
	private $appaterno;
	private $apmaterno;
	private $ci;
	private $expedidoen;
	private $pass;
	private $oldPass;
	private $newPass;
	private $direccion;
	private $telefonocel;
	private $telefonofijo;
	private $email;
	private $numcuenta;
	private $rol;
	private $estado;
	private $curUser;
	private $respuestaRevision;
	private $idUsuarioRevisado;
	private $explicacion;
	
	public function __construct($sw=''){
	
		$this->usuario=new Usuario();
		$this->usuario2=new Usuario();
		$this->usuario3=new Usuario();
		$this->paqueteUsuarioDominio=new PaqueteUsuarioDominio();
		$this->mensajeDominio=new MensajeDominio();
		$this->mensaje=new Mensaje();
		$this->img=isset($_FILES['archivo']['name'])?$_FILES['archivo']['name']:"";
		$this->imgTemp=isset($_FILES['archivo']['tmp_name'])?$_FILES['archivo']['tmp_name']:"";
		$this->opcion=$sw;		
		$this->ruta='../images/depositos/';
		$this->idUsuario=isset($_POST['idUsuario'])?$_POST['idUsuario']:"";
		$this->user=isset($_POST['usuario'])?$_POST['usuario']:"";
		$this->nombres=isset($_POST['nombres'])?$_POST['nombres']:"";
		$this->appaterno=isset($_POST['appaterno'])?$_POST['appaterno']:"";
		$this->apmaterno=isset($_POST['apmaterno'])?$_POST['apmaterno']:"";
		$this->ci=isset($_POST['ci'])?$_POST['ci']:"";
		$this->expedidoen=isset($_POST['expedidoen'])?$_POST['expedidoen']:"";
		$this->pass=isset($_POST['password'])?$_POST['password']:"";
		$this->oldPass=isset($_POST['oldPass'])?$_POST['oldPass']:"";
		$this->newPass=isset($_POST['newPass'])?$_POST['newPass']:"";
		$this->direccion=isset($_POST['direccion'])?$_POST['direccion']:"";
		$this->telefonocel=isset($_POST['telefonocel'])?$_POST['telefonocel']:"";
		$this->telefonofijo=isset($_POST['telefonofij'])?$_POST['telefonofij']:"";
		$this->email=isset($_POST['email'])?$_POST['email']:"";
		$this->numcuenta=isset($_POST['numcuenta'])?$_POST['numcuenta']:"";
		$this->rol=isset($_POST['rol'])?$_POST['rol']:"";
		$this->estado=isset($_POST['estado'])?$_POST['estado']:"";
		$this->curUser=isset($_POST['curUser'])?$_POST['curUser']:"";
		$this->respuestaRevision=isset($_POST['respuestaRevision'])?$_POST['respuestaRevision']:"";
		$this->idUsuarioRevisado=isset($_POST['idUsuarioRevisado'])?$_POST['idUsuarioRevisado']:"";
		$this->explicacion=isset($_POST['explicacion'])?$_POST['explicacion']:"";
	}
	
	public function selectUsuario($dato){
		return $this->usuario->selectusuarios($dato);
	}
	
	public function insertUsuario($nom,$appat,$apmat,$ci,$expedidoen,$numcuenta,$dir,$user,$pass,$cel,$fij,$email,$rol,$img){
		
		if(!isset($rol))$rol='usuario';
		
		$curUser=$this->usuario->selectusuarios($this->curUser);
		$addedby=$curUser[0]['idusuario'];
		$mTipo = self::extension($img);
		if ((strtolower($mTipo) != 'jpg') && (strtolower($mTipo) != 'jpeg') && (strtolower($mTipo) != 'png') && (strtolower($mTipo) != 'gif'))
			echo"<br><br><br><h1>La extencion .$mTipo no esta validada por el sistema.Los archivos validados son jpg, png y gif!!</h1>";
		else{
			$size = filesize($this->imgTemp);
			if($size <= 512000){
				if(!is_dir($this->ruta))
				mkdir($this->ruta, 0777);
				$maxId=$this->usuario->maxid();
				$id=$maxId[0]['iduser']+1;
				if($img && move_uploaded_file($this->imgTemp,$this->ruta.$id."_".$img)){
					if($this->usuario->insertusuario($nom,$appat,$apmat,$ci,$expedidoen,$numcuenta,$dir,$user,$pass,$cel,$fij,$email,$rol,$addedby,$id."_".$img)==true){					
						sleep(2);
						$idUsuario=$this->usuario2->selectusuarios($user);//estoy buscando al usuario*/*/*/*/*/*/*/						
						$idPaqueteUsuario=$this->paqueteUsuarioDominio->obtenerPaqueteUsuario();
						if($this->paqueteUsuarioDominio->insertDetallePaqueteUsuarios($idPaqueteUsuario,$idUsuario[0]['idusuario'])==true){
							$mensaje="<p>Estimado usuario, su invitado pasara por un proceso de revision que tardará un maximo de
										24 horas, si se llega a encontrar irregularidades en los datos ingresados, su invitado no sera 
										dado de alta.<br> Atentamente<br>La Administracion</p>";
						}	
						echo"<h1>Usuario registrado exitosamente!!</h1><br>
							$mensaje";
					}
					else echo'<br><br><br><h1>No se pudo realizar el registro!!</h1>';
				}
				else echo'<br><br><br><h1>Ocurrio un error..Al cargar la imagen!!..intente de nuevo</h1>';
			}
  			else{
  				echo'<br><br><br><h1>La imagen no debe pesar mas de 512KB</h1>';
  			}
		}		
	}
	public function insertAdmin(){
		
		if($this->usuario->insertAdmin($this->nombres,$this->appaterno,$this->apmaterno,$this->ci,$this->expedidoen,$this->direccion,$this->user,$this->numcuenta,$this->pass,$this->telefonocel,$this->telefonofijo,$this->email)==true){
			echo"<h1>Administrador registrado exitosamente!!!</h1>";
		}
		else echo"<h1>Ocurrio un problema intente de nuevo!!!</h1>";
	}
	public function departamentos(){
		return $this->usuario->departamentos();
	}
	public function updateUsuario($nombres,$appaterno,$apmaterno,$ci,$expedidoen,$newPass,$direccion,$telefonocel,$telefonofijo,$email,$idUsuario,$rol,$estado){
		
		if($newPass=='')$newPass=$this->oldPass;
		$lista=self::selectUsuario($this->user);
		if($rol=='')$rol=$lista[0]['rol'];
		if($estado=='')$estado=$lista[0]['estado'];
		if($estado=='inactivo'){
			$mensaje1=self::desactivarUsuario($idUsuario);
			$mensaje2=self::desactivarArticulos($idUsuario);
		}
		if($this->usuario->updateusuario($nombres,$appaterno,$apmaterno,$ci,$expedidoen,$newPass,$direccion,$telefonocel,$telefonofijo,$email,$idUsuario,$lista[0]['depositoImg'],$rol,$estado)==true){
			echo"<br><br><br><h1>Datos actualizados exitosamente!!</h1><br><p>$mensaje1</p><p>$mensaje2</p>";
		}
		else echo'<br><br><br><h1>No se pudieron actualizar los datos del usuario!!</h1>';
		//echo"<script>alert('$nombres $appaterno $apmaterno $ci $newPass $direccion $telefonocel $telefonofijo $idUsuario ".$lista[0]['depositoImg']." $rol $estado')</script>";
		
	}
	public function respuestaRevisarUsuario(){		
		$sendFrom=$this->curUser;//usuario que hizo la revision
		$invitado=$this->usuario2->returnUsuario($this->idUsuarioRevisado);//buscando anfitrion
		$sendTo=$this->usuario->returnUsuario($invitado[0]['addedby']);//anfritrion
		$asunto="SOLICITUD DE NUEVO USUARIO";
		
		if($this->usuario->respuestaRevisarUsuario($this->respuestaRevision,$this->idUsuarioRevisado)==true){//SI SE MODIFICO AL INVITADO
			if($this->respuestaRevision=='aceptado'){//SI LA MODIFICACION FUE POSITIVA	
				$mensaje="Estimado usuario le informamos que su invitado(".$invitado[0]['usuario'].") ha sido dado de alta";
				if($this->mensaje->insertMensaje($sendFrom,$sendTo[0]['usuario'],$asunto,$mensaje)==true)//SI SE NOTIFICO AL ANFITRION
					$notificacion="<br><p>El anfitrion de este usuario ya ha sido notificado</p>";
				else$notificacion="<br><p>Ocurrio un error y no se pudo notificar al anfitrion</p>";//SI FALLO LA NOTIFICACION AL ANFITRION
				
				echo"<br><br><br><h1>El usuario ".$invitado[0]['usuario']." fue dado de alta Exitosamente!!</h1>".$notificacion;
				
			}
			else{//SI LA MODIFICACION FUE NEGATIVA
				$mensaje="Estimado usuario le informamos que su invitado(".$invitado[0]['usuario'].") ha sido rechazado.
				<br><b>EXPLICACION: </b>".$this->explicacion;
				if($this->mensaje->insertMensaje($sendFrom,$sendTo[0]['usuario'],$asunto,$mensaje)==true)
				$notificacion="<br><p>El anfitrion de este usuario ya ha sido notificado</p>";
				else$notificacion="<br><p>Ocurrio un error y no se pudo notificar al anfitrion</p>";	
					echo"<br><br><br><h1>La solicitud del usuario ".$invitado[0]['usuario']." ha sido rechazada!!</h1>".$notificacion;
			}
		}
		else//SI NO SE PUDO MODIFICAR AL INVITADO
			echo"<br><br><br><h1>Ocurrio un error..Intente de nuevo!!</h1>";
	}
	public function updateMensajeLeido(){
		if($this->usuario->updateMensajeLeido($this->user)==true)
		echo"<script>location.reload();</script>";
	}
	public function desactivarUsuario($idUsuario){
		return $this->usuario->desactivarUsuario($idUsuario);
	}
	public function desactivarArticulos($idUsuario){		
		return $this->usuario->desactivarArticulos($idUsuario);
	}
	public function selectMisInvitados($curUser){
		return $this->usuario->selectMisInvitados($curUser);
	}
	public function aceptarTerminosDeUso($usuario){
		if($this->usuario->aceptarTerminosDeUso($usuario)==true)
			echo"<script>alert('Felicidades!! ya puedes cambiar tu password en la opcion MI Perfil'); location.reload();</script>";
		else
			echo"<script>alert('Ocurrio un error por favor intenta de nuevo'); location.reload();</script>";
	}
	public function cuentaVencida($idUsuario){
		return $this->usuario->cuentaVencida($idUsuario);
	}
	public function mensajeLeido($idUsuario){
		return $this->usuario->mensajeLeido($idUsuario);
	}
	public function extension($str) 
	{
		return end(explode(".", $str));
	}
	public function main(){
		switch($this->opcion){
			case 'updateUsuario':
				self::updateUsuario($this->nombres,$this->appaterno,$this->apmaterno,$this->ci,$this->expedidoen,$this->newPass,$this->direccion,$this->telefonocel,$this->telefonofijo,$this->email,$this->idUsuario,$this->rol,$this->estado);
				break;
			case 'insertUsuario': 
				self::insertUsuario($this->nombres,$this->appaterno,$this->apmaterno,$this->ci,$this->expedidoen,$this->numcuenta,$this->direccion,$this->user,$this->pass,$this->telefonocel,$this->telefonofijo,$this->email,$this->rol,$this->img);
				break;
			case 'insertAdmin': 
				self::insertAdmin();
				break;
			case 'aceptarTerminosDeUso': self::aceptarTerminosDeUso($this->user);
				break;
			case 'updateMensajeLeido': self::updateMensajeLeido();
				break;
			case 'respuestaRevisarUsuario': self::respuestaRevisarUsuario();
				break;
		}
	}
}
$ud=new UsuarioDominio(@$_POST['opcion']);
$ud->main();
