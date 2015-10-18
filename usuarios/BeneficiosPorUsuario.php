<?
include_once('classUsuario.php');

class BeneficiosPorUsuario{
	
	private $usuario;
	private $usuario2;	
	private $user;
	
	public function __construct(){
		$this->usuario=new classUsuario();		
		$this->user=$_POST['usuario'];		
	}

	public function imprimirBeneficios(){
		$font="
			<h1>COMO GANAR DINERO PROMOCIONANDO MERCADO MUNDIAL</h1>
			<p>
			<b>¿Sabías que al promocionar Mercado Mundial puedes ganar Bs. 6250 o más?, ¿te preguntaras cómo?</b>
			<br><br>
			-Sencillo lo único que debes hacer es recomendar esta página a 5 de tus amigos, vecinos, compañeros de trabajo o familiares más cercanos, ya que para obtener ganancias necesariamente debes invitar a otras personas. 
			<br><br>
			A continuación te explico los pasos que debes seguir  para ganar semejante suma de dinero promocionando <b>MERCADO MUNDIAL</b>.
			<br><br>
			<b>LO PRIMERO QUE DEBE HACER ES COMENTAR A TUS PARIENTES Y AMIGOS MÁS CERCANOS SOBRE LOS BENEFICIOS QUE MERCADO MUNDIAL OTORGA A SUS USUARIOS.</b>
			<br><br>
			Al conseguir un interesado debes inscribirlo desde tu cuenta para que el administrador pueda considerar su solicitud.
			<br>
			<b>PASOS A SEGUIR PARA INSCRIBIR NUEVOS USUARIOS</b>
			<br><br>
			1ro. El nuevo usuario (tu invitado) debe dirigirse al Banco Unión y realizar 6 depósitos bancarios; el 1ro, 2do, 3ro, 4to y 5to serán de Bs. 2 y el 6to que es a <b>MERCADO MUNDIAL</b> será de Bs. 40 
			2do. Debes escanear los 6 depósitos juntos para que al momento de inscribir a tu invitado subas a la web sus depósitos, ya que sin este requisito tu solicitud será rechazara por el administrador. Una vez enviada tu solicitud de crear cuenta nuevo usuario el administrador verificara si tus datos de inscripción son correctos, y en un plazo no mayor a 24 horas se le notificara si su invitado fue aceptado, rechazado u observado, además el nuevo usuario debe contar con una Cuenta en el mismo Banco.
			<br><br>
			<b>AHORA TE EXPLICO COMO ES QUE LLEGAS A GANAR SEMEJANTE SUMA DE DINERO</b>
			<br><br>
			Bien <b>MERCADO MUNDIAL</b> pose una relación nominal de nombres y números de cuenta de sus Usuarios antiguos, que están ordenados de forma <b>ascendente</b> y que a medida que van ingresando nuevos usuario  
			<br><br>			
			".self::tablaUsuario()."
			<br><br>
			Los antiguos van recorriendo un puesto atrás hasta quedar fuera de la lista, pero lo más interesante es que mientras más atrás te encuentres del 1er puesto más ganancias obtendrás.
			<br>
			A continuación con simples cálculos matemáticos de sumas y multiplicaciones sencillas te explico cómo es que llegas a ganar más de Bs. 6250: 			
			<br><br>
			1) Al principio como nuevo usuario eres el primero en la lista, luego de invitar a 5 personas, tu quedas como segundo y estos nuevos usuarios como primeros, lo interesante es que estos 5 nuevos usuarios realizan depósitos de Bs. 2 a todas las cuentas, lo cual es beneficiosos para ti haciendo te ganar la suma de Bs. 10.
			<br><br><img src='images/imgBeneficio1.png' style='margin:0px 0px 20px 30%;' /><br>				
		
			2) De la misma forma que tu invitaste invitaran a 5 personas cada uno de tus cinco nuevos usuarios, haciendo un total de 25 nuevos invitados los cuales harán depósitos de Bs. 2 a cada cuenta haciendo te ganar la suma de Bs. 50, y quedaras en la lista como tercero.
			<br><br>
			3) Cada una de estas 25 personas invitaran a 5 personas más, haciendo un total de 125 nuevos usuarios los cuales te harán ganar Bs. 250, quedando tú en la lista como cuarto
			<br><br>
			4) Cada una de estas 125 personas invitaran a 5 personas más, haciendo un total de 625 nuevos usuarios los cuales te harán ganar un total de Bs. 1250, quedando tú en la lista como quinto
			<br><br>
			5) Cada una de estas 625 personas invitaran a 5 personas más, haciendo un total de 3125 nuevos usuarios los cuales te harán ganar un total de Bs. 6250, quedando tú fuera de la lista con una ganancias que sobrepasaría los Bs. 7800. Solo por recomendar esta página a 5 personas y que estos a su vez recomienden a otra cantidad similar hasta conseguir contar con 625 nuevos usuarios como mínimo.				
			
			<br>
			<img src='images/imgComoGanarDinero.png' width='500' height='auto'/>
			</p>
		";	
		echo $font;
	}
	public function tablaUsuario(){
		
		//$userSpecial[0]='ELISEO Villca Luna';
		$userSpecial[0]='Ruth Villca Luna';
		$userSpecial[1]='Abigail Cordero Nina';
		$userSpecial[2]='Ivith Nancy nina';
		$userSpecial[3]='Javier Jair Cussy Saucedo';		
				
		//$cuenta[0]='301-50692419-3-80';
		$cuenta[0]='10000016802048';
		$cuenta[1]='10000017251179';
		$cuenta[2]='10000015760081';
		$cuenta[3]='10000010208135';
		
		
		$curUser=$this->usuario->selectusuarios($this->user);
		
		$tabla="<table align='center' width='35%'>";		
			$tabla.="<tr class='tablahead'>
					<td colspan='2'><a id='linkFrmNuevoUsuario' href='javascript: void()'>REGISTRAR USUARIO</a></td>
				</tr>";
		$hijo=$curUser[0]['addedby'];	
		//if($hijo!=$curUser[0]['idusuario']){
		if($curUser[0]['usuario']!='eliseosuper'){
		//SI UN USUARIO OBSERVA LA TABLA
			$tabla.="				
				<tr class='tablahead'>
					<td rowspan='2'>1</td>
					<td>".$curUser[0]['numcuenta']."</td>
				</tr>
				<tr class='tablaconten'>				
					<td align='center'><b>".$curUser[0]['nombre']." ".$curUser[0]['appaterno']." ".$curUser[0]['apmaterno']."</b></td>
				</tr>
			";
			$desde=2;
		}else $desde=1;
			
			for($i=$desde;$i<6;$i++){
				
				$this->usuario2=new classUsuario();
				$padre=$this->usuario2->returnUsuario($hijo);//OBTENGO EL ANFITRION
				$user=$this->usuario2->returnUsuario($padre[0]['idusuario']);//OBTENGO AL USUARIO
				if($padre[0]['usuario']=='eliseosuper'){
					for($j=0;$j<(6-$i);$j++){
						$tabla.="
							<tr class='tablahead'>
								<td rowspan='2'>".($j+$i)."</td>
								<td>".$cuenta[$j]."</td>
							</tr>
							<tr class='tablaconten'>
								<td align='center'><b>".$userSpecial[$j]."</b></td>
							</tr>
						";
					}
					break;
				}
				else{
					$tabla.="<tr class='tablahead'>
								<td rowspan='2'>".$i."</td>
								<td>".$user[0]['numcuenta']."</td>
							</tr>
							<tr class='tablaconten'>				
								<td align='center'><b>".$user[0]['nombre']." ".$user[0]['appaterno']." ".$user[0]['apmaterno']."</b></td>
							</tr>";
					if($padre[0]['addedby']==$hijo)
					break;
					else
					$hijo=$padre[0]['addedby'];
				}
				
			}
			$tabla.="
					<tr class='tablahead'>
						<td rowspan='2'>6</td>
						<td>10000016803517</td>
					</tr>
					<tr class='tablaconten'>				
						<td align='center'><b>Mercado Mundial</b></td>
					</tr>
			";
			
		$tabla.="</table>";
		return $tabla;
	}	
	
	public function imagen(){
		$img="<img src='images/imgComoGanarDinero.png' width='500' height='auto'/>";
		return $img;
	}
}
$bpu=new BeneficiosPorUsuario();
$bpu->imprimirBeneficios();