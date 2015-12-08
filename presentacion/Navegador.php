<?php
include_once (MAINPATH . "/DominioManage.php");
class Navegador extends DominioManage
{

	private $rolUsuario;
	private $usuarioActual;
	private $idUsuarioActual;
	private $autentica;

	public function __construct()
	{
		$this->rolUsuario = $this->session("rolusuario");
		$this->usuarioActual = $this->session("usuarioactual");
		$this->idUsuarioActual = $this->session("idusuarioactual");
		$this->autentica = $this->session("autentica");
	}

	public function imprimirNavegador()
	{
		$retornar = "";
		var_dump($this->autentica);
		exit ;
		if ($this->autentica == "SIP")
		{
			$retornar = "<div id='navegador'>";
			$retornar .= "<a id='linkInicio' href='javascript: void()'>Inicio </a>.::.						
						<a id='linkConsultas' href='javascript:void()'>Consultas </a>.::.
						<a id='linkPreguntasFrecuentes' href='javascript:void()'>Preguntas frecuentes </a>.::.
						<font id='usuarioActual'>" . $this->usuarioActual . "</font>@<font id='rolUsuario'>" . $this->rolUsuario . "</font> .::.
						<span id='idUsuarioActual' style='display:none'>" . $this->idUsuarioActual . "</span>
						<a id='linkCerrarSesion' href='javascript: void();'> Cerrar Sesion</a>
						
						";
			$retornar .= "</div>";

		}
		else
			$retornar .= "<br>";
		return $retornar;
	}

}
