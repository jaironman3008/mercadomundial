<?php
include_once('Contrato.php');

Class ContratoDominio{

	private $texto;
	private $opcion;
	private $contrato;

	public function __construct($sw=''){
		$this->texto=$_POST['texto'];
		$this->opcion=$_POST['opcion'];
		$this->contrato=new Contrato();
	}

	public function insertContrato(){
		if($this->contrato->insertContrato($this->texto)==true){
			echo "<br><br><br><h1>contrato agregado exitosamente..!!</h1>";
		}
		else{
			echo'<br><br><br><h1>Ocurrio un error..Intente de nuevo!!</h1>';	
		}
	}

	public function getContrato(){
		$resp=$this->contrato->getContrato();
		if(count($resp)>0)
			return $resp[0]['texto'];
		else 
			return '';
	}
	public function main(){
		switch($this->opcion){
			case 'insertContrato':self::insertContrato();break;
		}
	}

}
$cd=new ContratoDominio($_POST['opcion']);
$cd->main();