<?php 
@include_once('../DBManager.php');

class classUsuario 
{	
	private $conectar;
	private $mysqli;
	
	public function __construct(){				

		$this->conectar=new Conectar();
		$this->mysqli=$this->conectar->con();
		
	}
	public function paginarusuarios($RegistrosAEmpezar,$RegistrosAMostrar,$usuario){
		
		if($usuario=='')
		$query="select * from usuarios order by appaterno limit $RegistrosAEmpezar, $RegistrosAMostrar";
		else
		$query="select * from usuarios where usuario like '$usuario%' order by appaterno limit $RegistrosAEmpezar, $RegistrosAMostrar";
		$result = $this->mysqli->query($query);
   		if(!$result){
   			return false;
   		} 
		else{
		   while ($reg = $result->fetch_assoc()) {
		   		$resp[]=$reg;		     
		   }
		   return $resp;
		}				
		
	}

	public function selectusuarios($dato){
		
   		if($dato=='')
			$query = "select * from usuarios";
		else
			$query = "select * from usuarios where usuario='$dato'";
		
		$result = $this->mysqli->query($query);
   		if(!$result){
   			return false;
   		} 
		else{
		   while ($reg = $result->fetch_assoc()) {
		   		$resp[]=$reg;		     
		   }
		   return $resp;
		}
		
	}
	public function selectCi($dato){
				
			$query = "select * from usuarios where ci='$dato'";
			$result = $this->mysqli->query($query);		
			if(!$result)
				return false;				
			else{						
				while ($reg = $result->fetch_assoc()) {						
					$listaCi[]=$reg;					
				}
				return $listaCi;
			}			
   		
	}	
	public function paginarMisInvitados($RegistrosAEmpezar,$RegistrosAMostrar,$usuario){
		list($usuario,$check)=split('[/.-]',$usuario);
		if($check=='revisar'){
			$check="revisadopor";
			$and="and revisado='no'";
		}
		else{
			$check="addedby";						
		}
		
		$misInvitados=self::returnPadre($usuario);
		if($usuario=='')
		$query="select * from usuarios order by appaterno limit $RegistrosAEmpezar, $RegistrosAMostrar";
		else
		$query="select * from usuarios where $check='".$misInvitados[0]['idusuario']."' ".$and." order by appaterno limit $RegistrosAEmpezar, $RegistrosAMostrar";
		$result = $this->mysqli->query($query);
   		if(!$result){
   			return false;
   		} 
		else{
		   while ($reg = $result->fetch_assoc()) {
		   		$resp[]=$reg;		     
		   }
		   return $resp;
		}				
		
	}
	public function selectMisInvitados($dato){

		list($dato,$check)=split('[/.-]',$dato);
		if($check=='revisar'){
			$check="revisadopor";
			$and="and revisado='no'";
		}
		else
			$check="addedby";
		
		$misInvitados=self::returnPadre($dato);
		if($dato=='')
		$query = "select * from usuarios";
		else
		$query = "select * from usuarios where $check='".$misInvitados[0]['idusuario']."'".$and;
		$result = $this->mysqli->query($query);
   		if(!$result){
   			return false;
   		} 
		else{
		   while ($reg = $result->fetch_assoc()) {
		   		$resp[]=$reg;		     
		   }
		   return $resp;
		}			
	}	
	
	public function password($dato, $pass){
		   		
		$query = "select * from usuarios where usuario='$dato' and contrasenia='$pass'";
		$result = $this->mysqli->query($query);
   		if(!$result){
   			return false;
   		} 
		else{
		   while ($reg = $result->fetch_assoc()) {
		   		$resp[]=$reg;		     
		   }
		   return $resp;
		}			
   		
	}
	public function buscarusuario($dato){
					
		$query = "select idusuario,nombre,appaterno,apmaterno,fecharegistro,horaregistro,ci,direccion,usuario,telefonocel,telefonofijo,rol,estado from usuarios where usuario like '$dato%'";			
		$result = $this->mysqli->query($query);
   		if(!$result){
   			return false;
   		} 
		else{
		   while ($reg = $result->fetch_assoc()) {
		   		$resp[]=$reg;		     
		   }
		   return $resp;
		}			
   		
	}
	public function updateusuario($nombres,$appaterno,$apmaterno,$ci,$expedidoen,$pass,$direccion,$telefonocel,$telefonofijo,$email,$idusuario,$img,$rol,$estado){
	
		
			if($pass!='')$pass=", contrasenia='".md5($pass)."'";
				
			else $pass="";
			
			$query="update usuarios set nombre='$nombres', appaterno='$appaterno', apmaterno='$apmaterno', ci='$ci',expedidoen='$expedidoen', rol='$rol', estado='$estado' $pass, direccion='$direccion', telefonocel='$telefonocel', telefonofijo='$telefonofijo',email='$email', depositoImg='$img' where idusuario='$idusuario'";
			$result = $this->mysqli->query($query);
			if(!$result)
				return false;
			else
				return true;
		
	}
	public function respuestaRevisarUsuario($respuestaRevision,$idUsuarioRevisado){
		
		$query="update usuarios set revisado='$respuestaRevision' where idusuario='$idUsuarioRevisado'";
		$result = $this->mysqli->query($query);			
		if($result)return true;
		else return false;
		
	}
	public function desactivarUsuario($idUsuario){
				
		$usuario1=new classUsuario();
		$usuario2=new classUsuario();
	
		$hijos=array();
		$usuario=$usuario1->returnUsuario($idUsuario);
		
		$padre=$usuario[0]['addedby'];//selecciono al padre del usuario
		$curUser=$usuario[0]['usuario'];//selecciono al usuario actual
		$hijos=self::selectMisInvitados($curUser);//selecciono los hijos del usuario
		$modifi=0;
		for($i=0;$i<count($hijos);$i++){
			$query="update usuarios set addedby='$padre' where idusuario='".$hijos[$i]['idusuario']."'";
			$result = $this->mysqli->query($query);
			if($result)$modifi=$modifi+1;
		}
		
		if(count($hijos)==$modifi){
			$beneficiado=$usuario2->returnUsuario($padre);
			return "Los $modifi invitados del usuario <b>".$usuario[0]['usuario']."</b> fueron pasados al usuario <b>".$beneficiado[0]['usuario']."</b>";
		}
		else{
			return "Comuniquese con el administrador del Sistema... $modifi de ".count($hijos)." invitados del usuario <b>".$usuario[0]['usuario']."</b> fueron pasados al usuario <b>".$beneficiado[0]['usuario']."</b>";
		}
		
	}
	public function desactivarArticulos($idUsuario){
		
		$modifi=0;
		$vendido=0;
		$articulos=self::getCountMisArticulos($idUsuario);

		for($i=0;$i<count($articulos);$i++){
			if($articulo[$i]['estado']!='vendido'){
				$query="update articulos set estado='inactivo' where idarticulo='".$articulo[$i]['idarticulo']."'";
				$result = $this->mysqli->query($query);
				if($result)$modifi=$modifi+1;
			}
			else $vendido=$vendido+1;
		}
		if($vendido==0){
			if($modifi==count($articulos))
			return "Los $modifi articulos de este usuario fueron desactivados, ya no apareceran en las categorias";
			else return "Comuniquese con el administrador...$modifi de ".count($articulos)." fueron desactivados, ya no apareceran en las categorias";
		}
		else return "A este usuario le quedaban ".($vendido-(count($articulos)))." articulos sin vender que acaban de ser desactivados, ya no apareceran en las categorias";
		
	}

	public function getCountMisArticulos($vista=''){
										
		switch($vista){
			case 'ofertas' : $filtro="and oferta > 0";break;
			case 'subastas' : $filtro="and subasta > 0";break;
			case 'recienPublicados' : $filtro="and DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= a.fechareg;";break;
			case $vista : $filtro="and idusuario='$vista'";break;
			default: $filtro="and categoria='$vista'";
		}			
		$query="select idarticulo, descripcion, categoria,precio, oferta, img,idusuario, estado, a.fechareg, a.horareg, subasta
				from articulos a, categoriaarticulos c
				where a.idcategoria=c.idcategoria and idusuario='$vista'";
		$result=$this->mysqli->query($query);
		if(!$result)
			return false;
		else{
			while ($reg = $result->fetch_assoc()) {
				$this->res[]=$reg;
			}
			return $this->res;
		}
		
	}
	public function aceptarTerminosDeUso($usuario){
					
		$idUsuario=self::selectusuarios($usuario);
		$query="update usuarios set terminosDeUso='si' where idusuario='".$idUsuario[0]['idusuario']."'";			
		$result=$this->mysqli->query($query);
		if(!$result)
			return false;
		else
			return true;
		
	}
	public function updateMensajeLeido($usuario){
		$idUsuario=self::selectusuarios($usuario);
		
			$query="update usuarios set cuentaVencida='si' where idusuario='".$idUsuario[0]['idusuario']."'";
			$result=$this->mysqli->query($query);
			if(!$result)return false;
			else return true;
		
	}
	public function cuentaVencida($idUsuario){
		
		$query="select usuario
				from usuarios u
				where DATE_SUB(CURDATE(),INTERVAL 31 DAY) >= fecharegistro and idusuario='$idUsuario'";
		$result=$this->mysqli->query($query);		
		if($result)return true;
		else return false;
	
	}
	public function mensajeLeido($idUsuario){
		$res=self::returnUsuario($idUsuario);
		
		if($res[0]['cuentaVencida']=='si')
			return true;
		else return false;
	}
	public function subirImgDeposito($image,$idUsuario){
					
		$query="update usuarios set depositoImg='$image' where idusuario='$idUsuario'";			
		$result=$this->mysqli->query($query);
		if(!$result)
			return false;
		else
			return true;
		
	}
	public function insertusuario($nom,$appat,$apmat,$ci,$expedidoen,$numcuenta,$dir,$user,$pass,$cel,$fij,$email,$rol,$addedby,$img){	
		$pass=md5($pass);		
		
		$query="insert into usuarios(nombre,appaterno,apmaterno,fecharegistro,horaregistro,ci,expedidoen,direccion,usuario,numcuenta,contrasenia,telefonocel,telefonofijo,email,rol,estado,addedby,depositoImg,terminosDeUso,revisado) 
							  values('$nom','$appat','$apmat',now(),now(),'$ci',$expedidoen,'$dir','$user','$numcuenta','$pass','$cel','$fij','$email','$rol','activo','$addedby','$img','si','no')";
		
		$result=$this->mysqli->query($query);
		
		if(!$result)
			return false;
		else
			return true;
		
	}
	public function departamentos(){
		
		$query="select * from departamentos";
		$result=$this->mysqli->query($query);
		if(!$result)return false;
		else{
			while ($reg = $result->fetch_assoc()) {
				$departamentos[]=$reg;
			}
			return $departamentos;
		}
		
	}
	public function insertAdmin($nom,$appat,$apmat,$ci,$expedidoen,$dir,$user,$numcuenta,$pass,$cel,$fij,$email){	
		$pass=md5($pass);
				
		$query="insert into usuarios(nombre,appaterno,apmaterno,fecharegistro,horaregistro,ci,expedidoen,direccion,usuario,numcuenta,contrasenia,telefonocel,telefonofijo,email,rol,estado,addedby,depositoImg,terminosDeUso,revisado,revisadopor) 
							  values('$nom','$appat','$apmat',now(),now(),'$ci','$expedidoen','$dir','$user','$numcuenta','$pass','$cel','$fij','$email','admin','activo','1','','si','aceptado','1')";
		
		$result=$this->mysqli->query($query);
		
		if(!$result)
			return false;
		else
			return true;
		
	}
	public function maxid(){	
   		   		
		$query = "select max(idusuario) as iduser from usuarios";
		$result=$this->mysqli->query($query);			
		if(!$result)
			return false;				
		else{						
			while ($reg = $result->fetch_assoc()) {
					
				$resp[]=$reg;
				
			}
			return $resp;
		}			
   		
	}
	public function returnUsuario($idusuario){
		
		$query="select * from usuarios where idusuario='$idusuario'";
		$result=$this->mysqli->query($query);
		if(!$result)return false;
		else{
			while ($reg = $result->fetch_assoc()) {
				$resp[]=$reg;
			}
			return $resp;
		}
		
	}
	public function returnPadre($usuario){
		
		$query="select * from usuarios where usuario='$usuario'";
		$result=$this->mysqli->query($query);
		if(!$result)return false;
		else{
			while ($reg = $result->fetch_assoc()) {
				$resp[]=$reg;
			}
			return $resp;
		}
		
	}
}
?>