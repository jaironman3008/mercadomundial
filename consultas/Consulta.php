<?
include_once('../DBManager.php');
class Consulta{
	
	private $conectar;
	private $lista;	
	private $listaConsultas;
	private $listaConsultas1;
	private $listaConsultas2;
	
	public function __construct(){
		$this->conectar= new Conectar();
		$this->lista= array();
		$this->listaConsultas=array();
		$this->listaConsultas1=array();
		$this->listaConsultas2=array();
	}
	
	public function paginarConsultas($RegistrosAEmpezar, $RegistrosAMostrar,$usuario){
		if($this->conectar->con()==true){
			
			$query="select * 
					from consultas 
					where sendTo='$usuario' order by idconsulta desc limit $RegistrosAEmpezar, $RegistrosAMostrar";
			$result=mysql_query($query);
			if(!$result)
				return false;
			else{
				while($reg=mysql_fetch_assoc($result)){
					$this->listaConsultas1[]=$reg;
				}
				return $this->listaConsultas1;
			}
		}
	}
	
	public function selectConsultas($usuario){
		if($this->conectar->con()==true){
			
			$query="select * 
					from consultas 
					where sendTo='$usuario'";
			$result=mysql_query($query);
			if(!$result)
				return false;
			else{
				while($reg=mysql_fetch_assoc($result)){
					$this->listaConsultas2[]=$reg;
				}
				return $this->listaConsultas2;
			}
		}
	}
	
	public function getReceptor(){
		if($this->conectar->con()==true){
			$query="select idusuario, usuario 
					from  usuarios
					where usuario!='jair' and rol='superadmin' or rol='admin' order by idusuario asc";
			$result=mysql_query($query);
			if(!$result)
				return false;
			else{
				while($reg=mysql_fetch_assoc($result)){
					$this->lista[]=$reg;
				}
				return $this->lista;
			}
		}
	}
	
	public function getConsultas(){
		if($this->conectar->con()==true){
			$query="select * from consultas order by idconsulta desc";
			$result=mysql_query($query);
			if(!$result)
				return false;
			else{
				while($reg=mysql_fetch_assoc($result)){
					$this->listaConsultas[]=$reg;					
				}
				return $this->listaConsultas;
			}
		}
	}
	
	public function guardarNuevaConsulta($sendFrom,$consulta){
	
		if($this->conectar->con()==true){
			$listaReceptor=self::getReceptor();
			$listaConsulta=self::getConsultas();
			
			if(count($listaConsulta)>=1){
				$ultimoReceptor=$listaConsulta[0]['sendTo'];
				for($i=0;$i<count($listaConsulta);$i++){
					if($listaReceptor[$i]['usuario']==$ultimoReceptor){
						if($listaReceptor[($i+1)]['usuario']!='')
							$receptor=$listaReceptor[($i+1)]['usuario'];
						else 
							$receptor=$listaReceptor[0]['usuario'];
					}					
				}
			}
			else
				$receptor=$listaReceptor[0]['usuario'];
			
			$query="insert into consultas(consulta,fechareg,horareg,sendFrom,sendTo)
					values('$consulta',now(),now(),'$sendFrom','$receptor')";
			$result=mysql_query($query);
			
			if(!$result)
				return false;
			else
				return true;
		}
	}
	
	
}