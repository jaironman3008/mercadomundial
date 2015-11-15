<?php
@include_once('../DBManager.php');

class PaqueteUsuario{
	
	private $conectar;
	private $mysqli;
	
	public function __construct(){
		$this->conectar=new Conectar();
		$this->mysqli=$this->conectar->con();
	}
	public function verPaquetes(){
		
			$query="select pu.idpaqueteusuario, count(pu.idpaqueteusuario) as total, pu.fechacreacion, pu.horacreacion from paqueteusuarios pu, detallepaqueteusuarios dpu 
					where pu.idpaqueteusuario=dpu.idpaqueteusuario and
							estado='cerrado'
					group by pu.idpaqueteusuario order by pu.idpaqueteusuario desc";
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
		
	}
	public function crearPaqueteUsuario($idPaqueteUsuario){
		
			$query="insert into paqueteusuarios(idpaqueteusuario,fechacreacion,horacreacion,estado) 
							values('$idPaqueteUsuario',now(),now(),'cerrado')";
			$result = $this->mysqli->query($query);
			if(!$result)
				return false;
			else return true;
		
	}
	public function insertDetallePaqueteUsuarios($idPaqueteUsuario,$idUsuario){
		
			$query="insert into detallepaqueteusuarios(idpaqueteusuario,idusuario,fecharegistro,horaregistro) values('$idPaqueteUsuario','$idUsuario',now(),now())";
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else return true;
		
	}
	public function enviarParaRevisar($idUsuario,$userReview){		
		
			$query="update usuarios set revisadopor='$idUsuario' where idusuario='$userReview'";			
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else return true;
		
	}
	public function abrirPaqueteUsuarios($idPaqueteUsuario,$idUsuario){
			$query="update paqueteusuarios set estado='abierto', idresponsable='$idUsuario', horaapertura=now(), fechaapertura=now() where idpaqueteusuario='$idPaqueteUsuario'";			
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else return true;
		
	}
	public function curAdminPack(){
		
			$query="select idresponsable from paqueteusuarios where idresponsable!='1' group by idresponsable order by idresponsable desc limit 1";			
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
		
	}
	public function listAdminPack(){
		
			$query="select idusuario from usuarios where rol='admin' and estado='activo';";			
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
		
	}
	public function contarUsuarioEnPaquete($idPaqueteUsuario){
		
			$query="select idpaqueteusuario from detallepaqueteusuarios where idpaqueteusuario='$idPaqueteUsuario'";
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
		
	}
	public function maxIdPaquete(){	
   		   		
			$query = "select max(idpaqueteusuario) as idpackuser from paqueteusuarios";
			$result = $this->mysqli->query($query);
			if(!$result)
				return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
   		
	}
	public function ultimoPaquete(){	
   		   		
			$query = "select * from paqueteusuarios order by idpaqueteusuario desc limit 1";
			$result = $this->mysqli->query($query);
			if(!$result)
				return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
   		
	}
	public function getPaqueteFromId($idPaqueteUsuario){
		   		
			$query = "select * from detallepaqueteusuarios where idpaqueteusuario='$idPaqueteUsuario'";
			$result = $this->mysqli->query($query);
			if(!$result)
				return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
   		
	}
	public function getUsuarioFromUser($user){
		   		
			$query = "select * from usuarios where usuario='$user'";
			$result = $this->mysqli->query($query);
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