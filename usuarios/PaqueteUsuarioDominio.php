<?
include_once('PaqueteUsuario.php');

class PaqueteUsuarioDominio{
	
	private $paqueteUsuario;
	private $paqueteUsuario2;
	private $listaPaquetes;
	private $opcion;
	private $idPaquete;
	private $curUser;
	
	public function __construct($sw=''){
	
		$this->paqueteUsuario=new PaqueteUsuario();
		$this->paqueteUsuario2=new PaqueteUsuario();
		$this->paqueteUsuario3=new PaqueteUsuario();
		$listaPaquetes=array();
		$this->curUser=$_POST['curUser'];
		$this->opcion=$sw;
		$this->idPaquete=$_POST['idPaqueteUsuario'];
		$this->curUser=$_POST['curUser'];
	}
	public function verPaquetes(){
		return $this->paqueteUsuario->verPaquetes();
	}
	public function obtenerPaqueteUsuario(){
		$ud1=new PaqueteUsuarioDominio();
		$ud2=new PaqueteUsuarioDominio();
		$ud3=new PaqueteUsuarioDominio();
		$lastPack=$this->paqueteUsuario->ultimoPaquete();
		//$idPaqueteUsuario=false;
		if($lastPack[0]['idpaqueteusuario']==''){//SI LA TABLA PAQUETEUSUARIOS ESTA VACIA
			$id=1;									
			$ud1->crearPaqueteUsuario($id);
			return $id;			
		}
		elseif($lastPack[0]['estado']=='abierto'){//SI LA TABLA PAQUETEUSUARIOS YA TIENE REGISTROS ABIERTOS
			$id=$lastPack[0]['idpaqueteusuario']+1;
			$ud2->crearPaqueteUsuario($id);
			return $id;
		}
		else{//SI LA TABLA PAQUETEUSUARIOS YA TIENE REGISTROS
			$id=$lastPack[0]['idpaqueteusuario'];
			$usuariosEnPaquete=$this->paqueteUsuario2->contarUsuarioEnPaquete($id);
			if(count($usuariosEnPaquete)<10){//paquete con espacion				
				return $id;
			}
			else{//paquete lleno
				$id=$id+1;
				$ud3->crearPaqueteUsuario($id);				
				return $id;
			}
		}
		//if($idPaqueteUsuario[0]['idpackuser']=='')return 0;
		//else return 1;
	}
	public function ultimoPaquete(){
		return $this->paqueteUsuario->ultimoPaquete();
	}
	public function crearPaqueteUsuario($idPaqueteUsuario){		
		return $this->paqueteUsuario->crearPaqueteUsuario($idPaqueteUsuario);
	}
	public function insertDetallePaqueteUsuarios($idPaqueteUsuario, $idUsuario){
		return $this->paqueteUsuario->insertDetallePaqueteUsuarios($idPaqueteUsuario,$idUsuario);
	}
	public function abrirPaqueteUsuarios(){
		$pud1=new PaqueteUsuarioDominio();
		$pud2=new PaqueteUsuarioDominio();
		$usuariosEnPaquete=$pud1->getPaqueteFromId($this->idPaquete);
		$idResponsable=$pud2->getUsuarioFromUser($this->curUser);
		$asignado=0;
		//var_dump($this->idPaquete,$idResponsable);exit;
		if($this->paqueteUsuario2->abrirPaqueteUsuarios($this->idPaquete,$idResponsable)==true){
			for($i=0;$i<count($usuariosEnPaquete);$i++){			
				if($this->paqueteUsuario->enviarParaRevisar($idResponsable,$usuariosEnPaquete[$i]['idusuario'])==true){
					$asignado=$asigando+1;
				}
			}
		}
		echo "<script>
				alert('$idResponsable ".count($usuariosEnPaquete)."');
				$(document).ready(function(){						
				$.ajax({
					type: 'POST',
					url: 'usuarios/VistaPaquetesUsuario.php',
					//data: 'pag=$pag&vista=$vista&tipo=recibidos',
					beforeSend: beforeSendImg(),
					success: function(data){
								$('#contenido').html(data);						
							}			
				 });
				 });
					  </script>";
		
	}
	public function distribuirPaqueteUsuarios(){
		$pud1=new PaqueteUsuarioDominio();
		$pud2=new PaqueteUsuarioDominio();
		$idResponsable=$pud1->newAdminPack();
		$usuariosEnPaquete=$pud2->getPaqueteFromId($this->idPaquete);
		var_dump($this->idPaquete,$idResponsable);exit;
		if($this->paqueteUsuario->abrirPaqueteUsuarios($this->idPaquete,$idResponsable)==true){
			for($i=0;$i<count($usuariosEnPaquete);$i++){			
				if($this->paqueteUsuario->enviarParaRevisar($idResponsable,$usuariosEnPaquete[$i]['idusuario'])==true){
					$asignado=$asigando+1;
				}
			}
		}		
		echo "<script>
				//alert('$idResponsable ".count($usuariosEnPaquete)."');
				$(document).ready(function(){						
				$.ajax({
					type: 'POST',
					url: 'usuarios/VistaPaquetesUsuario.php',
					//data: 'pag=$pag&vista=$vista&tipo=recibidos',
					beforeSend: beforeSendImg(),
					success: function(data){
								$('#contenido').html(data);						
							}			
				 });
				 });
					  </script>";		
	}
	public function newAdminPack(){
		$pud1=new PaqueteUsuarioDominio();
		$pud2=new PaqueteUsuarioDominio();
		
		$curAdmin=$pud1->curADminPack();//ultimo usuario que atendio un paquete
		$listAdminPack=$pud2->listAdminPack();//lista de usuarios Adminitradores
		if($curAdmin=='' || $curAdmin==0){//si no se ha asignado un paquete a un administrador
			$id=$listAdminPack[0]['idusuario'];
			return $id;
		}
		else{
			for($i=0;$i<count($listAdminPack);$i++){
				if($listAdminPack[$i]['idusuario']==$curAdmin){//si se identifica al usuario en la lista de administr
					if($listAdminPack[($i+1)]['idusuario']!=''){//si no ha llegado al final de la lista
						$id=$listAdminPack[($i+1)]['idusuario'];
						return $id;
					}
					else{
						$id=$listAdminPack[0]['idusuario'];
						return $id;
					}
				}
			}
		}
	}
	public function curAdminPack(){
		$idAdmin=$this->paqueteUsuario->curAdminPack();
		$id=$idAdmin[0]['idresponsable'];
		return $id;
	}
	public function listAdminPack(){
		return $this->paqueteUsuario->listAdminPack();
	}
	public function getPaqueteFromId($idPaqueteUsuario){
		return $this->paqueteUsuario->getPaqueteFromId($idPaqueteUsuario);		
	}
	public function getUsuarioFromUser($user){
		$usuario=$this->paqueteUsuario->getUsuarioFromUser($user);
		$idUser=$usuario[0]['idusuario'];
		return $idUser;
	}
	public function main(){
		switch($this->opcion){
			case'abrirPaqueteUsuarios':self::abrirPaqueteUsuarios();break;
			case'distribuirPaqueteUsuarios':self::distribuirPaqueteUsuarios();break;			
		}
	}
}
$pud= new PaqueteUsuarioDominio($_POST['opcion']);
$pud->main();