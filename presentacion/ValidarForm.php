<?
class ValidarForm{
	
	public function texto(){
	
		$html="type='text' placeholder='Solo Texto' title='Este campo solo admite texo' required pattern='|^[a-zA-Z ñÑáéíóúüç]*$|' ";
		return $html;		
	}
	public function telefono($tipo){
		if($tipo=='celular')$requerido='required';
		$html="type='text' placeholder='Numero telefono $tipo' $requerido title='Solo Numeros entre 5 y 13 digitos' pattern='[0-9]{5,13}' ";
		return $html;
	}
	public function numerico($min,$max){
		$html="type='number' min='$min' max='$max' value='0' required";
		return $html;
	}
	public function requerido(){
		$html=" placeholder='Este campo es requerido' title='Este campo es requerido' required";
		return $html;
	}
	public function docIdentidad(){
		$html=" placeholder='Documento obligatorio' type='text' title='Este campo es requerido' required";
		return $html;
	}
	public function cuentaBancariaBcp(){
		$html="type='text' placeholder='Ej: xxx-xxxxxxxx-x-xx' title='Este formato no coincide con el establecido' required pattern='[0-9]{3}\-[0-9]{8}\-[0-9]{1}\-[0-9]{2}'";
		return $html;
	}
	public function cuentaBancaria(){
		$html="type='text' placeholder='' title='Debe ingresar 14 digitos' required pattern='[0-9]{14}'";
		return $html;
	}
	public function contrasenia(){
		$html="type='password' placeholder='**************' title='entre 8 y 15 caracteres alfanumericos sin caracteres especiales ni espacios' required pattern='(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,15})$'";
		return $html;
	}
	public function email($opcion){
		if($opcion=='si')$requerido='required';
		$html="type='email' placeholder='mi@email.com' $requerido title='Escribe una direccion de email'";
		return $html;
	}
}