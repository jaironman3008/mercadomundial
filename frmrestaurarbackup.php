<?
include_once('backup.php');

class FrmRestaurarBackups{
	
	private $backups;
	
	public function __construct(){
	
	$this->backups= new Backup();
	
	}
	
	public function imprimirForm(){
		
		$lista=$this->backups->getbackups();		
		$html="<h1>Restaurar Sistema</h1>";
		if(count($lista)>0)
			$html.="<p>El ultimo punto de restauracion fue creado en fecha <b>".$lista[0]['fecha']."</b> a horas <b>".$lista[0]['hora']."</b></p>
				<p>Que desea hacer?</p>			
				<input type='hidden' name='filename' value='".$lista[0]['filename']."'>
				<input type='hidden' name='fecha' value='".$lista[0]['fecha']."'>
				<input type='hidden' name='hora' value='".$lista[0]['hora']."'>
				<p>
					1) <a href='javascript:void()'; id='restaurarBackUps'>Restaurar sistema a ese punto.</a><br>				
					2) <a href='javascript:void()'; id='descargar'>Descargar el archivo de restauracion.</a>
				</p>
				<div id='result'></div>
				";
		else
			$html.="
				<p>No se ha creado ningun punto de restauracion. Para crear uno vaya al la opcion
					'Crear punto de restauracion' en el menu lateral derecho en la seccion 'Restaurar Sistema'.
				</p>
			";
		echo $html;
	
	}
}		
$fr= new FrmRestaurarBackups();
$fr->imprimirForm();