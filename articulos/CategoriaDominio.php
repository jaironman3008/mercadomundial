<?
include_once('Categoria.php');

class CategoriaDominio{

	private $categoria;
	private $idCategoria;
	private $categ;
	private $estado;
	private $opcion;

	public function __construct($sw=''){	
		$this->categoria=new Categoria();		
		$this->idCategoria=$_POST['idCategoria'];
		$this->estado=$_POST['ver'];
		$this->categ=$_POST['categoria'];		
		$this->opcion=$sw;
	}
	public function selectCategorias($registrosAEmpezar,$registrosAMostrar){
		return $this->categoria->selectCategorias($registrosAEmpezar,$registrosAMostrar);
	}
	public function selectCountCategorias(){
		return $this->categoria->selectCountCategorias();
	}
	public function insertCategoria($categ){
		if($this->categoria->insertCategoria($categ)==true)		
			echo'<br><br><br><h1>Categoria Guardada!!</h1>';						
		
		else echo'<br><br><br><h1>No se pudo guardar!!</h1>';	
		
	}
	public function actualizarCategoria($idCategoria,$estado){
		if($this->categoria->actualizarCategoria($idCategoria,$estado)!=true)
			echo '<br><br><br><h1>Ocurrio un error. No se pudo actualizar el estado!!</h1>';
	}
	public function main(){
		switch($this->opcion){
			case 'insertCategoria': self::insertCategoria($this->categ);break;
			case 'actualizarCategoria': self::actualizarCategoria($this->idCategoria,$this->estado);break;
		}
	}
}
$cd=new CategoriaDominio($_POST['opcion']);
$cd->main();