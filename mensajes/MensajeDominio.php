<?
include_once('Mensaje.php');

class MensajeDominio{

	private $mensaje;
	private $listaMensajes;
	private $opcion;
	
	public function __construct($sw=''){
		$this->mensaje=new Mensaje();
		$this->listaMensajes=array();
		$this->opcion=$sw;
	}
	public function getUsuarioFromId($idUsuario){
		return $this->mensaje->getUsuarioFromId($idUsuario);
	}
	public function insertMensaje($sendFrom,$sendTo,$asunto,$mensaje){		
		if($this->mensaje->insertMensaje($sendFrom,$sendTo,$asunto,$mensaje)==true)
			echo '<br><br><br><h1>Mensaje enviado!!</h1>';
		else echo'<br><br><br><h1>No se pudo enviar!!</h1>';
	}
	public function guardarNuevaConsulta(){/********************************************CONSULTAS*/
		
		if($this->mensaje->guardarNuevaConsulta($_POST['sendFrom'],$_POST['mensaje'])==true)
			echo'<br><br><br><h1>Consulta enviada exitosamente!!</h1>';
		else
			echo'<br><br><br><h1>No se pudo enviar la consulta!!</h1>';
	}
	public function paginarMisMensajes($RegistrosAEmpezar,$RegistrosAMostrar,$vista,$tipo){
		
		return $this->mensaje->paginarMisMensajes($RegistrosAEmpezar,$RegistrosAMostrar,$vista,$tipo);
		
	}
	public function selectMisMensajes($usuario,$tipo){
		
		return $this->mensaje->selectMisMensajes($usuario,$tipo);
		
	}
	public function borrarMensaje($idMensaje,$pag='',$vista='',$tipo){
		if($pag!='' && $vista!=''){
			if($this->mensaje->borrarMensaje($idMensaje)==true){				
				echo "<script>
				//alert('$vista');
				$(document).ready(function(){
					
				$.ajax({
					type: 'GET',
					url: 'mensajes/VistaMisMensajes.php',
					data: 'pag=$pag&vista=$vista&tipo=$tipo',
					beforeSend: beforeSendImg(),
					success: function(data){
								$('#contenido').html(data);						
							}			
				 });
				 });
					  </script>";
			}
			else{
				echo"<script>			
				$(document).ready(function(){	
				alert('Mmm..Hemos tenido un error. Por favor intente de nuevo');
				$.ajax({
					type: 'GET',
					url: 'mensajes/VistaMisMensajes.php',
					data: 'pag=$pag&vista=$vista&tipo=$tipo', 
					beforeSend: beforeSendImg(),
					success: function(data){
								$('#contenido').html(data);						
							}			
				 });
				 });
					  </script>";
			}
		}
		else $this->mensaje->borrarMensaje($idMensaje);
	}
	public function updateMensaje($idMensaje,$pag='',$vista=''){
		if($pag!='' && $vista!=''){
			if($this->mensaje->updateMensaje($idMensaje)==true){				
				echo "<script>
				//alert('$vista');
				$(document).ready(function(){
					
				$.ajax({
					type: 'GET',
					url: 'mensajes/VistaMisMensajes.php',
					data: 'pag=$pag&vista=$vista&tipo=recibidos',
					beforeSend: beforeSendImg(),
					success: function(data){
								$('#contenido').html(data);						
							}			
				 });
				 });
					  </script>";
			}
			else{
				echo"<script>			
				$(document).ready(function(){	
				alert('Mmm..Hemos tenido un error. Por favor intente de nuevo');
				$.ajax({
					type: 'GET',
					url: 'mensajes/VistaMisMensajes.php',
					data: 'pag=$pag&vista=$vista&tipo=recibidos', 
					beforeSend: beforeSendImg(),
					success: function(data){
								$('#contenido').html(data);						
							}			
				 });
				 });
					  </script>";
			}
		}
		else $this->mensaje->updateMensaje($idMensaje);
	}
	public function selectMensaje($idMensaje){
		return $this->mensaje->selectMensaje($idMensaje);		
	}
	public function ejecutar(){
		switch($this->opcion){
			case 'insertMensaje': self::insertMensaje($_POST['sendFrom'],$_POST['sendTo'],$_POST['asunto'],$_POST['mensaje']);break;
			case 'updateMensaje': self::updateMensaje($_POST['idMensaje'],$_POST['pag'],$_POST['vista']);break;
			case 'borrarMensaje': self::borrarMensaje($_POST['idMensaje'],$_POST['pag'],$_POST['vista'],$_POST['tipo']);break;
			case 'guardarNuevaConsulta': self::guardarNuevaConsulta();break;
		}
	}
}
$md=new MensajeDominio($_POST['opcion']);
$md->ejecutar();