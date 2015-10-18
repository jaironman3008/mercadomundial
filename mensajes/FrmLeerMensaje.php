<?
include_once('MensajeDominio.php');
include_once('../presentacion/ValidarForm.php');

class FrmLeerMensaje{
	
	private $pagAct;
	private $mensajeDominio;
	private $idMensaje;
	private $validarForm;
	private $tipo;
	
	public function __construct(){
		$this->pagAct=$_POST['pagAct'];
		$this->mensajeDominio=new MensajeDominio();
		$this->idMensaje=$_POST['idMensaje'];
		$this->tipo=$_POST['tipo'];
		$this->validarForm=new ValidarForm();
	}
	public function imprimirForm(){
	
		$mensaje=$this->mensajeDominio->selectMensaje($this->idMensaje);
		$usuario=$this->mensajeDominio->getUsuarioFromId($mensaje[0]['idSendFrom']);
		$this->mensajeDominio->updateMensaje($mensaje[0]['idmensaje']);		
		
		if($this->tipo=='recibidos' && $usuario[0]['rol']=='usuario')
		$imgRespuesta=".::.<a href='javascript: void()' onclick=\"responderMensaje()\"><img src='images/sobreRespuesta.png' title='Responder' width='15px' height='auto'> Responder</a>";
		
		$html="<h1>Mensajes ".$this->tipo."</h1><p><b><a href='javascript: void()' id='atras'>Atras</a></b>
					$imgRespuesta</p>";
		$html.="
				<table width='47%' align='center'>						
					<tr class='tablaconten'>
						<input type='hidden' name='tipo' value='".$this->tipo."'/>";
						if($usuario[0]['rol']=='usuario')
							$html.="<td width='16%'><b>De: </b></td><td width='84%'>".$usuario[0]['usuario']."</td>";
						else$html.="<td width='16%'><b>ID Msg: </b></td><td width='84%'>".$mensaje[0]['idmensaje']."</td>";
					
					$html.="</tr>
					<tr class='tablaconten'>
						<td><b>Asunto: </b></td><td>".$mensaje[0]['asunto']."</td>
					</tr>
					<tr class='tablaconten'>
						<td><b>Fecha: </b></td><td>".self::fecha($mensaje[0]['fecha'])." a las ".$mensaje[0]['hora']."</td>
					</tr>
					<tr class='tablaconten' height='60px'>
						<td colspan='2'>".$mensaje[0]['mensaje']."</td>
					</tr>
				</table>				
			";
		echo $html.self::frmResponder($usuario[0]['usuario'],$mensaje[0]['asunto']);
	}
	public function frmResponder($usuario,$asunto){
		$requerido=$this->validarForm->requerido();
		$html="
			<form id='FrmResponderMensaje'>					
					<table id='divFrmRespuesta' width='47%' align='center'>
						<tr class='tablaconten'>
							<input type='hidden' name='pagAct' value='".$this->pagAct."'/>
							<td width='16%'><b>Para: </b></td><td width='84%'><p id='sendTo'>".$usuario."</p></td>							
						</tr>
						<tr class='tablaconten'>
							<td><b>Asunto: </b></td><td><p id='asunto'>".self::evaluarAsunto($asunto)."</p></td>
						</tr>						
						<tr class='tablaconten'>
							<td colspan='2'><textarea cols='30' rows='4' name='mensaje' $requerido ></textarea></td>
						</tr>
						<tr class='tablaconten'>
							<td colspan='2' align='center'><input type='Submit' value='Enviar'/><span class='maxlength'></span></td>
						</tr>
					</table>
					
				</form>
		";
		return $html;
	}
	public function fecha($fecha){
		if(date('d/m/Y',strtotime($fecha))==date('d/m/Y'))
			return $fecha='Hoy';
		elseif(date('d/m/Y',strtotime($fecha))==date('d/m/Y', mktime(0,0,0,date('m'),date('d')-1,date('Y'))))
			return $fecha='Ayer';
		else return$fecha=date('d/m/Y',strtotime($fecha));
	}
	public function evaluarAsunto($asunto){
		if(substr($asunto,0,4)=='RE.:')
			return $asunto;
		else 
			return 'RE.:'.$asunto;
	}
}
$lm=new FrmLeerMensaje();
$lm->imprimirForm();