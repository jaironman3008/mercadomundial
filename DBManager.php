<?php
class Conectar
{
	const host='localhost';
	const username='ivpxdtjy';
	const passwd='X1svlR3g23';
    const dbName='ivpxdtjy_dbMercadoMundial';

	public function con()
	{
		$mysqli = new mysqli(self::host, self::username, self::passwd, self::dbName);
		return $mysqli;
	}
	public function insertbitacora($detalle,$usuario,$idaccion)
	{
			$mysqli=self::con();
			$query="insert into bitacora(detalle,usuario,fecha,hora,idaccion) value('$detalle', '$usuario',now(),now(),'$idaccion')";
			$result = $mysqli->query($query);
			if(!$result)return false;
			else return true;
		
	}
}