<?
include_once('Categoria.php');
include_once('../presentacion/ValidarForm.php');

class FrmCategoria{
	private $categoria;
	private $validarForm;

	public function __construct(){
		$this->categoria=new Categoria();
		$this->validarForm=new ValidarForm();
	}
	
	public function imprimirForm(){
		$lista=$this->categoria->selectCategorias();
		$requerido=$this->validarForm->requerido();
		
		$form="
		<h1>Categorias</h1>		
		<br>
		<form id='FrmNuevaCategoria'>
			<table>
				<tr class='tablahead'>
					<td>Nueva Categoria: </td>
					<td><input type='text' $requerido name='categoria' class='inputmostrar'/><input type='submit' value='Agregar'/></td>					
				</tr>
				
			</table>
			
			<br>";
		$form.="<div style='overflow:auto; width:100%;height:300px'><br>";		
		$form.="<table align='center'>";		
		$form.="<tr class='tablahead'>
				<td>Nº</td>
				<td>Categoria</td>
				<td>Ver</td>
				</tr>";
		for($i=0;$i<count($lista);$i++){		
			$form.="<tr class='tablaconten'>";
			$form.="<td width='16' align='center'>".($i+1)."</td>";
			$form.="<td width='auto'>".$lista[$i]['categoria']."</td>";
			$form.="<td><input type='checkbox' name='ckbox[]' checked value='".$lista[$i]['categoria']."'/></td>";
			$form.="</tr>";				
		}
		$form.="</table>";
		$form.="</div>";
		$form.="</form>";
		
		echo $form;
	}	
}
$fc=new FrmCategoria();
$fc->imprimirForm();