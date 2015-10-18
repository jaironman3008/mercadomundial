<?
class PreguntasFrecuentes{

	private $opcion;

	public function __construct(){
		$this->opcion=$_POST['opcion'];
	}
	public function imprimirPreguntas(){
		$img="<img src='images/buscar.png' title='Leer' width='16px' height='auto'>";
		$html="
			<h1>Preguntas Frecuentes</h1>
			<ol class='preguntas-frecuentes'>
				<li onclick=\"abrirRespuesta(1)\">¿Que tengo que hacer para poder vender un producto?</li>
					<p class='respuesta1'>Es muy sencillo, cuando ingreses a tu cuenta eliges una categoria y bajo el titulo de la misma selecciona
					'Publicar en esta categoria', eso te llevará a un formulario que debes llenar con los datos del
					articulo que quieras registrar.</p>
					
				<li onclick=\"abrirRespuesta(2)\">¿Ya cargue el producto a la venta, ahora qué hago?</li>
					<p class='respuesta2'>Bien ya tienes una publicación ahora debes estar atento a tus 
					'Mensajes recibidos' porque podrías tener a una persona interesada en lo que 
					publicaste.</p>
					
				<li onclick=\"abrirRespuesta(3)\">¿Puedo editar la informacion de un producto?</li>
					<p class='respuesta3'>Si, si puedes editar la información de un producto, es muy sencillo; primero ve al menu 'Opiciones' al
					lado derecho de la pagina y elije 'Mis Publicaciones' alli encontraras todo los articulos que has publicado
					cada uno tiene la opcion de editar; dentro del formulario de edicion te econtraras con los datos actuales y
					otros posibles mas, como 'ofertar', si colocas algun monto, tu articulo aparecera en la seccion de 
					ofertas</p>
					
				<li onclick=\"abrirRespuesta(4)\">¿Vendí un producto ahora que hago?</li>
					<p class='respuesta4'>Muy bien, Felicidades!!!, ahora tienes que cambiar el estado 
					del articulo a 'Vendido', Ingresa a Opciones, elije la opción “Mis Publicaciones”, 
					esto te llevara a la bandeja de tus publicaciones, allí presiona la casilla de tu 
					articulo en la columna de Editar y luego cambia el estado a “Vendido”. Esto para que 
					tú articulo ya no aparezca entre los demás que están a la venta.</p>
				
				<li onclick=\"abrirRespuesta(5)\">¿El comprador vive en otra ciudad, como hago para cobrar el dinero y enviar el producto?</li>
					<p class='respuesta5'>Tú y el comprador deben decidir cuál es la mejor forma de realizar la transacción. Algunas sugerencias para realizar la transacción de manera segura y rápida son las siguientes:
- Los bancos son un canal rápido y seguro para enviar y recibir dinero. Como vendedor es útil que tengas una cuenta en un banco (si debes elegir un banco busca alguno que tenga sucursales en varias ciudades, mientras más ciudades mayor es tu alcance como vendedor). Cuando realices una venta pídele al cliente que realice un depósito en tu cuenta. De esta manera el obtiene un comprobante de pago (el depósito bancario) y tu recibes el dinero de forma inmediata. Posterior a esto envía el producto por correo, flota, avión, barco u otro medio que vean conveniente tu y el comprador.
</p>
				
				<li onclick=\"abrirRespuesta(6)\">¿Que tengo que hacer para comprar un producto?</li>
					<p class='respuesta6'>Cuando encuentres un producto que te interesa haz clic en la opción enviar mensaje, luego envía un mensaje al vendedor para llegar a un acuerdo de compra y conformidad entre ambas partes, posteriormente esté atento a sus mensajes recibidos por que en cualquier momento podría llegar la respuesta del vendedor.</p>									
				
				<li onclick=\"abrirRespuesta(7)\">¿MercadoMundial.esy.es asume alguna responsabilidad por los productos vendidos en su sitio?</li>
					<p class='respuesta7'>MercadoMundial.com.bo te ofrece una plataforma que sirve para que el vendedor y el comprador interactúen y realicen sus transacciones. MercadoMundial.com.bo no se responsabiliza de la veracidad del producto, de la calidad del producto o de que se llegue o nó a concretar la transacción en dicho sitio.</p>
			</ol>		
		";
		echo$html;
	}
	public function main(){
		switch($this->opcion){
			case'imprimirPreguntas':self::imprimirPreguntas();break;
		}
	}
}
$pf=new PreguntasFrecuentes();
$pf->main();