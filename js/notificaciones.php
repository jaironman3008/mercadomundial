<?
include_once('classNotificacion.php');
$notificacion=new Notificacion();
?>
<script type="text/javascript">
$(document).ready(
		function()
		{
			// Opciones globales de las notificaciones
			$.extend($.gritter.options, {
			position: 'bottom-right',
			fade_in_speed: 'slow',
			fade_out_speed: 3000,
			time: '20000',
			class_name: 'gritter-light'
			});			
			// Mostrar una notificación
			<?
			$casimora=$notificacion->misclientes($_SESSION['usuarioactual'],'casimora');
			if(count($casimora)>0){//********************************SI TIENE CLIENTES ENTRANDO A MORA?>			
			$('add-gritter-light').ready(function(){//cambie click por ready para que se carge automaticamente
										  $.gritter.add({
										  title: "ENTRANDO A MORA",
										  text: "Tienes <?echo count($casimora)?> cliente(s) que esta(n) por entrar a mora",
										  image: "images/informacion.png",
										  sticky: false
										  });
										return false;
										}
			);			
			<?}
			$notificacion=new Notificacion();
			$enmora=$notificacion->misclientes($_SESSION['usuarioactual'],'enmora');
			?><?
			if(count($enmora)>0){//********************************SI TIENE CLIENTES EN MORA?>			
			$('add-gritter-light').ready(function(){//cambie click por ready para que se carge automaticamente
										  $.gritter.add({
										  title: "CLIENTES EN MORA",
										  text: "Tienes <?echo count($enmora)?> cliente(s) que esta(n) en mora",
										  image: "images/alerta.png",
										  sticky: false
										  });
										return false;
										}
			);			
			<?}?>
		}
	);
</script>