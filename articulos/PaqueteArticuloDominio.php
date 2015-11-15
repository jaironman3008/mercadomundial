<?php
include_once('PaqueteArticulo.php');

class PaqueteArticuloDominio{
	
	private $paqueteArticulo;
	private $paqueteArticulo2;
	private $listaPaquetes;
	private $opcion;
	private $idPaquete;
	private $curUser;
	
	public function __construct($sw=''){
	
		$this->paqueteArticulo=new PaqueteArticulo();
		$this->paqueteArticulo2=new PaqueteArticulo();
		$this->paqueteArticulo3=new PaqueteArticulo();
		$listaPaquetes=array();
		$this->opcion=$sw;
		$this->idPaquete=isset($_POST['idPaqueteArticulo'])?$_POST['idPaqueteArticulo']:"";
		$this->curUser=isset($_POST['curUser'])?$_POST['curUser']:"";
	}
	public function verPaquetes(){
		return $this->paqueteArticulo->verPaquetes();
	}
	public function obtenerPaqueteArticulo(){
		$ud1=new PaqueteArticuloDominio();
		$ud2=new PaqueteArticuloDominio();
		$ud3=new PaqueteArticuloDominio();
		$lastPack=$this->paqueteArticulo->ultimoPaquete();
		
		if($lastPack[0]['idpaquetearticulo']==''){//SI LA TABLA PAQUETEARTICULO ESTA VACIA
			$id=1;									
			$ud1->crearPaqueteArticulo($id);
			return $id;			
		}
		elseif($lastPack[0]['estado']=='abierto'){//SI LA TABLA PAQUETEARTICULO YA TIENE REGISTROS ABIERTOS
			$id=$lastPack[0]['idpaquetearticulo']+1;
			$ud2->crearPaqueteArticulo($id);
			return $id;
		}
		else{//SI LA TABLA PAQUETEARTICULOS YA TIENE REGISTROS
			$id=$lastPack[0]['idpaquetearticulo'];
			$articulosEnPaquete=$this->paqueteArticulo2->contarArticulosEnPaquete($id);
			if(count($articulosEnPaquete)<10){//paquete con espacion				
				return $id;
			}
			else{//paquete lleno
				$id=$id+1;
				$ud3->crearPaqueteArticulo($id);				
				return $id;
			}
		}		
	}
	public function crearPaqueteArticulo($idPaqueteArticulo){		
		return $this->paqueteArticulo->crearPaqueteArticulo($idPaqueteArticulo);
	}
	public function insertDetallePaqueteArticulos($idPaqueteArticulo, $idArticulo){
		return $this->paqueteArticulo->insertDetallePaqueteArticulos($idPaqueteArticulo,$idArticulo);
	}
	public function abrirPaqueteArticulos(){
		$pad1=new PaqueteArticuloDominio();
		$pad2=new PaqueteArticuloDominio();
		$articulosEnPaquete=$pad1->getPaqueteFromId($this->idPaquete);
		$idResponsable=$pad2->getUsuarioFromUser($this->curUser);
		$asignado=0;
		if($this->paqueteArticulo2->abrirPaqueteArticulos($this->idPaquete,$idResponsable)==true){
			for($i=0;$i<count($articulosEnPaquete);$i++){			
				if($this->paqueteArticulo->enviarParaRevisar($idResponsable,$articulosEnPaquete[$i]['idarticulo'])==true){
					$asignado=$asigando+1;
				}
			}
		}
		echo "<script>
				//alert('$idResponsable ".count($articulosEnPaquete)."');
				$(document).ready(function(){						
				$.ajax({
					type: 'POST',
					url: 'articulos/VistaPaquetesArticulo.php',
					//data: 'pag=$pag&vista=$vista&tipo=recibidos',
					beforeSend: beforeSendImg(),
					success: function(data){
								$('#contenido').html(data);						
							}			
				 });
				 });
					  </script>";
		
	}
	public function distribuirPaqueteArticulos(){
		$pad1=new PaqueteArticuloDominio();
		$pad2=new PaqueteArticuloDominio();
		$idResponsable=$pad1->newAdminPack();
		$articulosEnPaquete=$pad2->getPaqueteFromId($this->idPaquete);
		
		if($this->paqueteArticulo->abrirPaqueteArticulos($this->idPaquete,$idResponsable)==true){
			for($i=0;$i<count($articulosEnPaquete);$i++){			
				if($this->paqueteArticulo->enviarParaRevisar($idResponsable,$articulosEnPaquete[$i]['idarticulo'])==true){
					$asignado=$asigando+1;
				}
			}
		}		
		echo "<script>
				//alert('$idResponsable ".count($articulosEnPaquete)."');
				$(document).ready(function(){						
				$.ajax({
					type: 'POST',
					url: 'articulos/VistaPaquetesArticulo.php',
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
		$pad1=new PaqueteArticuloDominio();
		$pad2=new PaqueteArticuloDominio();
		
		$curAdmin=$pad1->curAdminPack();//ultimo usuario que atendio un paquete
		$listAdminPack=$pad2->listAdminPack();//lista de usuarios Adminitradores
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
		$idAdmin=$this->paqueteArticulo->curAdminPack();
		$id=$idAdmin[0]['idresponsable'];
		return $id;
	}
	public function listAdminPack(){
		return $this->paqueteArticulo->listAdminPack();
	}
	public function getPaqueteFromId($idPaqueteArticulo){
		return $this->paqueteArticulo->getPaqueteFromId($idPaqueteArticulo);		
	}
	public function getUsuarioFromUser($user){
		$usuario=$this->paqueteArticulo->getUsuarioFromUser($user);
		$idUser=$usuario[0]['idusuario'];
		return $idUser;
	}
	public function main(){
		switch($this->opcion){
			case'abrirPaqueteArticulos':self::abrirPaqueteArticulos();break;
			case'distribuirPaqueteArticulos':self::distribuirPaqueteArticulos();break;			
		}
	}
}
$pad= new PaqueteArticuloDominio(isset($_POST['opcion'])?$_POST['opcion']:"");
$pad->main();