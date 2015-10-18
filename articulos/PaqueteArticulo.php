<?
@include_once('../DBManager.php');

class PaqueteArticulo{
	
	private $conectar;
	private $mysqli;
		
	public function __construct(){
		$this->conectar=new Conectar();
		$this->mysqli=$this->conectar->con();
	}
	public function verPaquetes(){
		
			$query="select pu.idpaquetearticulo, count(pu.idpaquetearticulo) as total, pu.fechacreacion, pu.horacreacion from paquetearticulos pu, detallepaquetearticulos dpu 
					where pu.idpaquetearticulo=dpu.idpaquetearticulo and
							estado='cerrado'
					group by pu.idpaquetearticulo order by pu.idpaquetearticulo desc";
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
		
	}
	public function crearPaqueteArticulo($idPaqueteArticulo){
		
			$query="insert into paquetearticulos(idpaquetearticulo,fechacreacion,horacreacion,estado) 
							values('$idPaqueteArticulo',now(),now(),'cerrado')";
			$result = $this->mysqli->query($query);
			if(!$result)
				return false;
			else return true;
		
	}
	public function insertDetallePaqueteArticulos($idPaqueteArticulo,$idArticulo){
		
			$query="insert into detallepaquetearticulos(idpaquetearticulo,idarticulo,fecharegistro,horaregistro) values('$idPaqueteArticulo','$idArticulo',now(),now())";
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else return true;
		
	}
	public function enviarParaRevisar($idUsuario,$idArticulo){		
		
			$query="update articulos set revisadopor='$idUsuario' where idarticulo='$idArticulo'";			
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else return true;
		
	}
	public function abrirPaqueteArticulos($idPaqueteArticulo,$idResponsable){
		
			$query="update paquetearticulos set estado='abierto', horaapertura=now(), fechaapertura=now(),idresponsable='$idResponsable' where idpaquetearticulo='$idPaqueteArticulo'";			
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else return true;
		
	}
	public function curAdminPack(){
		
			$query="select idresponsable from paquetearticulos where idresponsable!='1' group by idresponsable order by idresponsable desc limit 1";			
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
	public function contarArticulosEnPaquete($idPaqueteArticulo){
		
			$query="select idpaquetearticulo from detallepaquetearticulos where idpaquetearticulo='$idPaqueteArticulo'";
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
   		   		
			$query = "select max(idpaquetearticulo) as idpackart from paquetearticulos";
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
   		   		
			$query = "select * from paquetearticulos order by idpaquetearticulo desc limit 1";
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
	public function getPaqueteFromId($idPaqueteArticulo){
		   		
			$query = "select * from detallepaquetearticulos where idpaquetearticulo='$idPaqueteArticulo'";
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