<?php
// session_start();
@include_once('../DBManager.php');

class Articulo{
	
	private $conectar;
	private $mysqli;
	
	public function __construct(){
	
		$this->conectar= new Conectar();
		$this->mysqli=$this->conectar->con();
		
	}
	public function incrementarVisitaDeArticulo($categoria){		
		
		$query="
			update categoriaarticulos set visit=visit+1 where categoria='$categoria'";
		$result = $this->mysqli->query($query);
		if(!$result)
			return false;
		else return true;
		
	}
	public function insertArticulo($descripcion,$categoria,$precio,$img,$usuario,$estado,$ubicacion,$moneda){
		$idUsuario=self::getId($usuario);
		$idCategoria=self::getCategoria($categoria);
		
			$query="insert into articulos(descripcion, idcategoria,precio,oferta,img,idusuario,estado,subasta,fechareg,horareg,revisado,ubicacion,moneda)
					values('$descripcion','".$idCategoria[0]['idcategoria']."','$precio','0','$img','".$idUsuario[0]['idusuario']."','$estado','0',now(),now(),'no','$ubicacion','$moneda')";
			$result = $this->mysqli->query($query);
			if(!$result)
				return false;
			else return true;
		
	}
	public function getCategoriaArticulos(){
	
		
			$query="select * from categoriaarticulos order by categoria asc";
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
	public function categoriasMasVisitadas(){
	
		
			$query="select * from categoriaarticulos order by visit desc limit 3";
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
	public function departamentos(){
		
			$query="select * from departamentos";
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$departamentos[]=$reg;
				}
				return $departamentos;
			}
		
	}
	public function getMonedas(){
		
			$query="select * from monedas";
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
		
	}
	public function getArticulos($registrosAEmpezar='',$registrosAMostrar='', $vista=''){
	
		$resp=array();		
		switch($vista){
			case 'ofertas' : $filtro="and oferta > 0";break;
			case 'subastas' : $filtro="and subasta > 0";break;
			case 'recienPublicados' : $filtro="and DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= a.fechareg";break;				
			default: $filtro="and categoria='$vista'";
		}
		$query="select idarticulo, descripcion, categoria, precio, oferta, img, idusuario, estado, a.fechareg, a.horareg, subasta 
				from articulos a, categoriaarticulos c
				where a.idcategoria=c.idcategoria and estado!='vendido' and estado!='inactivo' and revisado='aceptado' $filtro limit $registrosAEmpezar, $registrosAMostrar";
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
	public function getCountArticulos($vista=''){
	
			$resp=array();			
			switch($vista){
				case 'ofertas' : $filtro="and oferta > 0";break;
				case 'subastas' : $filtro="and subasta > 0";break;
				case 'recienPublicados' : $filtro="and DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= a.fechareg";break;				
				default: $filtro="and categoria='$vista'";
			}			
			$query="select idarticulo, descripcion, categoria,precio, oferta, img,idusuario, estado, a.fechareg, a.horareg, subasta
					from articulos a, categoriaarticulos c
					where a.idcategoria=c.idcategoria and estado!='vendido' and estado!='inactivo' and revisado='aceptado' $filtro";
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
	public function getMisArticulos($registrosAEmpezar='',$registrosAMostrar='', $vista=''){
		list($vista,$check)=split('/',$vista);
		if($check=='revisar'){
			$check="a.revisadopor";
			$and="and a.revisado='no' ";
		}
		else{
			$check="a.idusuario";
		}
		
			switch($vista){
				case 'ofertas' : $filtro="and oferta > 0";break;
				case 'subastas' : $filtro="and subasta > 0";break;
				case 'recienPublicados' : $filtro="and DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= a.fechareg;";break;
				case $vista : $filtro="and a.idusuario='$vista'";break;				
				default: $filtro="and categoria='$vista'";
			}
			
			$query="select idarticulo, descripcion, categoria,precio, oferta, img, a.idusuario, a.estado,u.usuario, a.fechareg, a.horareg, subasta 
					from articulos a, categoriaarticulos c, usuarios u
					where a.idcategoria=c.idcategoria and					 
					$check='$vista' and u.idusuario=a.idusuario ".$and." limit $registrosAEmpezar, $registrosAMostrar";
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
	
	public function getCountMisArticulos($vista=''){//same function in classUsuario
	
	// if(is_numeric($vista)){
// 		
	// }
// 	
	var_dump($vista);
	list($vista,$check)=split('[/.-]',$vista);
		if($check=='revisar'){
			$check="a.revisadopor";
			$and="and a.revisado='no' ";
		}
		else{
			$check="a.idusuario";
		}
										
			switch($vista){
				case 'ofertas' : $filtro="and oferta > 0";break;
				case 'subastas' : $filtro="and subasta > 0";break;
				case 'recienPublicados' : $filtro="and DATE_SUB(CURDATE(),INTERVAL 7 DAY) <= a.fechareg;";break;
				case $vista : $filtro="and a.idusuario='$vista'";break;
				default: $filtro="and categoria='$vista'";
			}		
			
			$query="select idarticulo, descripcion, categoria,precio, oferta, img, a.idusuario, a.estado, a.fechareg, a.horareg, subasta, a.revisado
					from articulos a, categoriaarticulos c, usuarios u
					where a.idcategoria=c.idcategoria and					
					$check='$vista' and u.idusuario=a.idusuario ".$and;
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
	public function getUsuario($id){
			$resp=array();
			$query="select * from usuarios
					where idusuario='$id'";
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
	public function respuestaRevisarArticulo($respuestaRevision,$idArticuloRevisado){
		
			$query="update articulos set revisado='$respuestaRevision' where idarticulo='$idArticuloRevisado'";
			$result = $this->mysqli->query($query);			
			if($result)return true;
			else return false;
		
	}
	public function getId($usuario){
		
			$query="select * from usuarios	where usuario='$usuario'";
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
	public function getCategoria($categoria){
		
			$query="select * from categoriaarticulos where categoria='$categoria'";
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
	public function getArticuloFromId($idarticulo){
		
			$query="select idarticulo, descripcion, categoria,precio, oferta, img, idusuario, estado, a.fechareg, a.horareg, subasta, revisado, revisadopor 
					from articulos a, categoriaarticulos c
					where a.idcategoria=c.idcategoria and idarticulo='$idarticulo'";
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
	public function getMaxIdArticulo(){
		
			$query="select max(idarticulo) as idart from articulos";
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$resp[]=$reg;
				}
				return $resp;
			}
		
		
	}
	public function actualizarArticulo($descripcion,$precio,$oferta,$img,$estado,$subasta,$idArticulo,$fechaVenta,$horaVenta){
		
			$query="update articulos set descripcion='$descripcion', precio='$precio',oferta='$oferta',img='$img',estado='$estado',subasta='$subasta',fechaventa='$fechaVenta',horaventa='$horaVenta' where idarticulo='$idArticulo'";
			$result = $this->mysqli->query($query);
			if(!$result)return false;
			else return true;
		}
	
}