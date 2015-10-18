<?
include_once('classUsuario.php');
session_start();
class ValidateOldUser{
	
	private $usuario;
	private $opcion;
	private $oldPass;
	private $passlength;
	private $pass1;
	private $pass2;
	
	public function __construct(){
		
		$this->opcion=$_POST['opcion'];
		$this->oldPass=$_POST['oldPass'];
		$this->passlength=$_POST['newPass'];
		$this->pass1=$_POST['pass1'];
		$this->pass2=$_POST['pass2'];
		$this->usuario= new classUsuario();
	
	}
	
	public function checkOldPass($dato){
		if($dato!=''){
			$result=$this->usuario->password($_SESSION['usuarioactual'],md5($dato));
			if(count($result)<=0)
				return 'Password Incorrecto!!!';
			else return "OK!!!";
		}
		else return '';		
	}
	
	public function checkNewPass($dato){
		if($dato!=''){
			$len=strlen($dato);
			if($len>=0 && $len<5)
				return "Seguridad <progress id='progress' value='".$len."' max='15'/> Bajo";
			elseif($len>=5 && $len<10)
				return "Seguridad <progress id='progress' value='".$len."' max='15'/> Regular";
			elseif($len>=10)
				return "Seguridad <progress id='progress' value='".$len."' max='15'/> Bueno";
		}
		else return '';
	}
	
	public function confirNewPass($dato1,$dato2){
		if($dato1==$dato2)
			return "<p id='resConfirNewPass'>OK!!!</p>";
		else return 'Las contraseñas no coinciden!!!';
	}
	public function ejecutar(){
		switch($this->opcion){
			case 'checkOldPass' : $result=self::checkOldPass($this->oldPass);break;
			case 'checkNewPass' : $result=self::checkNewPass($this->passlength);break;
			case 'confirNewPass' : $result=self::confirNewPass($this->pass1,$this->pass2);break;
		}
		
		if(isset($_SESSION['autentica']) && isset($_SESSION['rolusuario']))
				echo $result;
		else echo "<script type='text/javascript'>alert('Acceso no autorizado!!!');	window.location='index.php';
			</script>";
	}
}
$vu=new ValidateOldUser();
$vu->ejecutar();