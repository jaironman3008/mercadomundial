<?php
class Navegador{

	private $rolUsuario;
	private $usuarioActual;
	private $idUsuarioActual;
	private $autentica;
	
	public function __construct(){
		$this->rolUsuario=$_SESSION['rolusuario'];
		$this->usuarioActual=$_SESSION['usuarioactual'];
		$this->idUsuarioActual=$_SESSION['idusuarioactual'];
		$this->autentica=$_SESSION["autentica"];
	}
	
	public function imprimirNavegador(){
			
		if( $this->autentica== "SIP"){
			$retornar="<div id='navegador'>";
			$retornar.="<a id='linkInicio' href='javascript: void()'>Inicio </a>.::.						
						<a id='linkConsultas' href='javascript:void()'>Consultas </a>.::.
						<a id='linkPreguntasFrecuentes' href='javascript:void()'>Preguntas frecuentes </a>.::.
						<font id='usuarioActual'>".$this->usuarioActual."</font>@<font id='rolUsuario'>".$this->rolUsuario."</font> .::.
						<span id='idUsuarioActual' style='display:none'>".$this->idUsuarioActual."</span>
						<a id='linkCerrarSesion' href='javascript: void();'> Cerrar Sesion</a>
						
						";
			$retornar.="</div>";
			
		}
		else$retornar.="<br>";
		return $retornar;
	}	
}