<?php
include_once('classUsuario.php');
// session_start();
class ValidateNewUser{
	
	private $usuario;
	private $opcion;
	private $userdata;
	private $passlength;
	private $pass1;
	private $pass2;
	
	public function __construct(){
		
		$this->opcion=$_POST['opcion'];
		$this->userdata=$_POST['userdata'];
		$this->passlength=$_POST['passlength'];
		$this->pass1=$_POST['pass1'];
		$this->pass2=$_POST['pass2'];
		$this->usuario= new classUsuario();
	
	}
	
	public function checkUser($dato){
		if($dato!=''){
			$result=$this->usuario->selectusuarios($dato);
			if(count($result)>0)
				return 'Usuario no disponible!!!';
			else return 'Disponible';
		}
		else return '';		
	}
	public function checkCi($dato){
		if($dato!=''){
			$result=$this->usuario->selectCi($dato);
			if(count($result)>0)
				return 'Un usuario ya se registro con este C.I.!!!';
			else return 'Ok';
		}
		else return '';		
	}
	public function checkLevelSecurity($dato){
		if($dato!=''){
			$len=strlen($dato);
			if($len>=0 && $len<5)
				return "Seguridad<progress id='progress' value='".$len."' max='15'/> Bajo";
			elseif($len>=5 && $len<10)
				return "Seguridad<progress id='progress' value='".$len."' max='15'/> Regular";
			elseif($len>=10)
				return "Seguridad<progress id='progress' value='".$len."' max='15'/> Bueno";
		}
		else return '';
	}
	
	public function checkRepeatPass($dato1,$dato2){
		if($dato1==$dato2)
			return 'Ok';
		else return 'Las contraseñas no coinciden!!!';
	}
	public function ejecutar(){
		switch($this->opcion){
			case 'checkUser' : $result=self::checkUser($this->userdata);break;
			case 'checkCi' : $result=self::checkCi($this->userdata);break;
			case 'checkLevelSecurity' : $result=self::checkLevelSecurity($this->passlength);break;
			case 'checkRepeatPass' : $result=self::checkRepeatPass($this->pass1,$this->pass2);break;
		}
		
		if(isset($_SESSION['autentica']) && isset($_SESSION['rolusuario']))
				echo $result;
		else echo "<script type='text/javascript'>alert('Acceso no autorizado!!!');	window.location='index.php';
			</script>";
	}
}
$vu=new ValidateNewUser();
$vu->ejecutar();