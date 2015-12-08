<?php
// session_start();
include_once('Usuario.php');
class VistaMisInvitados{
	public function __construct(){
		
	}
	public function paginar(){
		
	}
	
}
$objetousuario=new Usuario();
$objetousuario2=new Usuario();
$usuario=$_POST['usuario'];
$vista=$_POST['vista'];if($vista=='')$vista=$_GET['vista'];
$porusuario=$_POST['porusuario'];if($porusuario=='')$porusuario=$_GET['porusuario'];

$RegistrosAMostrar=5;

//estos valores los recibo por GET
if(isset($_GET['pag'])){
	$RegistrosAEmpezar=($_GET['pag']-1)*$RegistrosAMostrar;
	$PagAct=$_GET['pag'];
//caso contrario los iniciamos
}else{
	$RegistrosAEmpezar=0;
	$PagAct=1;	
}
$lista=$objetousuario->paginarMisInvitados($RegistrosAEmpezar,$RegistrosAMostrar,$vista);
//determinamos las paginas
$registros=$objetousuario2->selectMisInvitados($vista);
$NroRegistros=count($registros);
$PagAnt=$PagAct-1;
$PagSig=$PagAct+1;
$PagUlt=$NroRegistros/$RegistrosAMostrar;

//verificamos residuo para ver si llevará decimales
$Res=$NroRegistros%$RegistrosAMostrar;
// si hay residuo usamos funcion floor para que me
// devuelva la parte entera, SIN REDONDEAR, y le sumamos
// una unidad para obtener la ultima pagina
if($Res>0) $PagUlt=floor($PagUlt)+1;
?>
<div id="result">
<h1>Mis Invitados</h1><br>
<table width="85%" align="center">	
	<tr class="tablahead">
		<td><font class="hora">Nº</font></td>
		<td><font class="hora">Nombre</font></td>
		<td><font class="hora">Ap.Pat.</font></td>
		<td><font class="hora">Ap.Mat.</font></td>		
		<td><font class="hora">C.I.</font></td>		
		<td><font class="hora">Usuario</font></td>		
		<td><font class="hora">Rol</font></td>		
	</tr>
	<?
	for($i=0;$i<count($lista);$i++){
	$user=$objetousuario->returnUsuario($lista[$i]['addedby']);
	?>	
	<tr class="tablaconten" id="<?echo "id_".$i?>" onmousemove="cambiar(this.id,'#E7E7E7');" onmouseout="cambiar(this.id,'#FAFAFA')">
		<td><font class="hora"><?echo$i+1?></font></td>
		<td><font class="hora"><?echo$lista[$i]['nombre']?></font></td>
		<td><font class="hora"><?echo$lista[$i]['appaterno']?></font></td>
		<td><font class="hora"><?echo$lista[$i]['apmaterno']?></font></td>		
		<td><font class="hora"><?echo$lista[$i]['ci']?></font></td>		
		<td><font class="hora"><?echo$lista[$i]['usuario']?></font></td>		
		<td><font class="hora"><?echo$lista[$i]['rol']?></font></td>		
	</tr>
	<?
	}
	?>
	<tr class="tablaconten">
		<td colspan="8" align="center">
			<font class="hora">
				<a href="javascript: void();" onclick="pagina(1,'VistaMisInvitados','<?echo$vista?>')">PRIMERO</a>
				<?if ($PagAct>1){?><a href="javascript: void();" onclick="pagina('<?echo $PagAnt?>','VistaMisInvitados','<?echo$vista?>')">ANTERIOR</a><?}?>
				<i>Pagina <?echo$PagAct."/".$PagUlt?></i>
				<?if ($PagAct<$PagUlt){?><a href="javascript: void();" onclick="pagina('<?echo $PagSig?>','VistaMisInvitados','<?echo$vista?>')">SIGUIENTE</a><?}?>
				<a href="javascript: void();" onclick="pagina('<?echo$PagUlt?>','VistaMisInvitados','<?echo$vista?>')">ULTIMO</a>
			</font>
		</td>
	</tr>	
</table>
</div>