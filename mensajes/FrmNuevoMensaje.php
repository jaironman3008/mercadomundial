<?
include_once('../articulos/Articulo.php');
include_once('../presentacion/ValidarForm.php');
include_once('Mensaje.php');
class FrmNuevoMensaje{
	
	private $articulo;
	private $lista;
	private $validarForm;
	
	public function __construct(){
		$this->articulo=new Articulo();
		$this->validarForm=new ValidarForm();
	}
	
	public function imprimirForm(){
		
		if($_POST['openFrom']=='vistaUsuarios'){
			$sendTo=$_POST['id'];
			$descripcionArticulo='';
			$btnCancel="<input type='button' id='cancelarEnvioMensajeVistaUsuarios' value='Cancelar'/>";
		}
		else{
			$this->lista=$this->articulo->getArticuloFromId($_POST['id']);
			$this->usuario=$this->articulo->getUsuario($this->lista[0]['idusuario']);
			$sendTo=$this->lista[0]['idusuario'];
			$descripcionArticulo=self::descripcionArticulo($this->lista,$this->usuario);
			$btnCancel="<input type='button' id='cancelarEnvioMensajeSobreArticulo' value='Cancelar'/>";
		}
		
		$requerido=$this->validarForm->requerido();

		$html="<h1>Enviar Mensaje</h1><br>";
		$html.="<form id='FrmNuevoMensaje'>";
		$html.="<table align='center'>
					<tr class='tablaconten'>
						<td><b>Asunto</b></td>
						<td><input class='inputmostrar' type='text' name='asunto' $requerido/></td>
						<input type='hidden' id='sendTo' value='".$sendTo."'/>
					</tr>
					<tr class='tablaconten'>
						<td><b>Mensaje</b><br><span class='maxlength'></span></td>
						<td><textarea cols='20' rows='4' name='mensaje' $requerido></textarea></td>
					</tr>
					<tr class='tablaconten'>
						<td align='center' colspan='2'><input type='Submit' value='Enviar'/> $btnCancel</td>
					</tr>
				</table>
				</form>
				<br>
				".$descripcionArticulo."
				";
		echo $html;
	}
	public function descripcionArticulo($lista,$usuario){
		$html="
			<table align='center'>
				<tr class='tablahead'>
					<td colspan='3'><b>Articulo Elegido</b></td>
				</tr>
				<tr class='tablaconten'>
					<td align='center'><img width='140' height='auto' src='images/".$lista[0]['categoria']."/".$lista[0]['img']."'/></td>
						<td><input type='hidden' value='".$lista[0]['categoria']."' name='categoria'>
							<font>DESCRIPCION:</font>".$lista[0]['descripcion']."<br>								
							
							";
						if($lista[0]['subasta']>0){
							$html.="<h2>ESTE ARTICULO SE ESTA SUBASTANDO</h2>";
							$html.="<font>OFERTA MINIMA: </font>".$lista[0]['subasta']." Bs.<br>";								
						}
						else{
							if($lista[0]['oferta']>0){
								$html.="<font>ANTES: </font><s>".$lista[0]['precio']."</s> Bs.<br>
								<font>AHORA: </font>".$lista[0]['oferta']."<br>";
							}
							else{								
								$html.="<font>PRECIO: </font>".$lista[0]['precio']." Bs.<br>";
							}
						}
							$html.="<font>ESTADO: </font>".$lista[0]['estado']."<br>
							<font>PUBLICADO POR EL USUARIO: </font><font>".$usuario[0]['usuario']."</font><br>
							<font>FECHA DE PUBLICACIÓN: </font>".$lista[0]['fechareg']." ".$lista[0]['horareg']."<br>																	
						</td>";
						if($lista[0]['subasta']>0){
							$html.="<td>
								<font>5 Mejores Ofertas</font>
								</td>
							</tr>";
						}
				$html.="</tr>
			</table>
		";
		return $html;
	}
}
$fnm=new FrmNuevoMensaje();
$fnm->imprimirForm();
