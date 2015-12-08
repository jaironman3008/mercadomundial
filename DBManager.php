<?php
class DBManager
{
	private $_host;
	private $_userName;
	private $_password;
	private $_dataBaseName;
	protected $_mySql;

	public function __construct()
	{
		$this->_host = "localhost";
		$this->_userName = "root";
		$this->_password = "";
		$this->_dataBaseName = "mercadomundial";
		$this->mySql = new mysqli($this->_host, $this->_userName, $this->_password, $this->_dataBaseName);
	}

	public function insertbitacora($detalle, $usuario, $idaccion)
	{
		$mysqli = self::con();
		$query = "insert into bitacora(detalle,usuario,fecha,hora,idaccion) value('$detalle', '$usuario',now(),now(),'$idaccion')";
		$result = $mysqli->query($query);
		if (!$result)
			return false;
		else
			return true;

	}

	public function __toString()
	{

	}

	protected function save()
	{

	}

}
