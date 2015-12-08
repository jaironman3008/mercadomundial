<?php
include_once(MAINPATH.'/DBManager.php');
class Categoria extends DBManager
{

	public function __construct()
	{
		parent::__construct();
	}

	public function selectCategorias($registrosAEmpezar, $registrosAMostrar)
	{
		$query = "select * from categoriaarticulos  order by categoria asc limit $registrosAEmpezar, $registrosAMostrar";
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

	public function selectCountCategorias()
	{

		$query = "select * from categoriaarticulos order by categoria asc";
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

	public function insertCategoria($categoria)
	{

		$query = "insert into categoriaarticulos(categoria, ver,fechareg,horareg) values('$categoria','si',now(),now())";
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
			return true;

	}

	public function actualizarCategoria($idCategoria, $ver)
	{

		if ($ver == 'si')
			$ver = 'no';
		else
			$ver = 'si';
		$query = "update categoriaarticulos set ver='$ver' where idcategoria='$idCategoria'";
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
			return true;

	}

}
