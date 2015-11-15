<?php
class Login{

	public function leftLogin(){
		$retornar="<div id='left'>
		<center>
		<table width='175' cellspacing='10px'>
		<tr>
		<td height='25' align='center'><h2>Contactanos</h2></td>
		</tr>
		<tr>
		<td height='125' align='center'><img src='images/comprar-por-internet-consejos.png' width='110'><hr width='115' color='green'></td>
		</tr>
		<tr>
		<td height='25' align='center'><h2>Compras directas</h2></td>
		</tr>
		<tr>
		<td height='125'><img src='images/carrito-compra.png' width='150'><hr width='115' color='green'></td>
		</tr>
		<tr>		
		</table>
		</center>
		</div>";
		
		return $retornar;		
	}
	public function mainLogin(){
		$retornar="<div id='contenido'>
		<h1>Iniciar Sesion</h1>
		<p>Este sitio es exclusivo para usuarios de MercadoMundial.com.bo. Para acceder a una cuenta tienes que hacerlo mediante un usuario antiguo.</p>
		<center>
		<form action='index.php' name='form' onsubmit='validar_logueo();' method='post' id='form'><br>
			<table width='250px' height='120px' align='center' border='0'>
				<tr class='tablahead'>
					<td align='center' colspan='2'><font>Datos</font></td>
				</tr>
				<tr class='tablaconten'>
					<td><font>Usuario: </font></td>
					<td><input type='text' name='usuario'/><br></td>
				</tr>		
				<tr class='tablaconten'>
					<td><font>Password: </font></td>
					<td><input type='password' name='password'/><br></td>
				</tr>				
				<tr class='tablaconten'>
					<input type='hidden' name='grabar' value='si'/>
					<td colspan='4' align='center'><input type='submit' value='Iniciar'></td>
				</tr>
			</table>			
		</form>
		<br>				
		</center>
		<p>Para mayor informacion escribenos a <b>info@mercadomundial.com.bo</b></p>
		</div>";
		
		return $retornar;
	}
	public function rightLogin(){
	
		$retornar="<div id='right'>
		<center>
		<table width='175' cellspacing='10px'>
		<tr>
		<td height='25' align='center'><h2>Compra y vende con MercadoMundial<h2/></td>
		</tr>
		<tr>
		<td height='125'><img src='images/Ventas.png' width='150'><hr width='115' color='green'></td>
		</tr>
		<tr>
		<td height='25' align='center'><h2>Ventas directas</h2></td>
		</tr>
		<tr>
		<td height='125'><img src='images/compras-por-internet_large.png' width='150'><hr width='115' color='green'></td>
		</tr>		
		</table>
		</center>
		</div>";
		
		return $retornar;	
	
	}
	static function imprimirLogin(){
		$retornar=self::leftLogin();
		$retornar.=self::mainLogin();
		$retornar.=self::rightLogin();
		return $retornar;
	}
} 
    