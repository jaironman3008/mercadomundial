<?php
include_once (MAINPATH . "/DominioManage.php");
include_once ('Usuario.php');

class UserControl extends DominioManage
{
	private $listaCobros;
	private $usuario;
	private $user;
	private $pass;
	private $passMd5;

	public function __construct()
	{
		$this->usuario = new Usuario();
		$this->user = $this->inputPost('usuario');
		$this->pass = $this->inputPost('password');
		$this->listaCobros = array();
		var_dump(get_class_vars(Usuario));exit;
	}

	public function logueo()
	{
		$usuarioyestado = $this->usuario->selectusuarios($this->user);
		$passycargo = $this->usuario->password($this->user, $this->pass);
		$result = Usuario::login($this->user, $this->pass);
		if (md5($usuarioyestado[0]['usuario']) == md5($this->user))
		{
			if ($usuarioyestado[0]['estado'] == 'inactivo')
			{
				//usuario inactivo
				echo "<script>alert('Error! Su cuenta de usuario ha sido dada de baja. Comuniquese con el Administrador.'); window.location.href=\"index.php\"</script>";
			}
			else
			{
				//usuario activo
				if (count($passycargo) == 1)
				{
					//usuario y contraseña correcto
					switch($usuarioyestado[0]['revisado'])
					{
						case'no' :
							echo "<script>						
									alert('Estimado usuario, su cuenta esta en proceso de revision.'); window.location.href='index.php'
								</script>";
							break;
						case'rechazado' :
							echo "<script>						
									alert('La solicitud de esta nueva cuenta ha sido rechazada. Comuniquese con su anfitrion.'); window.location.href='index.php'
								</script>";
							break;
						case'aceptado' :
							if ($usuarioyestado[0]['rol'] != 'usuario')
								// $this->conectar->insertbitacora('Inicio de sesion',$this->user,'');
								// session_start();
								// echo "<pre>";var_dump($_POST,$_SESSION);exit;
								$_SESSION["autentica"] = 'SIP';
							$_SESSION["usuarioactual"] = $usuarioyestado[0]['usuario'];
							$_SESSION["idusuarioactual"] = $usuarioyestado[0]['idusuario'];
							$_SESSION["rolusuario"] = $passycargo[0]['rol'];
							$_SESSION["ultimoacceso"] = date("Y-n-j H:i:s");
							echo "<script>	
									window.location.href = 'index.php';					
								</script>";
							break;
					}
				}
				else
				{
					echo "<script>						
						alert('La contrasenia del usuario no es correcta.'); window.location.href='index.php'
					</script>";
				}
			}
		}
		else
		{
			echo "<script>alert('El usuario no existe.');window.location.href=\"index.php\"</script>";
		}
	}

}
