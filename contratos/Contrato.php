<?php
include_once(MAINPATH.'/DBManager.php');

Class Contrato extends DBManager
{
	public function __construct()
	{
		parent::__construct();
	}

	public function insertContrato($texto)
	{
		$query = "insert into contratos(texto,fechareg,horareg) values('" . htmlentities($texto) . "',now(),now())";

		$result = $this->mySql->query($query);

		if (!$result)
			return false;
		else
			return true;
	}

	public function getContrato()
	{
		$query = "select * from contratos order by idcontrato desc limit 1";
		$result = $this->mySql->query($query);
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
