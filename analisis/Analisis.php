<?
include_once("../DBManager.php");

class Analisis{
		
	private $ventamen;
	private $mainvector;
	private $analisisproduct;
	private $conectar;
	private $mysqli;
	
	public function __construct(){
		$this->ventamen='';		
		$this->mainvector=array();
		$this->analisisproduct=array();
		$this->conectar=new Conectar();
		$this->mysqli=$this->conectar->con();

	}
	
	public function anios($sw){
		
			switch($sw){
				case'incrementoUsuarios':
					$query="select  DATE_FORMAT(fecharegistro,'%Y')  as anio from usuarios group by anio";
					break;
				case'incrementoVentas':
					$query="select  DATE_FORMAT(fechaventa,'%Y')  as anio from articulos where DATE_FORMAT(fechaventa,'%Y')!='0000' group by anio";
					break;
				case'incrementoVentasBs':
					$query="select  DATE_FORMAT(fechaventa,'%Y')  as anio from articulos where DATE_FORMAT(fechaventa,'%Y')!='0000' group by anio";
					break;				
			}
			
			$result = $this->mysqli->query($query);
			if(!$result)
				return false;
			else{
				while ($reg = $result->fetch_assoc()) {
					$this->mainvector[]=$reg;				
				}
				return $this->mainvector;
			}
		
	}
	public function incrementoDeUsuarios($anio,$i){
		$mes1=$i+1;
		$mes2=$i+2;
					
			$query="select count(idusuario) as totalmes from usuarios
			where fecharegistro>='$anio/$mes1/01' and fecharegistro<'$anio/$mes2/01'";
			$result = $this->mysqli->query($query);	
			
			if(!$result)
				return false;
			else{
				$this->ventamen=$result->data_seek(0);
				return $this->ventamen;
			}				
		
	}
	public function incrementoDeVentas($anio,$i){
		$mes1=$i+1;
		$mes2=$i+2;
					
			$query="select count(idarticulo) as totalmes from articulos
			where fechaventa>='$anio/$mes1/01' and fechaventa<'$anio/$mes2/01'";
			$result = $this->mysqli->query($query);	
			
			if(!$result)
				return false;
			else{
				$this->ventamen=$result->data_seek(0);
				return $this->ventamen;
			}				
		
	}
	public function incrementoDeVentasBs($anio,$i){
		
			$mes1=$i+1;
			$mes2=$i+2;
			$query="select sum(precio) as totalmes from articulos
			where fechaventa>='$anio/$mes1/01' and fechaventa<'$anio/$mes2/01'";
			$result = $this->mysqli->query($query);
			
			if(!$result)
				return false;
			else{
				$this->ventamen=$result->data_seek(0);		
				return $this->ventamen;
			}				
		}
		
}