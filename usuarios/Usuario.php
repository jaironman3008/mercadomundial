<?php
include_once (MAINPATH . '/DBManager.php');

class Usuario extends DBManager
{
	const TABLENAME = 'usuarios';
	const ID = 'idusuario';

	private $_idusuario;
	private $_nombre;
	private $_appaterno;
	private $_apmaterno;
	private $_fecharegistro;
	private $_horaregistro;
	private $_ci;
	private $_expedidoen;
	private $_direccion;
	private $_usuario;
	private $_numcuenta;
	private $_contrasenia;
	private $_telefonocel;
	private $_telefonofijo;
	private $_email;
	private $_rol;
	private $_estado;
	private $_addedby;
	private $_depositoImg;
	private $_terminosDeUso;
	private $_cuentaVencida;
	private $_revisado;
	private $_revisadopor;

	public function __construct($nombre, $appaterno, $apmaterno, $ci, $expedidoen, $direccion, $usuario, $nrocuenta, $contrasenia, $telefonocel, $telefonofijo, $email, $rol, $estado, $addedby, $depositImg, $terminosDeUso, $cuentaVencida, $revisado, $revisadopor)
	{
		parent::__construct();
		$this->_nombre = $nombre;
		$this->_appaterno = $appaterno;
		$this->_apmaterno = $apmaterno;
		$this->_fecharegistro = date("Y-m-d");
		$this->_horaregistro = date("H:i:s");
		$this->_ci = $ci;
		$this->_expedidoen = $expedidoen;
		$this->_direccion = $direccion;
		$this->_usuario = $usuario;
		$this->_numcuenta = $numcuenta;
		$this->_contrasenia = $contrasenia;
		$this->_telefonocel = $telefonocel;
		$this->_telefonofijo = $telefonofijo;
		$this->_email = $email;
		$this->_rol = $rol;
		$this->_estado = $estado;
		$this->_addedby = $addedby;
		$this->_depositoImg = $depositImg;
		$this->_terminosDeUso = $terminosDeUso;
		$this->_cuentaVencida = $cuentaVencida;
		$this->_revisado = $revisado;
		$this->_revisadopor = $revisadopor;
	}

	public function getNombre()
	{
		return $this->_nombre;
	}

	public function getApPaterno()
	{
		return $this->_appaterno;
	}

	public function getApMaterno()
	{
		return $this->_apmaterno;
	}

	public function getFechaRegistro()
	{
		return $this->_fecharegistro;
	}

	public function getHoraRegistro()
	{
		return $this->_horaregistro;
	}

	public function getCi()
	{
		return $this->_ci;
	}

	public function getExpedidoEn()
	{
		return $this->_expedidoen;
	}

	public function getDireccion()
	{
		return $this->_direccion;
	}

	public function getNickName()
	{
		return $this->_usuario;
	}

	public function getNumeroDeCuenta()
	{
		return $this->_numcuenta;
	}

	public function getPassword()
	{
		return $this->_contrasenia;
	}

	public function getTelefonoCel()
	{
		return $this->_telefonocel;
	}

	public function getTelefonoFijo()
	{
		return $this->_telefonofijo;
	}

	public function getEmail()
	{
		return $this->_email;
	}

	public function getRol()
	{
		return $this->_rol;
	}

	public function getEstado()
	{
		return $this->_estado;
	}

	public function getAddedBy()
	{
		return $this->_addedby;
	}

	public function getDepositoImg()
	{
		return $this->_depositoImg;
	}

	public function getTerminosDeUso()
	{
		return $this->_terminosDeUso;
	}

	public function getCuentaVencida()
	{
		return $this->_cuentaVencida;
	}

	public function getRevisado()
	{
		return $this->_revisado;
	}

	public function getRevisadoPor()
	{
		return $this->_revisadopor;
	}
	
	public static function login($nickName, $password){
		$sql = "select * from ".static::TABLENAME." where usuario = ".$this->mySql->real_escape_string($nickName)." and contrasenia = ".md5($password);
		$query = $this->mySql->query($sql);
		var_dump($query);exit;
	}
	
	public function getById($id){
		$sql = "select * from ".static::TABLENAME." where ".static::ID."=".$this->mySql->real_escape_string($id);
		$query = $this->mySql->query($sql);
		
	}
	
	public function paginarusuarios($RegistrosAEmpezar, $RegistrosAMostrar, $usuario)
	{

		if ($usuario == '')
			$query = "select * from usuarios order by appaterno limit $RegistrosAEmpezar, $RegistrosAMostrar";
		else
			$query = "select * from usuarios where usuario like '$usuario%' order by appaterno limit $RegistrosAEmpezar, $RegistrosAMostrar";
		$result = $this->mySql->query($query);
		if (!$result)
		{
			return false;
		}
		else
		{
			while ($reg = $result->fetch_assoc())
			{
				$resp[] = $reg;
			}
			return $resp;
		}

	}

	public function selectusuarios($dato)
	{
		$resp = array();
		if ($dato == '')
			$query = "select * from usuarios";
		else
			$query = "select * from usuarios where usuario='$dato'";

		$result = $this->mySql->query($query);
		if (!$result)
		{
			return false;
		}
		else
		{
			while ($reg = $result->fetch_assoc())
			{
				$resp[] = $reg;
			}
			return $resp;
		}
	}

	public function selectCi($dato)
	{

		$query = "select * from usuarios where ci='$dato'";
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
		{
			while ($reg = $result->fetch_assoc())
			{
				$listaCi[] = $reg;
			}
			return $listaCi;
		}

	}

	public function paginarMisInvitados($RegistrosAEmpezar, $RegistrosAMostrar, $usuario)
	{
		list($usuario, $check) = split('[/.-]', $usuario);
		if ($check == 'revisar')
		{
			$check = "revisadopor";
			$and = "and revisado='no'";
		}
		else
		{
			$check = "addedby";
		}

		$misInvitados = self::returnPadre($usuario);
		if ($usuario == '')
			$query = "select * from usuarios order by appaterno limit $RegistrosAEmpezar, $RegistrosAMostrar";
		else
			$query = "select * from usuarios where $check='" . $misInvitados[0]['idusuario'] . "' " . $and . " order by appaterno limit $RegistrosAEmpezar, $RegistrosAMostrar";
		$result = $this->mySql->query($query);
		if (!$result)
		{
			return false;
		}
		else
		{
			while ($reg = $result->fetch_assoc())
			{
				$resp[] = $reg;
			}
			return $resp;
		}

	}

	public function selectMisInvitados($dato)
	{

		list($dato, $check) = split('[/.-]', $dato);
		if ($check == 'revisar')
		{
			$check = "revisadopor";
			$and = "and revisado='no'";
		}
		else
			$check = "addedby";

		$misInvitados = self::returnPadre($dato);
		if ($dato == '')
			$query = "select * from usuarios";
		else
			$query = "select * from usuarios where $check='" . $misInvitados[0]['idusuario'] . "'" . $and;
		$result = $this->mySql->query($query);
		if (!$result)
		{
			return false;
		}
		else
		{
			while ($reg = $result->fetch_assoc())
			{
				$resp[] = $reg;
			}
			return $resp;
		}
	}

	public function password($dato, $pass)
	{

		$query = "select * from usuarios where usuario='$dato' and contrasenia='$pass'";
		$result = $this->mySql->query($query);
		if (!$result)
		{
			return false;
		}
		else
		{
			while ($reg = $result->fetch_assoc())
			{
				$resp[] = $reg;
			}
			return $resp;
		}

	}

	public function buscarusuario($dato)
	{

		$query = "select idusuario,nombre,appaterno,apmaterno,fecharegistro,horaregistro,ci,direccion,usuario,telefonocel,telefonofijo,rol,estado from usuarios where usuario like '$dato%'";
		$result = $this->mySql->query($query);
		if (!$result)
		{
			return false;
		}
		else
		{
			while ($reg = $result->fetch_assoc())
			{
				$resp[] = $reg;
			}
			return $resp;
		}

	}

	public function updateusuario($nombres, $appaterno, $apmaterno, $ci, $expedidoen, $pass, $direccion, $telefonocel, $telefonofijo, $email, $idusuario, $img, $rol, $estado)
	{

		if ($pass != '')
			$pass = ", contrasenia='" . md5($pass) . "'";
		
else
			$pass = "";

		$query = "update usuarios set nombre='$nombres', appaterno='$appaterno', apmaterno='$apmaterno', ci='$ci',expedidoen='$expedidoen', rol='$rol', estado='$estado' $pass, direccion='$direccion', telefonocel='$telefonocel', telefonofijo='$telefonofijo',email='$email', depositoImg='$img' where idusuario='$idusuario'";
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
			return true;

	}

	public function respuestaRevisarUsuario($respuestaRevision, $idUsuarioRevisado)
	{

		$query = "update usuarios set revisado='$respuestaRevision' where idusuario='$idUsuarioRevisado'";
		$result = $this->mySql->query($query);
		if ($result)
			return true;
		else
			return false;

	}

	public function desactivarUsuario($idUsuario)
	{

		$usuario1 = new Usuario();
		$usuario2 = new Usuario();

		$hijos = array();
		$usuario = $usuario1->returnUsuario($idUsuario);

		$padre = $usuario[0]['addedby'];
		//selecciono al padre del usuario
		$curUser = $usuario[0]['usuario'];
		//selecciono al usuario actual
		$hijos = self::selectMisInvitados($curUser);
		//selecciono los hijos del usuario
		$modifi = 0;
		for ($i = 0; $i < count($hijos); $i++)
		{
			$query = "update usuarios set addedby='$padre' where idusuario='" . $hijos[$i]['idusuario'] . "'";
			$result = $this->mySql->query($query);
			if ($result)
				$modifi = $modifi + 1;
		}

		if (count($hijos) == $modifi)
		{
			$beneficiado = $usuario2->returnUsuario($padre);
			return "Los $modifi invitados del usuario <b>" . $usuario[0]['usuario'] . "</b> fueron pasados al usuario <b>" . $beneficiado[0]['usuario'] . "</b>";
		}
		else
		{
			return "Comuniquese con el administrador del Sistema... $modifi de " . count($hijos) . " invitados del usuario <b>" . $usuario[0]['usuario'] . "</b> fueron pasados al usuario <b>" . $beneficiado[0]['usuario'] . "</b>";
		}

	}

	public function desactivarArticulos($idUsuario)
	{

		$modifi = 0;
		$vendido = 0;
		$articulos = self::getCountMisArticulos($idUsuario);

		for ($i = 0; $i < count($articulos); $i++)
		{
			if ($articulo[$i]['estado'] != 'vendido')
			{
				$query = "update articulos set estado='inactivo' where idarticulo='" . $articulo[$i]['idarticulo'] . "'";
				$result = $this->mySql->query($query);
				if ($result)
					$modifi = $modifi + 1;
			}
			else
				$vendido = $vendido + 1;
		}
		if ($vendido == 0)
		{
			if ($modifi == count($articulos))
				return "Los $modifi articulos de este usuario fueron desactivados, ya no apareceran en las categorias";
			else
				return "Comuniquese con el administrador...$modifi de " . count($articulos) . " fueron desactivados, ya no apareceran en las categorias";
		}
		else
			return "A este usuario le quedaban " . ($vendido - (count($articulos))) . " articulos sin vender que acaban de ser desactivados, ya no apareceran en las categorias";

	}

	public function getCountMisArticulos($vista = '')
	{

		switch($vista)
		{
			case 'ofertas' :
				$filtro = "and oferta > 0";
				break;
			case 'subastas' :
				$filtro = "and subasta > 0";
				break;
			case 'recienPublicados' :
				$filtro = "and DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= a.fechareg;";
				break;
			case $vista :
				$filtro = "and idusuario='$vista'";
				break;
			default :
				$filtro = "and categoria='$vista'";
		}
		$query = "select idarticulo, descripcion, categoria,precio, oferta, img,idusuario, estado, a.fechareg, a.horareg, subasta
				from articulos a, categoriaarticulos c
				where a.idcategoria=c.idcategoria and idusuario='$vista'";
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
		{
			while ($reg = $result->fetch_assoc())
			{
				$this->res[] = $reg;
			}
			return $this->res;
		}

	}

	public function aceptarTerminosDeUso($usuario)
	{

		$idUsuario = self::selectusuarios($usuario);
		$query = "update usuarios set terminosDeUso='si' where idusuario='" . $idUsuario[0]['idusuario'] . "'";
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
			return true;

	}

	public function updateMensajeLeido($usuario)
	{
		$idUsuario = self::selectusuarios($usuario);

		$query = "update usuarios set cuentaVencida='si' where idusuario='" . $idUsuario[0]['idusuario'] . "'";
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
			return true;

	}

	public function cuentaVencida($idUsuario)
	{

		$query = "select usuario
				from usuarios u
				where DATE_SUB(CURDATE(),INTERVAL 31 DAY) >= fecharegistro and idusuario='$idUsuario'";
		$result = $this->mySql->query($query);
		if ($result)
			return true;
		else
			return false;

	}

	public function mensajeLeido($idUsuario)
	{
		$res = self::returnUsuario($idUsuario);

		if ($res[0]['cuentaVencida'] == 'si')
			return true;
		else
			return false;
	}

	public function subirImgDeposito($image, $idUsuario)
	{

		$query = "update usuarios set depositoImg='$image' where idusuario='$idUsuario'";
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
			return true;

	}

	public function insertusuario($nom, $appat, $apmat, $ci, $expedidoen, $numcuenta, $dir, $user, $pass, $cel, $fij, $email, $rol, $addedby, $img)
	{
		$pass = md5($pass);

		$query = "insert into usuarios(nombre,appaterno,apmaterno,fecharegistro,horaregistro,ci,expedidoen,direccion,usuario,numcuenta,contrasenia,telefonocel,telefonofijo,email,rol,estado,addedby,depositoImg,terminosDeUso,revisado) 
							  values('$nom','$appat','$apmat',now(),now(),'$ci',$expedidoen,'$dir','$user','$numcuenta','$pass','$cel','$fij','$email','$rol','activo','$addedby','$img','si','no')";

		$result = $this->mySql->query($query);

		if (!$result)
			return false;
		else
			return true;

	}

	public function departamentos()
	{

		$query = "select * from departamentos";
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
		{
			while ($reg = $result->fetch_assoc())
			{
				$departamentos[] = $reg;
			}
			return $departamentos;
		}

	}

	public function insertAdmin($nom, $appat, $apmat, $ci, $expedidoen, $dir, $user, $numcuenta, $pass, $cel, $fij, $email)
	{
		$pass = md5($pass);

		$query = "insert into usuarios(nombre,appaterno,apmaterno,fecharegistro,horaregistro,ci,expedidoen,direccion,usuario,numcuenta,contrasenia,telefonocel,telefonofijo,email,rol,estado,addedby,depositoImg,terminosDeUso,revisado,revisadopor) 
							  values('$nom','$appat','$apmat',now(),now(),'$ci','$expedidoen','$dir','$user','$numcuenta','$pass','$cel','$fij','$email','admin','activo','1','','si','aceptado','1')";

		$result = $this->mySql->query($query);

		if (!$result)
			return false;
		else
			return true;

	}

	public function maxid()
	{

		$query = "select max(idusuario) as iduser from usuarios";
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

	public function returnUsuario($idusuario)
	{

		$query = "select * from usuarios where idusuario='$idusuario'";
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

	public function returnPadre($usuario)
	{

		$query = "select * from usuarios where usuario='$usuario'";
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
?>