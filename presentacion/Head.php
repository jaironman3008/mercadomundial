<?php
include('mensajes/notificaciones.php');

class Head{
	
	private $notificacion;
	
	public function __construct(){
		$this->notificacion=new Notificacion();
	}
	
	public function imprimirHead(){
		
		$head.="<head>
					<title>Mercado Mundial</title>
					<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
					<link rel='shortcut icon' type='image/x-icon' href='images/minilogo.ico'>
					<link type='text/css' rel='stylesheet' href='css/estilos.css'/>
					<link type='text/css' rel='stylesheet' href='css/jquery.gritter.css'/>
					<link type='text/css' rel='stylesheet' href='css/styleWowSlider.css'/>
					<link type='text/css' rel='stylesheet' href='css/jquery-ui.css'/>					
					<script type='text/javascript' src='js/jquery-1.10.2.min.js'></script>
					<script type='text/javascript' src='js/jquery-ui-1.10.4.min.js'></script>
					<script type='text/javascript' src='js/jquery.gritter.min.js'></script>
					<script type='text/javascript' src='js/tinymce/js/tinymce/tinymce.dev.js'></script>					
					<script type='text/javaScript' src='js/js.js'></script>
					";		
		$head.="</head>";
		$head.=$this->notificacion->pushNotificaciones();
		return $head;
	}
}
?>