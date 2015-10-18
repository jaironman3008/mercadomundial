<?
include_once('ConsultaDominio.php');
class VistaConsultas{
	
	private $mensajeDominio;
	private $mensajeDominio2;	
	private $mensajeDominio3;
	
	public function __construct(){
		$this->consultaDominio=new ConsultaDominio();
		$this->consultaDominio2=new ConsultaDominio();
		$this->consultaDominio3=new ConsultaDominio();
	}
	public function paginar(){
		
		$vista=$_POST['vista'];if($vista=='')$vista=$_GET['vista'];		
		$RegistrosAMostrar=6;
		
		if(isset($_GET['pag'])){
			$RegistrosAEmpezar=($_GET['pag']-1)*$RegistrosAMostrar;
			$PagAct=$_GET['pag'];
		
		}
		elseif(isset($_POST['pag'])){
			$RegistrosAEmpezar=($_POST['pag']-1)*$RegistrosAMostrar;
			$PagAct=$_POST['pag'];
		}
		else{
			$RegistrosAEmpezar=0;
			$PagAct=1;	
		}
		$lista=$this->consultaDominio->paginarConsultas($RegistrosAEmpezar,$RegistrosAMostrar,$vista);		
		$NroRegistros=count($this->consultaDominio2->selectConsultas($vista));
		$PagAnt=$PagAct-1;
		$PagSig=$PagAct+1;
		$PagUlt=$NroRegistros/$RegistrosAMostrar;
				
		$Res=$NroRegistros%$RegistrosAMostrar;	
		if($Res>0) $PagUlt=floor($PagUlt)+1;
		
		$html="<div id='result'>
				<h1>Consultas</h1><br>
				<table width='85%' align='center'>	
					<tr class='tablahead'>
						<td>Nº</td>
						<td>De</td>
						<td>Consulta</td>						
						<td>Fecha</td>
						
					</tr>";
		for($i=0;$i<count($lista);$i++){
			
			if($lista[$i]['estado']=='sin responder'){
				$bgcolor="style='background-color: #E7E7E7'";
				$mouseOut="#E7E7E7";
			}
			else{
				$bgcolor='';
				$mouseOut="#FAFAFA";
			}
			
				$html.="<tr $bgcolor class='tablaconten' id='id_".$i."' onmousemove=\"cambiar(this.id,'#E7E7E7');\" onmouseout=\"cambiar(this.id,'$mouseOut')\">
							<td>".($i+1)."</td>
							<td>".$lista[$i]['sendFrom']."</td>							
							<td><textarea class='inputmostrar' cols='15' rows='2' readonly>".$lista[$i]['consulta']."</textarea>
								<a href='javascript:void()' onclick=\"msgRead('".$lista[$i]['idconsulta']."','".$PagAct."','".$vista."')\"><img src='images/sobreRespuesta.png' title='Responder' width='15px' height='auto'/></a>
								<img src='images/sobre.png' title='Sin leer' width='15px' height='auto'/>
								<img src='images/sobreAbierto.png'  title='Leido' width='15px' height='auto'/>
							</td>		
							<td>".$lista[$i]['fechareg']." ".$lista[$i]['horareg']."</td>								
							
						</tr>";
			
		}
		if(count($lista)>0){
			$html.="<tr class='tablaconten'>
						<td colspan='12' align='center'>
							<font class='hora'>
								<a href='javascript: void();' onclick=\"pagina(1,'VistaConsultas','".$vista."')\">PRIMERO</a>";
								if ($PagAct>1){$html.="<a href='javascript: void();' onclick=\"pagina('".$PagAnt."','VistaConsultas','".$vista."')\"> ANTERIOR </a>";}
								$html.="<i> Pagina ".$PagAct."/".$PagUlt." </i>";
								if ($PagAct<$PagUlt){$html.="<a href='javascript: void();' onclick=\"pagina('".$PagSig."','VistaConsultas','".$vista."')\">SIGUIENTE </a>";}
								$html.="<a href='javascript: void();' onclick=\"pagina('".$PagUlt."','VistaConsultas','".$vista."')\">ULTIMO</a>
							</font>
						</td>
					</tr>";
		}
		echo $html;
	}	
}
$vc=new VistaConsultas();
$vc->paginar();