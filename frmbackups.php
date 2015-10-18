<?
include('backup.php');

class FrmBackups{

	public function imprimirForm(){
		
		$backups=new Backup();
		$tablas=$backups->dbtablas();
	
		$text="<h1>Crear punto de restauracion</h1>		
		<form id='frmbackups' method='POST'>
		<div sylte='float:left'>
		<input type='hidden'  name='opcion' value='crear'/>
		<p>Puede crear un punto de restauracion, en caso de que necesite devolver el sistema a un estado anterior.</p>
		<p> 
		En la opcion 'Restaurar el sistema' aparecerá el último punto de restauracion creado, listo para restaurar
		el sistema a esa fecha o listo para ser descargado.</p>
		<table align='center' width='50%'>		
			<tr class='tablaconten'>
				<td align='center'>
					<input type='button' id='crearBackUps' value='Crear'></span>
				</td>
			</tr>
		</table>
		<p>La fecha y la hora actual se agregan automaticamente a su punto de restauracion.</p>
		</div>
		</form>";
		echo $text;
	}	
}
$fb= new FrmBackups(); 
$fb->imprimirForm();