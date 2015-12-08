<?php
include_once(MAINPATH.'/DBManager.php');
class Notificacion extends  DBManager{

	private $misclientes;
	
	public function __construct(){
		$this->misclientes=array();
	}
	public function misclientes($usuario,$from){
		if($this->mySql==true){
			$swuser="and usuario='$usuario'";
			if($usuario=='')$swuser='';
			switch($from){
				case 'todos':	$query="select c.idcliente,c.nombre,c.appaterno,c.apmaterno, c.ci,c.telefonocel, count(idventa) as nventas,u.nombre as nameuser,u.appaterno as appuser,u.apmaterno as apmuser
										from clientes c, ventas v, usuarios u
										where c.idcliente=v.idcliente and
										v.idusuario=u.idusuario $swuser group by c.nombre";break;
				case 'casimora':	$query="select c.idcliente, c.nombre,c.appaterno,c.apmaterno,c.ci,c.telefonocel,u.nombre as nameuser,u.appaterno as appuser,u.apmaterno as apmuser
											from cobros co, clientes c,ventas v, usuarios u
											where co.idventa=v.idventa and
											v.idcliente=c.idcliente and
											v.idusuario=u.idusuario  $swuser and									
											co.interesmora<=0 and
											co.estado='pendiente' and
											v.estado!='en proceso' and
											co.fechavcto<= curdate() group by idcliente";break;
				case 'enmora': $query="select c.idcliente, c.nombre,c.appaterno,c.apmaterno,c.ci,c.telefonocel,u.nombre as nameuser,u.appaterno as appuser,u.apmaterno as apmuser
										from cobros co, clientes c,ventas v, usuarios u
										where co.idventa=v.idventa and
										v.idcliente=c.idcliente and
										v.idusuario=u.idusuario  $swuser and
										co.interesmora>0 and
										co.estado='pendiente' and
										v.estado!='en proceso'";break;
				case 'enproceso':	$query="select c.idcliente, c.nombre,c.appaterno,c.apmaterno,c.ci,c.telefonocel,u.nombre as nameuser,u.appaterno as appuser,u.apmaterno as apmuser
											from cobros co, clientes c,ventas v, usuarios u
											where co.idventa=v.idventa and
											v.idcliente=c.idcliente and
											v.idusuario=u.idusuario  $swuser and
											co.interesmora>0 and
											co.estado='pendiente' and
											v.estado ='en proceso'";break;
				case 'revertido':	$query="select c.idcliente,c.nombre, c.appaterno, c.apmaterno,c.ci,c.telefonocel,u.nombre as nameuser,u.appaterno as appuser,u.apmaterno as apmuser
											from clientes c, ventas v, usuarios u
											where c.idcliente=v.idcliente and
											v.estado='revertido' and
											v.idusuario=u.idusuario  $swuser";break;
				case 'porcobrar':	$query="select c.idcliente, c.nombre,c.appaterno,c.apmaterno,c.ci,c.telefonocel,u.nombre as nameuser,u.appaterno as appuser,u.apmaterno as apmuser
											from cobros co, clientes c,ventas v, usuarios u
											where co.idventa=v.idventa and
											v.idcliente=c.idcliente and
											v.idusuario=u.idusuario  $swuser and									
											co.interesmora<=0 and
											co.estado='pendiente' and
											v.estado!='en proceso' and
											co.fechavcto<= curdate() group by idcliente
											union
											select c.idcliente, c.nombre,c.appaterno,c.apmaterno,c.ci,c.telefonocel,u.nombre as nameuser,u.appaterno as appuser,u.apmaterno as apmuser
											from cobros co, clientes c,ventas v, usuarios u
											where co.idventa=v.idventa and
											v.idcliente=c.idcliente and
											v.idusuario=u.idusuario  $swuser and
											co.interesmora>0 and
											co.estado='pendiente' and
											v.estado!='en proceso'";
			}
			
			$result=$this->mySql->query($query);
			if(!$result)
				return false;
			else{
				while($reg = $result->fetch_assoc()){
					$this->misclientes[]=$reg;
				}
				return $this->misclientes;
			}			
		}
	}
}