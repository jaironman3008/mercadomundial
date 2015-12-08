<?php
include_once ('Login.php');//html
include_once ('Inicio.php');//html
include_once ('TerminosDeUso.php');//html

class Contenido
{
	private $inicio;
	private $opcion;
	private $terminosDeUso;
	private $terminos;

	public function __construct()
	{
		$this->inicio = new Inicio();
		$this->terminosDeUso = new TerminosDeUso();
		// $this->terminos=$term;
	}

	public function imprimirContenido()
	{
		$session = isset($_SESSION['rolusuario']) ? $_SESSION['rolusuario'] : "";
		switch($session)
		{

			case 'superadmin' :
				return $this->inicio->imprimirInicio();
				break;
			case 'admin' :
				return $this->inicio->imprimirInicio();
				break;
			case 'usuario' :
				return $this->inicio->imprimirInicio();
				break;
			default :
				return Login::imprimirLogin();
		}
	}
}
?>