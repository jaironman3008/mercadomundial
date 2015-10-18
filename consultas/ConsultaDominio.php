<?
include_once('Consulta.php');

class ConsultaDominio{
	
	private $opcion;
	private $consulta;	
	private $sendFrom;
	private $mensaje;
	
	public function __construct($sw=''){		
		$this->opcion=$sw;
		$this->consulta=new Consulta();
		$this->sendFrom=$_POST['sendFrom'];
		$this->mensaje=$_POST['mensaje'];		
	}
	
	public function paginarConsultas($RegistrosAEmpezar,$RegistrosAMostrar,$vista){
		return $this->consulta->paginarConsultas($RegistrosAEmpezar,$RegistrosAMostrar,$vista);
	}
	
	public function selectConsultas($vista){
		return $this->consulta->selectConsultas($vista);
	}
	
	public function guardarNuevaConsulta(){
		
		if($this->consulta->guardarNuevaConsulta($this->sendFrom,$this->mensaje)==true)
			echo'<br><br><br><h1>Consulta enviada exitosamente!!</h1>';
		else
			echo'<br><br><br><h1>No se pudo enviar la consulta!!</h1>';
	}
	
	public function main(){
		switch($this->opcion){
		case 'guardarNuevaConsulta': 
			self::guardarNuevaConsulta();break;
		}
	}
}
$cd= new ConsultaDominio($_POST['opcion']);
$cd->main();