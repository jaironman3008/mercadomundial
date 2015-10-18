<?php
include_once('../DBManager.php');

Class Contrato{
	private $conectar;
	private $mysqli;

	public function __construct()
	{
		$this->conectar = new Conectar();
		$this->mysqli = $this->conectar->con();

	}
	
	public function insertContrato($texto)
	{

		$query = "insert into contratos(texto,fechareg,horareg) values('".htmlentities($texto)."',now(),now())";

		$result = $this->mysqli->query($query);

		if (!$result)
			return false;
		else
			return true;

	}
	public function getContrato(){
		$query = "select * from contratos order by idcontrato desc limit 1";
		$result = $this->mysqli->query($query);
		if (!$result)
			return false;
		else
		{
			while ($reg = $result->fetch_assoc())
			{
				$resp[] = $reg;
			}
			return $resp;
		}
	}
}