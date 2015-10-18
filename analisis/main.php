<?
session_start();
class MainAnalisis{
	
	public function leftAnalisis(){
	
		 $left="<div id='left'>
			 <center>
			 <table width='175'>
				<tr class='tablahead'>
				 <td>
					<font class='hora'>Analisis de clientes segun las ventas<font/>   		    
				 </td>
				</tr>
				<tr class='tablaconten'>
				 <td align='center'>
					<font class='hora'><a href='javascript: void();' onclick=\"opengrafico('tipocliente');\">Por tipo de clientes</a></font>
				 </td>		 
				</tr>  		
				<tr class='tablaconten'>
				 <td align='center'>		 		
					<font class='hora'><a href='javascript: void();' onclick=\"opengrafico('zona');\">Por zonas</a></font>
				 </td>		 
				</tr> 
				<tr class='tablaconten'>
				 <td align='center'>
					<font class='hora'><a href='javascript: void();' onclick=\"opengrafico('topcliente');\">Top 10 de clientes</a></font>
				 </td>		 
				</tr>  		 		
			</table>
			<br>
			 <table width='175'>
				<tr class='tablahead'>
				 <td>
					<font class='hora'>Analisis de ventas<font/>   		    
				 </td>
				</tr>
				<tr class='tablaconten'>
				 <td align='center'>
					<font class='hora'><a href='javascript: void();' onclick=\"opengrafico('fechas');\">Por mes</a></font>
				 </td>		 
				</tr>  		
				<tr class='tablaconten'>
				 <td align='center'>
					<font class='hora'><a href='javascript: void();' onclick=\"opengrafico('productos');\">Por productos</a></font>
				 </td>		 
				</tr> 
				<tr class='tablaconten'>
				 <td align='center'>		 		
					<font class='hora'><a href='javascript: void();' onclick=\"opengrafico('vendedores');\">Por vendedores</a></font>
				 </td>		 
				</tr>  		 		
			</table>	   
			 </center>
		  </div>";
		  
		  return $left;
	
	}
	public function contenidoAnalisis(){
		$contenido="<div id='contenido'>
						<h1>Modulo de Analisis</h1>
						<br>
						<center>
							<p>Este  modulo esta destinado al manejo y administracion de las garantias
								dadas por la empresas a sus distintos clientes
							</p>
						</center>	 
						<br>
					</div>";
		return $contenido;
	}
	public function rightAnalisis(){
	
		$right="
			<div id='right'>
				 <center>
				<table width='175'>
					<tr class='tablahead'>
						<td>
							<font class='hora'>?<font/>
						</td>
					</tr>
					<tr class='tablaconten'>
						<td align='center'>		 		
							<font class='hora'>?</font>
						</td>		 
					</tr>  		
					<tr class='tablaconten'>
						<td align='center'>		 		
							<font class='hora'>?</font>
						</td>		 
					</tr> 
					<tr class='tablaconten'>
					 <td align='center'>		 		
						<font class='hora'>?</font>
					 </td>		 
					</tr>  		 		
				</table>
				<br>
				<table width='175'>
					<tr class='tablahead'>
						<td>
							<font class='hora'>?<font/>
						</td>
					</tr>
					<tr class='tablaconten'>
						<td align='center'>		 		
							<font class='hora'>?</font>
						</td>		 
					</tr>  		
					<tr class='tablaconten'>
						<td align='center'>		 		
							<font class='hora'>?</font>
						</td>		 
					</tr> 
					<tr class='tablaconten'>
					 <td align='center'>
						<font class='hora'>?</font>
					 </td>		 
					</tr>  		 		
				</table>	   
				 </center>
			  </div>";
		return $right;
	}
	public function imprimirMainAnalisis(){
		
		$imprimir=self::leftAnalisis();
		$imprimir.=self::contenidoAnalisis();
		$imprimir.=self::rightAnalisis();
		
		if($_SESSION['autentica'] == 'SIP' && $_SESSION['cargousuario']=='gerente')
		echo $imprimir;
		else echo "<script type='text/javascript'>alert('Acceso no autorizado!!!');	window.location='index.php';
		</script>";
	}
}
$ma=new MainAnalisis();
$ma->imprimirMainAnalisis();