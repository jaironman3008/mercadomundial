<?php
include_once('ContratoDominio.php');

Class FrmNuevoContrato{

	private $contratoDominio;
	private $opcion;

	public function __construct($sw=''){
		$this->contratoDominio=new ContratoDominio();
		$this->opcion=$sw;
	}

	public function printFrm(){
		$html="<h1>Nuevo Contrato</h1>";
		$html.="
			Este formulario aun no esta en completamente listo, para que vuelva a aparecer el editor de texto recargue la pagina y vuelva a seleccionar 'Nuevo contrato'
			<br>
			<form id='FrmNuevoContrato'>
			<center>
				<textarea cols='30' id='elm1' class='tinymce' name='texto'></textarea>
				<input type='Submit' value='Guardar'/><input type='button' id='cancelarFrmNuevoContrato' value='Cancelar'/>
			</center>
			</form>
			
		";
		echo $html;
	}
	public function main(){
		switch($this->opcion){
			case 'frmNuevoContrato':self::printFrm();break;
		}
	}
}
$fnc=new FrmNuevoContrato($_POST['opcion']);
$fnc->main();
?>
<script type='text/javascript'>
	$(document).ready(function(){
		tinymce.init({
			selector: ".tinymce",
			plugins: [
		         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
		         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
		         "table contextmenu directionality emoticons paste textcolor"
		   ],
		   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
		   toolbar2: "| link unlink anchor | image media | forecolor backcolor  | print preview code",
		   image_advtab: true		   
		});
	});
</script>