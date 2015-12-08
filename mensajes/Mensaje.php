<?php
include_once(MAINPATH.'/DBManager.php');

class Mensaje extends DBManager{
	
	public function __construct(){
		parent::__construct();
	}

	public function insertMensaje($sendFrom,$sendTo,$asunto,$mensaje){		
		
					
			$query="insert into mensajes(idSendFrom,idSendTo,asunto,mensaje,fecha,hora,estado,tipo)
					values('".$sendFrom."','".$sendTo."','$asunto','$mensaje',now(),now(),'sin leer','mensaje')";
			$result = $this->mySql->query($query);
			if(!$result)
				return false;
			else 
				return true;
		
	}
	public function getConsultas(){
		
			$query="select * from mensajes where tipo='consulta' order by idmensaje desc";
			$result = $this->mySql->query($query);
			if(!$result)
				return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
		
	}
	public function getReceptor(){
		
			$query="select idusuario, usuario 
					from  usuarios
					where usuario!='jair' and rol='superadmin' or rol='admin' order by idusuario asc";
			$result = $this->mySql->query($query);
			if(!$result)
				return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
		
	}
	public function guardarNuevaConsulta($sendFrom,$consulta){		
			
			$message=new Mensaje();
			$message2=new Mensaje();
			$message3=new Mensaje();
			
			$listaReceptor=self::getReceptor();
			$listaConsulta=self::getConsultas();
			
			if(count($listaConsulta)>=1){
				$ultimoReceptor=$message3->getUsuarioFromId($listaConsulta[0]['idSendTo']);//sendTo ahora es un id y no texto para comprara con usuario,
				for($i=0;$i<count($listaConsulta);$i++){
					if($listaReceptor[$i]['usuario']==$ultimoReceptor[0]['usuario']){
						if($listaReceptor[($i+1)]['usuario']!='')
							$receptor=$listaReceptor[($i+1)]['usuario'];
						else 
							$receptor=$listaReceptor[0]['usuario'];
					}
						
					
				}
			}
			else $receptor=$listaReceptor[0]['usuario'];			
						
			$idSendFrom=$message->getUsuario($sendFrom);
			$idSendTo=$message2->getUsuario($receptor);
			
			$query="insert into mensajes(idSendFrom,idSendTo,asunto,mensaje,fecha,hora,estado,tipo)
					values('".$idSendFrom[0]['idusuario']."','".$idSendTo[0]['idusuario']."','CONSULTA','$consulta',now(),now(),'sin leer','consulta')";
			$result = $this->mySql->query($query);
			
			if(!$result)
				return false;
			else
				return true;
		
	}
	public function paginarMisMensajes($RegistrosAEmpezar, $RegistrosAMostrar,$usuario,$tipo){
		
		
			$idSendTo=self::getUsuario($usuario);
			if($tipo=='enviados')$direccion='idSendFrom';
			elseif($tipo=='recibidos') $direccion='idSendTo';
			$query="select idmensaje, idSendFrom, idSendTo, usuario, asunto, mensaje, fecha,hora, m.estado 
					from mensajes m, usuarios u	
					where 	m.idSendFrom=u.idusuario and deleted=0 and ".$direccion."='".$idSendTo[0]['idusuario']."'
							order by idmensaje desc limit $RegistrosAEmpezar, $RegistrosAMostrar";
			$result = $this->mySql->query($query);
			if(!$result)
				return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
		
	}
	public function selectMisMensajes($usuario,$tipo){
		
			if($tipo=='enviados')$direccion='idSendFrom';
			elseif($tipo=='recibidos') $direccion='idSendTo';
			$idSendTo=self::getUsuario($usuario);
			$query="select idmensaje, idSendFrom, usuario, asunto, mensaje, fecha, hora, m.estado
					from mensajes m, usuarios u	
					where 	m.idSendFrom=u.idusuario and deleted=0 and ".$direccion."='".$idSendTo[0]['idusuario']."'";
			$result = $this->mySql->query($query);
			if(!$result)
				return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
			
	}
	public function updateMensaje($idMensaje){
		
			//$message=new Mensaje();			
			//$idSendTo=$message->getUsuario($curUser);			
			$query="update mensajes set estado='leido' where idmensaje='$idMensaje'";
			$result = $this->mySql->query($query);
			if(!$result)
				return false;
			else 
				return true;
		
	}
	public function borrarMensaje($idMensaje){
		
			//$message=new Mensaje();			
			//$idSendTo=$message->getUsuario($curUser);			
			$query="update mensajes set deleted=1 where idmensaje='$idMensaje'";
			$result = $this->mySql->query($query);
			if(!$result)
				return false;
			else 
				return true;
		
	}
	public function selectMensaje($idMensaje){
							
			$query="select * from mensajes where idmensaje='$idMensaje'";
			$result = $this->mySql->query($query);
			if(!$result)
				return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}				
		
	}
	public function getUsuario($usuario){
		
			$query="select * from usuarios	where usuario='$usuario'";
			$result = $this->mySql->query($query);
			$resp=array();
			if(!$result)
				return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
		
	}
	public function getUsuarioFromId($idUsuario){
		
			$query="select * from usuarios	where idusuario='$idUsuario'";
			$result = $this->mySql->query($query);
			if(!$result)
				return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}				
				return $resp;
			}
		}
	
}