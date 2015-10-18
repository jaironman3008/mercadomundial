<?php
class FrmConsultas{
	
	private $opcion;
	
	public function __construct(){
		$this->opcion=$_POST['opcion'];
	}
	
	public function imprimirForm(){
		$html="<h1>Consultas</h1>";
		$html.="
			<br>
			<form id='FrmNuevaConsulta' method='POST'>
			<center>
			<p>Escribe aqui todas las preguntas, consultas o reclamos que tengas.</p><br>
			<table>								
				<tr class='tablaconten'>
					<td><p>Escribe tu mensaje</p></td>
				</tr>
				<tr class='tablaconten'>
					<td align='center'>
						<textarea cols='30' id='elm1' name='mensaje' rows='8'></textarea>
					</td>
				</tr>
				<tr class='tablaconten'>
					<td align='center'>
					<input type='Submit' value='Enviar'/><input type='button' id='cancelarFrmNuevaConsulta' value='Cancelar'/><span class='maxlength'></span>
					</td>
				</tr>	
			</table>
			</center>
			</form>
		";
		if($this->opcion=='imprimirForm')
			echo $html;
	}	
}
$fc=new FrmConsultas();
$fc->imprimirForm();



