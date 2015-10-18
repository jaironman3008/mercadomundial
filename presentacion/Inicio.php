<?
include_once('articulos/Articulo.php');
include_once('usuarios/UsuarioDominio.php');
//include_once('TerminosDeUso.php');

class Inicio{
	
	private $articulo;
	private $usuarioDominio;
	private $terminosDeUso;
	private $usuarioActual;
	private $rolUsuario;
	
	public function __construct(){
		$this->articulo= new Articulo();
		$this->usuarioDominio=new UsuarioDominio();
//		$this->terminosDeUso=new TerminosDeUso();
		$this->usuarioActual=$_SESSION['usuarioactual'];
		$this->rolUsuario=$_SESSION['rolusuario'];
	}
	
	public function leftInicio(){
	
		$lista=$this->articulo->getCategoriaArticulos();
		
		$retornar="<div id='left'>";
		$retornar.="<center>";
		$retornar.="<table width='175'>";
		$retornar.="<tr class='tablahead'>";
		$retornar.="<td><h2>Articulos</h2></td>";
		$retornar.="</tr>";
		for($i=0;$i<count($lista);$i++){
			if($lista[$i]['ver']=='si'){
			$retornar.="<tr class='tablaconten'>";
			$retornar.="<td align='center'><a class='VistaArticulo' href='javascript: void()'>".$lista[$i]['categoria']."</a></td>";
			$retornar.="</tr>";	
			}
		}	
		$retornar.="</table>";
		$retornar.="<br>";	
		$retornar.="</center>";
		$retornar.="</div>";
		
		return $retornar;
	
	}
	public function mainInicio(){
				
		$retornar="
			<div id='contenido'>
			<!--<a id='sendEmail' href='javascript:void()'>enviar email</a>-->
			<h1>Categorias mas visitadas</h1>			
			<p>Aqui te ofrecemos 3 de nuestras categorias mas visitadas.</p>";
		$retornar.=self::categoriasMasVisitadas();
		$retornar.="<br>					
					</div>";
		
		return $retornar;
		
	}
	public function categoriasMasVisitadas(){
		$lista=$this->articulo->categoriasMasVisitadas();
		
		$html="<table align='center' width='40%'>";
		for($i=0;$i<count($lista);$i++){
			$html.="<tr class='tablahead'>
						<td><a class='VistaArticulo' href='javascript: void()'>".$lista[$i]['categoria']."</a></td>
					</tr>";
		}
		$html.="</table align='center'><br>
				<!--<table align='center'>
					<tr>
						<td>
							<div id='TT_RijkIEo1ojh919GAjfzzDzDjjtaALdC2rtkt1Zi5Kkz'></div>
							<script type='text/javascript' src='http://www.tutiempo.net/widget/eltiempo_RijkIEo1ojh919GAjfzzDzDjjtaALdC2rtkt1Zi5Kkz'></script>
						</td>
					</tr>
				</table>-->
				";
		
		return $html;			
		
	}
	public function rightInicio(){
		$rMenuUsuarios=self::rightMenuUsuarios();
		$beneficios=$rMenuUsuarios['beneficios'];
		$misPublicaciones=$rMenuUsuarios['misPublicaciones'];
		$misInvitados=$rMenuUsuarios['misInvitados'];
		
		$retornar="<div id='right'>
		<center>
		<table width='175'><tr class='tablahead'><td><h2 onclick=\"abrirMenu(1)\">Atención</h2></td></tr></table>
		<div class='menu1'>
			<table width='175'>
			<tr class='tablaconten'>
			<td align='center'><a class='VistaArticulo' href='javascript: void()'>Ofertas</a></td>
			</tr>
			<tr class='tablaconten'>
			<td align='center'><a class='VistaArticulo' href='javascript:void()'>Recien Publicados</a></td>
			</tr>		
			</table>
		</div>
		<table width='175'><tr class='tablahead'><td><h2 onclick=\"abrirMenu(2)\">Opciones</h2></td></tr></table>
		<div class='menu2'>		
			<table width='175'>	
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkMiCuenta' href='javascript:void();'>Mi Perfil</a></font></td>
			</tr>			
			$beneficios
			$misPublicaciones	
			<tr class='tablaconten'>
			<td align='center'><font><a class='linkMisMensajes' href='javascript:void();'>Mensajes recibidos</a></font></td>
			</tr>
			<tr class='tablaconten'>
			<td align='center'><font><a class='linkMisMensajes' href='javascript:void();'>Mensajes enviados</a></font></td>
			</tr>
			$misInvitados
			</table>
		</div>";
		$administrarWeb=self::administrarWeb();
		$estadisticas=self::estadisticas();
		$administrarPaquetes=self::administrarPaquetes();
		$certificaciones=self::certificaciones();
		$backUps=self::backUps();
		
		switch($this->rolUsuario){
			case'superadmin':
				$retornar.=$administrarWeb;
				$retornar.=$estadisticas;
				$retornar.=$administrarPaquetes;
				$retornar.=$certificaciones;
				$retornar.=$backUps;
				break;
			case'admin':
				$retornar.=$certificaciones;
				break;
		}		
		$retornar.="</center>
					</div>";
		
		return $retornar;		
	
	}
	public function randomImg(){
		$html="
			<table>
				<tr class='tablaconten'>
					<td><div id='randomImg'></div><img src='img.png' width='160' height='auto'/></td>
				</tr>
			</table>
		";
		return $html;
	}
	public function administrarWeb(){
		
		$retornar.="
		<table width='175'><tr class='tablahead'><td><h2 onclick=\"abrirMenu(3)\">Administrar Web</h2></td></tr></table>
		<div class='menu3'>
			<table width='175'>		
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkBanner' href='javascript:void();'>Banner</a></font></td>
			</tr>
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkCategorias' href='javascript:void();'>Categorias</a></font></td>
			</tr>		
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkUsuarios' href='javascript:void();'>Usuarios de sistema</a></font></td>
			</tr>
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkNuevoAdministrador' href='javascript:void();'>Nuevo Administrador</a></font></td>
			</tr>
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkNuevoContrato' onclick=\"openFrmContrato()\" href='javascript:void();'>Nuevo contrato</a></font></td>
			</tr>
			</table>
		</div>";
		
		return $retornar;
		
	}
	public function estadisticas(){
		$retornar.="
		<table width='175'><tr class='tablahead'><td><h2 onclick=\"abrirMenu(4)\">Estadisticas</h2></td></tr></table>
		<div class='menu4'>
			<table width='175'>		
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkIncrementoUsuarios' href='javascript:void();'>Incremento de Usuarios</a></font></td>
			</tr>
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkIncrementoVentas' href='javascript:void();'>Incremento de Ventas(Cant)</a></font></td>
			</tr>
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkIncrementoVentasBs' href='javascript:void();'>Incremento de Ventas(Bs)</a></font></td>
			</tr>			
			</table>
		</div>";
		return $retornar;
	}
	public function administrarPaquetes(){
		$retornar.="
		<table width='175'><tr class='tablahead'><td><h2 onclick=\"abrirMenu(5)\">Administrar paquetes</h2></td></tr></table>
		<div class='menu5'>
			<table width='175'>			
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkVistaPaquetesUsuario' href='javascript:void();'>Nuevos Usuarios</a></font></td>
			</tr>
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkVistaPaquetesArticulo' href='javascript:void();'>Nuevos Articulos</a></font></td>
			</tr>
			<!--<tr class='tablaconten'>
			<td align='center'><font><a id='linkVistaAprobarArtculo' href='javascript:void();'>Nuevas Consultas</a></font></td>
			</tr>-->
			</table>
		</div>";
		return $retornar;
	}
	public function Certificaciones(){
		$retornar.="
		<table width='175'><tr class='tablahead'><td><h2 onclick=\"abrirMenu(6)\">Certificaciones</h2></td></tr></table>
		<div class='menu6'>
			<table width='175'>		
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkCertificarUsuarios' href='javascript:void();'>Usuarios</a></font></td>
			</tr>
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkCertificarArticulos' href='javascript:void();'>Articulos</a></font></td>
			</tr>		
			<!--<tr class='tablaconten'>
			<td align='center'><font><a id='linkIncrementoUsuarios' href='javascript:void();'>Consultas</a></font></td>
			</tr>-->			
			</table>
		</div>";
		return $retornar;
	}
	public function backUps(){
		$retornar.="
		<table width='175'><tr class='tablahead'><td><h2 onclick=\"abrirMenu(7)\">Restaurar Sistema</h2></td></tr></table>
		<div class='menu7'>
			<table width='175'>		
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkCrearBackUps' href='javascript:void();'>Crear Punto de Restauracion</a></font></td>
			</tr>
			<tr class='tablaconten'>
			<td align='center'><font><a id='linkRestaurarBackUps' href='javascript:void();'>Restaurar Sistema</a></font></td>
			</tr>			
			</table>
		</div>";
		return $retornar;
	}
	public function rightMenuUsuarios(){
		$beneficios="
		<tr class='tablaconten'>
			<td align='center'><font><a id='linkBeneficiosPorUsuario' href='javascript:void();'>Beneficios por nuevo usuario</a></font></td>
		</tr>
		";
		$misPublicaciones="
		<tr class='tablaconten'>
			<td align='center'><font><a id='linkMisPublicaciones' href='javascript:void();'>Mis Publicaciones</a></font></td>
		</tr>
		";
		$misInvitados="
		<tr class='tablaconten'>
			<td align='center'><font><a id='linkMisInvitados' href='javascript:void();'>Mis Invitados</a></font></td>
		</tr>
		";
		
		if($this->rolUsuario=='usuario'){
			$rMenuUsuarios['beneficios']=$beneficios;
			$rMenuUsuarios['misPublicaciones']=$misPublicaciones;
			$rMenuUsuarios['misInvitados']=$misInvitados;
		}
		return $rMenuUsuarios;
	}
	public function mensajeCuentaVencida(){
		$html="		
			<div id='contenido'>			
				<h1>Ups tu cuenta ya vencio</h1>
				<p>Estimado usuario de www.MercadoMundial.esy.es, te hacemos conocer que ya han pasado los 31 dias del
				mes calendario que dura tu cuenta, por ahora sigue disfrutando de nuestro servicios de manera
				gratuita y luegos te informaremos como podrás continuar con nosotros.<br>Atentamente <br>La Administración</p>
				<input type='button' id='mensajeLeido' value='He leido este mensaje'>
			
			</div>
		";
		return $html;
	}
	public function imprimirInicio(){
	
		$lista=$this->usuarioDominio->selectUsuario($this->usuarioActual);
		$usuarioVencido=$this->usuarioDominio->cuentaVencida($lista[0]['idusuario']);
		if($lista[0]['terminosDeUso']!='si'){//SI NO ACEPTO LOS TERMINOS DE USO ENTRA AKI
			//$retornar=$this->terminosDeUso->imprimirTerminos();
		}
		else{//SI YA ACEPTO LOS TERMINOS DE USO ENTRA AKI
			$retornar=self::leftInicio();
			//SI EXISTE ENCUENTRA AL USUARIO ENTRE LOS QUE YA VENCIERON LOS 31 DIAS
			if($usuarioVencido[0]['usuario']==$this->usuarioActual){
				if($this->usuarioDominio->mensajeLeido($lista[0]['idusuario'])==true){
					$retornar.=self::mainInicio();
				}
				else{
					$retornar.=self::mensajeCuentaVencida();
				}
			}
			else{
				$retornar.=self::mainInicio();
			}
			$retornar.=self::rightInicio();
		}
		
		return$retornar;		
	}
}