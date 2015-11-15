<?php
include_once('MensajeDominio.php');

class Notificacion{
	
	private $mensajeDominio;
	
	public function __construct(){
		$this->mensajeDominio=new MensajeDominio();
	}
	
	public function pushNotificaciones(){
				
		$retornar="<script type='text/javascript'>";
		$retornar.="$(document).ready(";
		$retornar.="function()";
		$retornar.="{";
		//Opciones globales de las notificaciones
		$retornar.="$.extend($.gritter.options, {";
		$retornar.="position: 'bottom-right',";
		$retornar.="fade_in_speed: 'slow',";
		$retornar.="fade_out_speed: 3000,";
		$retornar.="time: '20000',";
		$retornar.="class_name: 'gritter-light'";
		$retornar.="});	";
				
		$sinLeer=$this->mensajeDominio->selectMisMensajes(isset($_SESSION['usuarioactual'])?$_SESSION['usuarioactual']:"",'recibidos');
		
		$total=0;
		for($i=0;$i<count($sinLeer);$i++){
			if($sinLeer[$i]['estado']=='sin leer')			
				$total=$total+1;
		}
		
		$retornar.=self::mensajesSinLeer($total);

		$retornar.="}";
		$retornar.=");";
		$retornar.="</script>";
		if($_SESSION["autentica"] == 'SIP'){
			if($total>0)
			return $retornar;
		}
	}
	public function mensajesSinLeer($total){
	
		
		
		$retornar="$('add-gritter-light').ready(function(){";
		$retornar.="$.gritter.add({";
		$retornar.="title: 'Mensajes',";
		$retornar.="text: 'Tienes ".$total." mensaje(s) sin leer',";
		$retornar.="image: 'images/sobre.png',";
		$retornar.="sticky: false";
		$retornar.="});";
		$retornar.="return false;";
		$retornar.="}";
		$retornar.=");";
		
		return $retornar;		
	}
	public function notificacionEnMora($cantidad){
			
		$retornar="$('add-gritter-light').ready(function(){";
		$retornar.="$.gritter.add({";
		$retornar.="title: 'CLIENTES EN MORA',";
		$retornar.="text: 'Tienes ". $cantidad." cliente(s) que esta(n) en mora',";
		$retornar.="image: 'images/informacion.png',";
		$retornar.="sticky: false";
		$retornar.="});";
		$retornar.="return false;";
		$retornar.="}";
		$retornar.=");";
		
		return $retornar;
	
	}
}
?>
