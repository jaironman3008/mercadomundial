//********************************************************************************AJAX*/
function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
function cambiar(id,color)//********************************************cambia el color de la fila de una tabla */
{	
	$('#'+id+' td').css({background:color});
}
function pagina(nropagina,sw,vista1,vista2){//*********************************pagina los resultados de una tabla
	
	divContenido = document.getElementById('result');
	divContenido.innerHTML= '<img style="margin-top:25%" src="images/anim.gif">';
	ajax=objetoAjax();
	
	switch(sw){
		case 'VistaUsuario':ajax.open("GET", "usuarios/VistaUsuario.php?pag="+nropagina+"&porusuario="+vista1+"&vista="+vista2);break;
		case 'VistaArticulo':ajax.open("GET", "articulos/VistaArticulo.php?pag="+nropagina+"&vista="+vista1);break;
		case 'VistaBanner':ajax.open("GET", "presentacion/VistaBanner.php?pag="+nropagina);break;
		case 'VistaCategoria':ajax.open("GET", "articulos/VistaCategoria.php?pag="+nropagina);break;
		case 'VistaMisArticulo':ajax.open("GET", "articulos/VistaMisArticulo.php?pag="+nropagina+"&vista="+vista1+"&openFrom="+vista2);break;
		case 'VistaMisInvitados':ajax.open("GET", "usuarios/VistaMisInvitados.php?pag="+nropagina+"&vista="+vista1+"&openFrom="+vista2);break;
		case 'VistaMisMensajes':ajax.open("GET", "mensajes/VistaMisMensajes.php?pag="+nropagina+"&vista="+vista1+"&tipo="+vista2);break;
		case 'VistaConsultas':ajax.open("GET", "consultas/VistaConsultas.php?pag="+nropagina+"&vista="+vista1);break;
	}	
	
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
	
			divContenido.innerHTML = ajax.responseText;
		}
	}
	
	ajax.send(null)
}
function cargar(anio,grafico){   
	switch(grafico){
		case'incrementoUsuarios':grafico='IncrementoUsuarios';break;
		case'incrementoVentas':grafico='IncrementoVentas';break;
		case'incrementoVentasBs':grafico='IncrementoVentasBs';break;
	}	
	url="analisis/g"+grafico+".php?anio="+anio; 
	/*despues creamos la grafica*/
	fi = document.getElementById('grafica');
	var imagen = document.createElement('img');
	imagen.src=url;
	fi.appendChild(imagen);
}
 function limpiar(){
            var d = document.getElementById('grafica');
            while (d.hasChildNodes())
            d.removeChild(d.firstChild);
        }
//*****************************************************************VALIDAR DATOS DE LOGUEO*/
function validar_logueo()
{
	var form=document.form;
	if (form.usuario.value==0)
	{
		alert("Ingrese su Login");
		form.usuario.value="";
		form.usuario.focus();
		return false;
	}
	if (form.password.value==0)
	{
		alert("Ingrese su Password");
		form.password.value="";
		form.password.focus();
		return false;
	}
	form.submit();	
}

/*---------------------------------------------------------------------------EDITAR ARTICULO*/
function openEditarMisArticulos(idArticulo){	
	$.ajax({
		type: "POST",
		url: 'articulos/FrmEditarArticulo.php',           
		data: "idArticulo="+idArticulo,		
		beforeSend: beforeSendImg(),
		success: function(data){
					$("#contenido").html(data);	
					$("#FrmEditarArticulo").submit(function(){actualizarArticulo();return false});
					$('#cancelarfrmEditarArticulo').click(function(){openMisPublicaciones()});
				}
	});
}
function actualizarArticulo(){
	var formData = new FormData(document.getElementById('FrmEditarArticulo'));
	if(parseInt($("input[name=oferta]").val()) >= parseInt($("input[name=precio]").val())){
		alert($("input[name=oferta]").val()+" "+$("input[name=precio]").val());
		alert('La oferta no puede ser mayor o igual que el precio actual del Articulo');
	}
	else{
		alert($("input[name=oferta]").val()+" "+$("input[name=precio]").val());
	$.ajax({
			type: "POST",
			url: 'articulos/ArticuloDominio.php',				
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: beforeSendImg(),
			success: function(data){$("#contenido").html(data)}
		});
	}
}
/*---------------------------------------------------------------------------NUEVO ARTICULO*/
function openFrmNuevoArticulo(vista){

	curUser=$('#usuarioActual').text();
	$.ajax({
		type: "POST",
		url: 'articulos/FrmNuevoArticulo.php',           
		data: "vista="+vista+"&curUser="+curUser,
		beforeSend: beforeSendImg(),
		success: function(data){
					
					$("#contenido").html(data);
					$("#FrmNuevoArticulo").submit(function(){guardarNuevoArticulo();return false});
					$("textarea").keyup(function(){limitarCaracteres('descripcion')});

				}		   
	});
}
function guardarNuevoArticulo(){

	usuario=$('#usuarioActual').text();
	formData= new FormData(document.getElementById('FrmNuevoArticulo'));		
	$.ajax({
           	type: "POST",
           	url: 'articulos/ArticuloDominio.php',
           	data:formData,
			cache: false,
			contentType: false,
			processData: false,
           	//data: $('#FrmNuevoArticulo').serialize()+"&opcion=insertArticulo&usuario="+usuario,
		   	beforeSend: beforeSendImg(),
           	success: function(data){$("#contenido").html(data);}		   
         });
}
/*---------------------------------------------------------------------------FUNCIONES DE CATEGORIA*/

	function guardarCategoria(){
		categoria=$('input[name=categoria]').val();
		//alert(categoria)		 
		$.ajax({
			type: "POST",
			url: 'articulos/CategoriaDominio.php',
			data: 'categoria='+categoria+'&opcion=insertCategoria',
			beforeSend: beforeSendImg(),
			success: function(data){$("#contenido").html(data);}
		 });		
	}
	function actualizarCategoria(){
		datosCategoria=$('input[type=checkbox]').val();	
		id=datosCategoria.split('_')[0];
		ver=datosCategoria.split('_')[1];	
		
		$.ajax({
			type:'POST',
			url: 'articulos/CategoriaDominio.php',
			data:'idCategoria='+id+'&ver='+ver+'&opcion=actualizarCategoria'		
		});
	}

/*---------------------------------------------------------------------------VALIDAR NUEVO USUARIO*/

function checkUser(userdata){
	
   $.ajax({
           type: "POST",
           url: 'usuarios/ValidateNewUser.php',
           data: "userdata="+userdata+"&opcion=checkUser", 
           success: function(data){$("#verificausuario").html(data);}		   
         });
}
function checkCi(userdata){
	$.ajax({
           type: "POST",
           url: 'usuarios/ValidateNewUser.php',
           data: "userdata="+userdata+"&opcion=checkCi", 
           success: function(data){$("#verificaCi").html(data);}		   
         });
}
function checkLevelSecurity(){
	passlength=$('input[name=password]').val();
   $.ajax({
           type: "POST",
           url: 'usuarios/ValidateNewUser.php',
           data: "passlength="+passlength+"&opcion=checkLevelSecurity", 
           success: function(data){$("#verificalenghtpass").html(data);}
		   
         });
}
function checkRepeatPass(){
	pass1=$('input[name=password]').val();
	pass2=$('input[name=cpassword]').val();
   $.ajax({
           type: "POST",
           url: 'usuarios/ValidateNewUser.php',
           data: "pass1="+pass1+"&pass2="+pass2+"&opcion=checkRepeatPass", 
           success: function(data){$("#verificapass").html(data);}		   
         });
}
/*---------------------------------------------------------------------------VALIDAR CAMBIO DE PASS USUARIO*/
	
function ingresarPass(){
		
	oldPass=$('input[name=oldPass]').val();
	$.ajax({
		type: "POST",
		url: 'usuarios/ValidateOldUser.php',
		data: "oldPass="+oldPass+"&opcion=checkOldPass", 
		success: function(data){$("#ingresaPass").html(data);}		   
	});	
}
function checkNewPass(){
	newPass=$('input[name=newPass]').val();
	$.ajax({
		   type: "POST",
		   url: 'usuarios/ValidateOldUser.php',
		   data: "newPass="+newPass+"&opcion=checkNewPass", 
		   success: function(data){$("#ingresaNuevoPass").html(data);}
		   
		});
}
function confirmNewPass(){
	pass1=$('input[name=newPass]').val();
	pass2=$('input[name=confirNewPass]').val();
	$.ajax({
	   type: "POST",
	   url: 'usuarios/ValidateOldUser.php',
	   data: "pass1="+pass1+"&pass2="+pass2+"&opcion=confirNewPass", 
	   success: function(data){$("#confirmaNuevoPass").html(data);}
	   
	});
}
/*---------------------------------------------------------------------------REVISAR USUARIO*/
function pdf(){
	//alert('hola');
	$.ajax({
		type:'POST',
		url:'facturasPdf/Factura.php',
		beforeSend: beforeSendImg(),
		success:function(data){$('#contenido').html(data)}
	});
}
function openRevisarUsuario(userToEdit){
	curUser=$('#usuarioActual').text();
	vista=$('#rolUsuario').text();	
	$.ajax({
		type:'POST',
		url:'usuarios/FrmEditarUsuario.php',
		data:'curUser='+curUser+'&userToEdit='+userToEdit+'&vista='+vista+'&openFrom=revisarUsuario',
		beforeSend: beforeSendImg(),
		success:function(data){
				$('#contenido').html(data);
				//$('#ingresaPass').hide();
				$('input[name=oldPass]').keyup(function(){ingresarPass()});				
				$('#aceptar').click(function(){respuestaRevisarUsuario('aceptado');return false});
				$('#pdf').click(function(){pdf()});
				$('#rechazar').click(function(){respuestaRevisarUsuario('rechazado');return false});
				$('#cancelarFrmRevisarUsuario').click(function(){certificarUsuarios()});
			}
	});	
}
function respuestaRevisarUsuario(respuestaRevision){
	pass1=$('input[name=newPass]').val();
	pass2=$('input[name=confirNewPass]').val();		
	idUsuarioRevisado=$('input[name=idUsuario]').val();
	curUser=$('#usuarioActual').text();	
	if($('#ingresaPass').text()=='OK!!!'){	
		if(respuestaRevision=='rechazado'){
			if(confirm('Va a rechazar esta solicitud. El C.I. Registrado no sera admitido en futuras solicitudes')){
				explicacion=prompt("EXPLICACION","");
				switch(explicacion){
					case null:break;
					case'':alert('Debe introducir una explicacion');break;					
					default:
						//alert('El usuario ha sido dado rechazado')
						if(confirm('CONFIRMAR EXPLICACION\n'+explicacion)==true){
							alert('explicacion confirmada');
							$.ajax({
								type:'POST',
								url:'usuarios/UsuarioDominio.php',
								data:'curUser='+curUser+'&explicacion='+explicacion+'&respuestaRevision='+respuestaRevision+'&idUsuarioRevisado='+idUsuarioRevisado+'&opcion=respuestaRevisarUsuario',
								beforeSend: beforeSendImg(),
								success:function(data){
										$('#contenido').html(data);							
									}
							});
						}
						break;
				}
			}
		}
		else{
			if(confirm('Confirma que dará de alta a este usuario?')){
				//alert('El usuario ha sido dado de alta')
				$.ajax({
					type:'POST',
					url:'usuarios/UsuarioDominio.php',
					data:'curUser='+curUser+'&respuestaRevision='+respuestaRevision+'&idUsuarioRevisado='+idUsuarioRevisado+'&opcion=respuestaRevisarUsuario',
					beforeSend: beforeSendImg(),
					success:function(data){
							$('#contenido').html(data);							
						}
				});
			}
		}
		
	}
	else alert('El pass Actual no es correcto');
}
function verImagenDeposito(img){/*************OJO CON ESTA FUNCION SE AGREGO UN NUEVO PARAMETRO*/
	window.location.href='images/depositos/'+img;	
}
/*---------------------------------------------------------------------------REVISAR ARTICULO*/
function openRevisarArticulo(idArticulo){/** SE ABRE EL FORMULARIO PARA REVISAR EL ARTICULO*/
	curUser=$('#usuarioActual').text();
	vista=$('#rolUsuario').text();	
	$.ajax({
		type:'POST',
		url:'articulos/FrmEditarArticulo.php',
		data:'curUser='+curUser+'&idArticulo='+idArticulo+'&vista='+vista+'&openFrom=revisarArticulo',
		beforeSend: beforeSendImg(),
		success:function(data){
				$('#contenido').html(data);
				//$('#ingresaPass').hide();
				$('input[name=oldPass]').keyup(function(){ingresarPass()});				
				$('#aceptar').click(function(){respuestaRevisarArticulo('aceptado');return false});
				$('#rechazar').click(function(){respuestaRevisarArticulo('rechazado');return false});
				$('#sugerencia').click(function(){sugerenciaParaRevision('sugerencia');return false});
				$('#cancelarFrmRevisarArticulo').click(function(){certificarArticulos()});
			}
	});
}
function certificarArticulos(){
	vista=$('#usuarioActual').text();
		$.ajax({
			type: "POST",
			url: 'articulos/VistaMisArticulo.php',
			data: 'vista='+$('#usuarioActual').text()+"&openFrom=revisar", 
			beforeSend: beforeSendImg(),
			success: function(data){$("#contenido").html(data);}
			
         });
}
function openMisPublicaciones(){
	vista=$('#usuarioActual').text();
		$.ajax({
			type: "POST",
			url: 'articulos/VistaMisArticulo.php',
			data: 'vista='+$('#usuarioActual').text(), 
			beforeSend: beforeSendImg(),
			success: function(data){$("#contenido").html(data);},
			
         });
}
function sugerenciaParaRevision(){/**SE ENVIA UN MENSAJE AL USUARIO SEÑALANDO ERRORES EN SU PUBLICACION*/
	curUser=$('#usuarioActual').text();
	idArticuloRevisado=$('input[name=idArticulo]').val();
	sugerenciaRevision=prompt('SUGERENCIA','');
	switch(sugerenciaRevision){
		case null:break;
		case '':alert('Debe Introducir un valor');break;
		default:			
			if(confirm('CONFIRMAR SUGERENCIA: \n'+sugerenciaRevision)==true){
				$.ajax({
						type:'POST',
						url:'articulos/ArticuloDominio.php',
						data:'curUser='+curUser+'&sugerenciaRevision='+sugerenciaRevision+'&idArticuloRevisado='+idArticuloRevisado+'&opcion=sugerenciaRevisionArticulo',
						beforeSend: beforeSendImg(),
						success:function(data){
								$('#contenido').html(data);							
							}
					});
			}
			break;
	}
}
function respuestaRevisarArticulo(respuestaRevision){/**SE EJECUTA LA OPCION ACEPTAR O RECHAZAR PUBLICACION*/
	idArticuloRevisado=$('input[name=idArticulo]').val();
	curUser=$('#usuarioActual').text();	
							
	if(respuestaRevision=='rechazado'){
		if(confirm('Rechazar la publicacion de este Articulo.')){
			//alert(idArticuloRevisado+' '+curUser);
			$.ajax({
				type:'POST',
				url:'articulos/ArticuloDominio.php',
				data:'curUser='+curUser+'&respuestaRevision='+respuestaRevision+'&idArticuloRevisado='+idArticuloRevisado+'&opcion=respuestaRevisarArticulo',
				beforeSend: beforeSendImg(),
				success:function(data){
						$('#contenido').html(data);							
					}
			});
		}
	}
	else{
		if(confirm('Aceptar la publicacion de este Articulo?')){
			//alert('El articulo ha sido dado de alta')
			$.ajax({
				type:'POST',
				url:'articulos/ArticuloDominio.php',
				data:'curUser='+curUser+'&respuestaRevision='+respuestaRevision+'&idArticuloRevisado='+idArticuloRevisado+'&opcion=respuestaRevisarArticulo',
				beforeSend: beforeSendImg(),
				success:function(data){
						$('#contenido').html(data);							
					}
			});
		}
	}
}
//*****************************************************************BOTONES CANELAR DE TODOS LOS FORMULARIOS
$(document).on('click','#cancelarFrmNuevoArticulo',function(e){
        e.preventDefault();
        var view=$('input[name=categoria]').val();
        abrirVistaArticulo(view);
});
/*---------------------------------------------------------------------------ACTUALIZAR USUARIO*/
function openFrmEditarUsuario(userToEdit){/*************OJO CON ESTA FUNCION SE AGREGO UN NUEVO PARAMETRO*/
	curUser=$('#usuarioActual').text();
	vista=$('#rolUsuario').text();
	//alert(userToEdit);
	$.ajax({
		type:'POST',
		url:'usuarios/FrmEditarUsuario.php',
		data:'curUser='+curUser+'&userToEdit='+userToEdit+'&vista='+vista+'&openFrom=allUsers',
		beforeSend: beforeSendImg(),
		success:function(data){
				$('#contenido').html(data);
				//$('#ingresaPass').hide();
				$('#cancelarFrmEdit').click(function(){allUsers()});
				$('input[name=oldPass]').keyup(function(){ingresarPass()});
				$('#FrmUpdateUser').submit(function(){updateUser();return false});
			}
	});
}

function updateUser(){
	pass1=$('input[name=newPass]').val();
	pass2=$('input[name=confirNewPass]').val();
	estado=$('select[name=estado]').val();
	
	if($('#ingresaPass').text()=='OK!!!'){
		if(pass1==pass2){		
			formData= new FormData(document.getElementById('FrmUpdateUser'));
			if(estado=='inactivo'){
				if(confirm('Va a colocar a este usuario como inactivo, este proceso es irreversible')){
					$.ajax({
						type:'POST',
						url:'usuarios/UsuarioDominio.php',
						data:formData,
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: beforeSendImg(),
						success:function(data){$('#contenido').html(data);}
					});
				}
			}
			else{
				$.ajax({
						type:'POST',
						url:'usuarios/UsuarioDominio.php',
						data:formData,
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: beforeSendImg(),
						success:function(data){$('#contenido').html(data);}
					});
			}
		}
		else alert('Los Password deben conincidir');
	}
	else alert('El pass Actual no es correcto');
}
//**************************************************************************REGISTRAR NUEVO ADMINISTRADOR*/	
function guardarNuevoAdministrador(){
	
	if($('#verificausuario').text()!='Disponible')
		alert('Lo sentimos pero el nombre de usuario que intenta registrar no esta disponible');
	else{			
		//alert('los datos se enviarion');
		$.ajax({
			type:'POST',
			url:'usuarios/UsuarioDominio.php',
			data: $('#FrmNewAdmin').serialize()+'&opcion=insertAdmin',			
			beforeSend: beforeSendImg(),
			success:function(data){$('#contenido').html(data);}
		});
	}
}
function openFrmContrato(){
	$.ajax({
			type:"POST",
			url:'contratos/FrmNuevoContrato.php',
			data:'opcion=frmNuevoContrato',
			beforeSend: beforeSendImg(),
			success: function(data){					
					$('#contenido').html(data);
					//tinyMceInit();
					$('#FrmNuevoContrato').submit(function(){guardarNuevoContrato();return false});
					$('#cancelarFrmNuevoContrato').click(function(){location.reload();});
					
					}
		});
}
function guardarNuevoContrato(){
	$.ajax({
		type:'POST',
		url:'contratos/ContratoDominio.php',
		data: $('#FrmNuevoContrato').serialize()+'&opcion=insertContrato',			
		beforeSend: beforeSendImg(),
		success:function(data){
			$('#contenido').html(data);
		}
	});
}
/*---------------------------------------------------------------------------REGISTRAR NUEVO USUARIO*/
function allUsers(){
	$.ajax({
			type:"POST",
			url:'usuarios/VistaUsuario.php',
			beforeSend: beforeSendImg(),
			success: function(data){
					$('#contenido').html(data);					
					}
		});
}
function certificarUsuarios(){
	vista=$('#usuarioActual').text();
		$.ajax({
			type: "POST",
			url: 'usuarios/VistaMisInvitados.php',
			data: 'vista='+$('#usuarioActual').text()+"&openFrom=revisar", 
			beforeSend: beforeSendImg(),
			success: function(data){
				$("#contenido").html(data);				
				}			
         });
}
function openBeneficioPorUsuario(){
	usuario=$('#usuarioActual').text();
		$.ajax({
			type: "POST",
			url: 'usuarios/BeneficiosPorUsuario.php',
			data: 'usuario='+usuario,
			beforeSend: beforeSendImg(),
			success: function(data){
				$("#contenido").html(data);				
				$('#linkFrmNuevoUsuario').click(function(){openFrmNuevoUsuario();});				
			},
			
         });
}
function guardarNuevoUsuario(){
	
	if($('#verificausuario').text()!='Disponible')
		alert('Lo sentimos pero el nombre de usuario que intenta registrar no esta disponible');
	else{
		if($('input[name=aceptoTerminos]').prop('checked')){
			formData = new FormData(document.getElementById('frmNuevoUsuario'));
			$.ajax({
				type: "POST",
				url: 'usuarios/UsuarioDominio.php',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: beforeSendImg(),
				success: function(data){$("#contenido").html(data);},			
			});
		}
		else{
			$('#error').html("Tienes que aceptar los terminos y condiciones de uso");
		}
	}
	/*if($('#verificaCi').text()!='Ok')
	alert('El C.I. con el que intenta registrar a su invitado ya esta en el sistema y no puede repetirse');
	else{
		
	}*/
	
}
function openTerminosDeUso(){
	$.ajax({
		type:'POST',
		url:'presentacion/TerminosDeUso.php',
		beforeSend: beforeSendImg(),
		success:function(data){
			$("#contenido").html(data);
			//openFrmNuevoUsuario();
		} 
	});
}
$(document).on('click','#verTerminos',function(e){
        e.preventDefault();
        //$("#verTerminos").click(function() { <!-- ------> al pulsar (.click) el boton 1 (#b1) -->
			$("#texto").dialog({ <!--  ------> muestra la ventana  -->
				width: 400,  <!-- -------------> ancho de la ventana -->
				height: 450,<!--  -------------> altura de la ventana -->
				show: "scale", <!-- -----------> animación de la ventana al aparecer -->
				hide: "scale", <!-- -----------> animación al cerrar la ventana -->
				resizable: "false", <!-- ------> fija o redimensionable si ponemos este valor a "true" -->
				position: "top",<!--  ------> posicion de la ventana en la pantalla (left, top, right...) -->
				modal: "true" <!-- ------------> si esta en true bloquea el contenido de la web mientras la ventana esta activa (muy elegante) -->
			});
		//});
});


function openFrmNuevoUsuario(){
	curUser=$('#usuarioActual').text();
   $.ajax({
           type: "POST",
           url: 'usuarios/FrmNuevoUsuario.php',           
		   beforeSend: beforeSendImg(),
		   data:"opcion=openFrmNuevoUsuario&curUser="+curUser,
		   //data: 'opcion=aceptarTerminosDeUso&usuario='+usuario,
		   success: function(data){   		

				$("#contenido").html(data);								
				//$('#ocultarTerminos').click(function(){$(this).replacewith("<a href='javascript: void()' id='verTerminos'>Ver los terminos</a>")});
				$('#frmNuevoUsuario').submit(function(){guardarNuevoUsuario();return false});
				$('input[name=password]').keyup(function(){checkLevelSecurity()});
				$('input[name=cpassword]').keyup(function(){checkRepeatPass()});
				$('input[name=usuario]').blur(function(){checkUser($(this).val())});					
				$('input[name=usuario]').focus(function(){$("#verificausuario").text('')});
				//$('input[name=ci]').blur(function(){checkCi($(this).val())});
				//$('input[name=ci]').focus(function(){$("#verificaCi").text('')});
				$('#cancelarFrmNuevoUsuario').click(function(){openBeneficioPorUsuario()});
				$("textarea").keyup(function(){limitarCaracteres('direccion')});
				

			}   
         });
}
function error(){	
	$('#contenido').html("<img style='margin-top:25%' width='100px' height='auto' src='images/errorsenal.png'>");		
}
function beforeSendImg(){
	$('#contenido').html("<img style='margin-top:25%' src='images/anim.gif'>");
}
//------------------------------------------------------------------FUNCIONES DE BANNER
function marcarDesmarcar(id,ver){
	$.ajax({
			type:"POST",
			url:'presentacion/BannerDominio.php',
			data: "idBanner="+id+"&verBanner="+ver+"&opcion=actualizarBanner"
		});
}
function guardarBanner(){
	
	var formData = new FormData(document.getElementById('FrmBanner'));
	$.ajax({
		type: "POST",
		url: 'presentacion/BannerDominio.php',
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: beforeSendImg(),
		success: function(data){$("#contenido").html(data)}		   
	});
	
}
/*---------------------------------------------------------------------------FUNCIONES DE MENSAJE*/
$(document).on('click','#vu-send-msg',function(e){
        e.preventDefault();
        //alert($(this).data('id'));
        id=$(this).data('id');
        openFrmSendMessage(id,'vistaUsuarios');
    });
$(document).on('click','#va-send-msg',function(e){
        e.preventDefault();
        //alert($(this).data('id'));
        id=$(this).data('id');
        openFrmSendMessage(id,'vistaArticulos');
    });
function openFrmSendMessage(id,openFrom){
	$.ajax({
			type: "POST",
			url: 'mensajes/FrmNuevoMensaje.php',
			data: 'id='+id+'&openFrom='+openFrom, 
			beforeSend: beforeSendImg(),
			success: function(data){
						
        				
						$("#contenido").html(data);
						$('#FrmNuevoMensaje').submit(function(){sendMessage();return false});
						$("textarea").keyup(function(){limitarCaracteres('mensaje')});
						if(openFrom=='vistaArticulos'){
							var view=$('input[name=categoria]').val();
							$('#cancelarEnvioMensajeSobreArticulo').click(function(){abrirVistaArticulo(view);});
						}
						else
							$('#cancelarEnvioMensajeVistaUsuarios').click(function(){allUsers()});
					}			
         });
	
}
function responderMensaje(){
	$('#divFrmRespuesta').fadeToggle();
}
function atras(){
	tipo=$('input[name=tipo]').val();
	vista=$('#usuarioActual').text();
	pagAct=$('input[name=pagAct]').val();	
	$.ajax({
		type:'POST',
		url:'mensajes/VistaMisMensajes.php',
		data:'pag='+pagAct+'&vista='+vista+'&tipo='+tipo,
		beforeSend:beforeSendImg(),
		success:function(data){
					$('#contenido').html(data);					
				}
	});
	
}
function leerMensaje(idMensaje,tipo){
	pagAct=$('#pagAct').text();	
	$.ajax({
		type:'POST',
		url:'mensajes/FrmLeerMensaje.php',		
		data:'pagAct='+pagAct+'&idMensaje='+idMensaje+'&tipo='+tipo,
		beforeSend:beforeSendImg(),		
		success:function(data){
					$('#contenido').html(data);
					$('#divFrmRespuesta').hide();
					$('#atras').click(function(){atras()});
					$('#FrmResponderMensaje').submit(function(){sendMessage();return false});
					$('textarea').keyup(function(){limitarCaracteres('mensaje')});
				}		
	});
}
function borrarMensaje(idMensaje,pag,vista,tipo){
	//alert(pag);
	if(confirm('Borrar mensaje?')){
		$.ajax({
				type: "POST",
				url: 'mensajes/MensajeDominio.php',
				data: 'idMensaje='+idMensaje+'&opcion=borrarMensaje&pag='+pag+'&vista='+vista+'&tipo='+tipo,
				beforeSend: beforeSendImg(),
				success: function(data){
							$("#contenido").html(data);
						}			
	         });
	}
}
function msgRead(idMensaje,pag,vista){
	//alert(pag);
	$.ajax({
			type: "POST",
			url: 'mensajes/MensajeDominio.php',
			data: 'idMensaje='+idMensaje+'&opcion=updateMensaje&pag='+pag+'&vista='+vista,
			beforeSend: beforeSendImg(),
			success: function(data){
						$("#contenido").html(data);						
					}			
         });
}
function sendMessage(){
	sendFrom=$('#idUsuarioActual').text();
	sendTo=$('#sendTo').val();	
	asunto=$('#asunto').text();
	if(asunto=='') asunto= $('input[name=asunto]').val();
	mensaje=$('textarea[name=mensaje]').val();	
	//alert(sendFrom+' '+sendTo+' '+mensaje+' '+asunto);
	$.ajax({
			type: "POST",
			url: 'mensajes/MensajeDominio.php',
			data: 'sendFrom='+sendFrom+'&sendTo='+sendTo+'&asunto='+asunto+'&mensaje='+mensaje+'&opcion=insertMensaje',
			beforeSend: beforeSendImg(),
			success: function(data){
						$("#contenido").html(data);						
					}			
         });
}
//*****************************************************************FUNCIONES DE CONSULTAS*/

function guardarNuevaConsulta(){
	
	sendFrom=$('#usuarioActual').text();
	//alert(sendFrom);
	$.ajax({
		type: "POST",
		url: 'mensajes/mensajeDominio.php',
		data: $('#FrmNuevaConsulta').serialize()+'&sendFrom='+sendFrom+'&opcion=guardarNuevaConsulta',
		beforeSend: beforeSendImg(),
		success: function(data){$("#contenido").html(data);}		
	});
}
//*****************************************************************FUNCIONES DE BACKUPS*/
/*function crearbackup(opcion){
	//alert('se creo e');
		$.ajax({
           type: "POST",
           url: 'backup.php',
           data: 'opcion='+, 
           success: function(data)
           {
               $("#contenido").html(data); 
           }
         });
}*/
function backups(opcion){
	file=$('input[name=filename]').val();
	fecha=$('input[name=fecha]').val();
	hora=$('input[name=hora]').val();	
   if(opcion=='restaurar'){
		if(confirm('Esta seguro que desea restaurar la base de datos?')){
			$.ajax({
			   type: "POST",
			   url: 'backup.php',
			   data: 'filename='+file+"&fecha="+fecha+"&hora="+hora+'&opcion='+opcion, 
			   beforeSend: beforeSendImg(),
			   success: function(data)
			   {
				   $("#contenido").html(data); 
			   }
			});
		}
	}
	else{
		$.ajax({
		   type: "POST",
		   url: 'backup.php',
		   data: 'filename='+file+"&fecha="+fecha+"&hora="+hora+'&opcion='+opcion, 
		   beforeSend: beforeSendImg(),
		   success: function(data)
		   {
			   $("#contenido").html(data); 
		   }
		});
	}
}
function downloadBackUps(){
	file=$('input[name=filename]').val();
	$.ajax({
			type:'GET',
			url:'beforeDownload.php',
			data:'f=backups/'+file,
			success:function(data){$('#result').html(data)}
		});
}
//*****************************************************************FUNCIONES DE PAQUETES*/
function paqueteArticulos(idPaqueteArticulo,opcion){
	//alert(idPaqueteArticulo+" "+opcion);
	curUser=$('#usuarioActual').text();
	$.ajax({
		type: "POST",
		url:"articulos/PaqueteArticuloDominio.php",
		data:"idPaqueteArticulo="+idPaqueteArticulo+"&opcion="+opcion+"&curUser="+curUser,
		beforeSend: beforeSendImg(),
		success:function(data){
					$("#contenido").html(data);			
			}
	});
}
function paqueteUsuarios(idPaqueteUsuario,opcion){
	//alert(idPaqueteArticulo+" "+opcion);
	curUser=$('#usuarioActual').text();
	$.ajax({
		type: "POST",
		url:"usuarios/PaqueteUsuarioDominio.php",
		data:"idPaqueteUsuario="+idPaqueteUsuario+"&opcion="+opcion+"&curUser="+curUser,
		beforeSend: beforeSendImg(),
		success:function(data){
					$("#contenido").html(data);			
			}
	});
}
//****************************************************************MEU DE ARTICULOS
function abrirVistaArticulo(view){
	curUser=$('#usuarioActual').text();
		rolUsuario=$('#rolUsuario').text();
		switch(view){
			case 'Ofertas':vista='ofertas';break;
			case 'Recien Publicados':vista='recienPublicados';break;
			case 'Subastas':vista='subastas';break;
			default: vista=view;
		}
		$.ajax({
			type: "POST",
			url: 'articulos/VistaArticulo.php',
			data: 'vista='+vista+'&contadorDeVisitas=si&rolUsuario='+rolUsuario, 
			beforeSend: beforeSendImg(),
			success: function(data){
						$("#contenido").html(data);
						//$('#linkPublicarAki').click(function(){openFrmNuevoArticulo(vista,curUser)});
						$('#linkOfertar').click(function(){alert('')});
					}			
         });
}
//*****************************************************************LIMITAR CARACTERES PARA TEXTAREA*/

function limitarCaracteres(tipo){     
	switch(tipo){
		case 'mensaje': limit=200;break;
		case 'descripcion': limit=150;break;
		case 'direccion': limit=100;break;
	}
	
	$("textarea").prop("maxlength",limit);
	value = $("textarea").val();
	current = value.length;
	$(".maxlength").text(current+'/'+limit);        		
}
function abrirRespuesta(res){//***********************************MENU DERECHO DINAMICO/
	$('.respuesta'+res).slideToggle();
}
function abrirMenu(menu){
	$('.menu'+menu).slideToggle();
	for(i=1;i<8;i++){
		if(i!=menu)
		$('.menu'+i).slideUp();
	}	
}
$( document ).ready(function(){
//$(function(){
	for(i=1;i<8;i++){
		$('.menu'+i).hide();
	}
	//tinyMceInit();
//***************************************************************ENVIAR EMAIL*/
	$('#sendEmail').click(function(){
		$.ajax({
			type:'POST',
			url:'mail/AttachMailer.php',
			beforeSend: beforeSendImg(),
			success:function(data){$('#contenido').html(data)}
		});
	});
//*****************************************************************MENU NAVEGACION*/
	
	$('#linkInicio').click(function(){
		location.reload();
	});
	$('#linkPreguntasFrecuentes').click(function(){
		$.ajax({
			type: "POST",
			url: 'usuarios/PreguntasFrecuentes.php',
			data: 'opcion=imprimirPreguntas',
			beforeSend: beforeSendImg(),
			success: function(data){
				$('#contenido').html(data);				
				$('p').hide();
				$('a').click(function(){abrirRespuesta(res)});				
				}
         });
	});
	$('#linkConsultas').click(function(){

		$.ajax({
			type: "POST",
			url: 'consultas/FrmConsultas.php',
			data: 'opcion=imprimirForm',
			beforeSend: beforeSendImg(),
			success: function(data){
				
				$('#contenido').html(data);
				$('#FrmNuevaConsulta').submit(function(){guardarNuevaConsulta();return false});
				$('textarea').keyup(function(){limitarCaracteres('mensaje')});
				$('#cancelarFrmNuevaConsulta').click(function(){location.reload();});
				//tinyMceInit();
				}
         });
	});
	$('#linkCerrarSesion').click(function(){
		window.location.href='LogSalir.php';
	});
//*****************************************************************MENU ARTICULO Y ATENCION*/
	$('a.VistaArticulo').click(function(){
		abrirVistaArticulo($(this).text());		
	});
//*****************************************************************MENU CONDICIONES DE USO
	$('#btnAceptar').click(function(){
		usuario=$('#usuarioActual').text();
		$.ajax({
			type: "POST",
			url: 'usuarios/UsuarioDominio.php',
			data: 'opcion=aceptarTerminosDeUso&usuario='+usuario,
			beforeSend: beforeSendImg(),
			success: function(data){$('#terminosDeUso').html(data);}
         });
	});
	$('#btnCancelar').click(function(){
		window.location.href='LogSalir.php';
		
	});
//*****************************************************************MENU CUENTA VENCIDA
	$('#mensajeLeido').click(function(){
		usuario=$('#usuarioActual').text();
		//alert(usuario);
		$.ajax({
			type: "POST",
			url: 'usuarios/UsuarioDominio.php',
			data: 'opcion=updateMensajeLeido&usuario='+usuario,
			beforeSend: beforeSendImg(),
			success: function(data){$('#contenido').html(data);}
         });
	});
//*****************************************************************MENU OPCIONES*/	
	$('#linkMiCuenta').click(function(){
		curUser=$('#usuarioActual').text();
		$.ajax({
			type: "POST",
			url: 'usuarios/FrmEditarUsuario.php',
			data:'curUser='+curUser+'&openFrom=miPerfil',
			beforeSend: beforeSendImg(),
			success: function(data){
					$("#contenido").html(data);					
					$('input[name=oldPass]').keyup(function(){ingresarPass()});
					$('input[name=newPass]').keyup(function(){checkNewPass()});
					$('input[name=confirNewPass]').keyup(function(){confirmNewPass()});
					$('#FrmUpdateUser').submit(function(){updateUser();return false});
					$('textarea').keyup(function(){limitarCaracteres('direccion')});
					
					$('#cancelarFrmEditarUsuario').click(function(){location.reload();});
					}
			
         });
	});
	$('#linkBeneficiosPorUsuario').click(function(){
		openBeneficioPorUsuario();		
	});
	$('#linkMisPublicaciones').click(function(){
		openMisPublicaciones();		
	});	
	$('a.linkMisMensajes').click(function(){
		switch($(this).text()){
			case 'Mensajes recibidos':tipo='recibidos';break;
			case 'Mensajes enviados':tipo='enviados';break;
		}
		vista=$('#usuarioActual').text();
		$.ajax({
			type: "POST",
			url: 'mensajes/VistaMisMensajes.php',			
			data: 'tipo='+tipo+'&vista='+$('#usuarioActual').text(), 
			beforeSend: beforeSendImg(),
			success: function(data){$("#contenido").html(data);}
			
         });
	});	
	$('#linkMisInvitados').click(function(){
		
		vista=$('#usuarioActual').text();
		$.ajax({
			type: "POST",
			url: 'usuarios/VistaMisInvitados.php',
			data: 'vista='+$('#usuarioActual').text(), 
			beforeSend: beforeSendImg(),
			success: function(data){
				$("#contenido").html(data);				
				}			
         });
	});	
//*****************************************************************MENU ADMINISTRAR WEB*/
	$('#linkBanner').click(function(){
		$.ajax({
			type:"POST",
			url:'presentacion/VistaBanner.php',
			beforeSend: beforeSendImg(),
			success: function(data){
						$('#contenido').html(data);											
						$('#FrmBanner').submit(function(){guardarBanner(); return false});						
					}
		});
	});
	$('#linkCategorias').click(function(){
		$.ajax({
			type: "POST",
			url: 'articulos/VistaCategoria.php',
			beforeSend: beforeSendImg(),
			success: function(data){
					$("#contenido").html(data);
					$('#FrmNuevaCategoria').submit(function(){guardarCategoria();return false});
					// $('input[type=checkbox]').click(function(){actualizarCategoria()});
					}
			
         });		 
	});
	$('#linkUsuarios').click(function(){
		allUsers();		
	});
	$('#linkNuevoAdministrador').click(function(){
		$.ajax({
			type:"POST",
			url:'usuarios/FrmNewAdmin.php',
			data:'opcion=frmNewUser',
			beforeSend: beforeSendImg(),
			success: function(data){
					$('#contenido').html(data);
					$('input[name=password]').keyup(function(){checkLevelSecurity()});
					$('input[name=cpassword]').keyup(function(){checkRepeatPass()});
					$('input[name=usuario]').blur(function(){checkUser($(this).val())});					
					$('input[name=usuario]').focus(function(){$("#verificausuario").text('')});
					$('#FrmNewAdmin').submit(function(){guardarNuevoAdministrador();return false});
					$('#cancelarFrmNewAdmin').click(function(){location.reload();});
					}
		});
	});

	/*$('#linkNuevoContrato').click(function(){
		$.ajax({
			type:"POST",
			url:'contratos/FrmNuevoContrato.php',
			data:'opcion=frmNuevoContrato',
			beforeSend: beforeSendImg(),
			success: function(data){					
					$('#contenido').html(data);
					tinyMceInit();
					$('#FrmNuevoContrato').submit(function(){guardarNuevoContrato();return false});
					$('#cancelarFrmNuevoContrato').click(function(){location.reload();});
					
					}
		});
	});*/
//*****************************************************************MENU ESTADISTICAS*/	
	$('#linkIncrementoUsuarios').click(function(){
		$.ajax({
			type:"POST",
			url:'analisis/Graficos.php',
			data:'grafico=incrementoUsuarios',
			beforeSend: beforeSendImg(),
			success: function(data){
					$('#contenido').html(data);
					$('.grafico').hide();
					$('.anios').click(function(){
						anio=$(this).text();
						
						grafico=$('.grafico').text();
						
						cargar(anio,grafico);
					});
					}
		});
	});
	$('#linkIncrementoVentas').click(function(){
		$.ajax({
			type:"POST",
			url:'analisis/Graficos.php',
			data:'grafico=incrementoVentas',
			beforeSend: beforeSendImg(),
			success: function(data){
					$('#contenido').html(data);
					$('.grafico').hide();
					$('.anios').click(function(){
						anio=$(this).text();
						grafico=$('.grafico').text();						
						cargar(anio,grafico);
					});
					}
		});
	});
	$('#linkIncrementoVentasBs').click(function(){
		$.ajax({
			type:"POST",
			url:'analisis/Graficos.php',
			data:'grafico=incrementoVentasBs',
			beforeSend: beforeSendImg(),
			success: function(data){
					$('#contenido').html(data);
					$('.grafico').hide();
					$('.anios').click(function(){
						anio=$(this).text();
						grafico=$('.grafico').text();						
						cargar(anio,grafico);
					});
					}
		});
	});
//*****************************************************************MENU ADMINISTRAR PAQUETES*/
	$('#linkVistaPaquetesUsuario').click(function(){
		vista=$('#usuarioActual').text();
		$.ajax({
			type:"POST",			
			url:'usuarios/VistaPaquetesUsuario.php',
			data:'vista='+vista,
			beforeSend: beforeSendImg(),
			success: function(data){
					$('#contenido').html(data);					
					}
		});
	});
	$('#linkVistaPaquetesArticulo').click(function(){
		vista=$('#usuarioActual').text();
		$.ajax({
			type:"POST",			
			url:'articulos/VistaPaquetesArticulo.php',
			data:'vista='+vista,
			beforeSend: beforeSendImg(),
			success: function(data){
					$('#contenido').html(data);					
					}
		});
	});
//*****************************************************************MENU CERTIFICACIONES*/
	$('#linkCertificarArticulos').click(function(){
		certificarArticulos();		
	});
	$('#linkCertificarUsuarios').click(function(){
		certificarUsuarios();		
	});
//*****************************************************************MENU RESTAURAR SISTEMA*/
	$('#linkCrearBackUps').click(function(){
		vista=$('#usuarioActual').text();
		$.ajax({
			type: "POST",
			url: 'frmbackups.php',
			data: 'vista='+$('#usuarioActual').text()+"&openFrom=revisar", 
			beforeSend: beforeSendImg(),
			success: function(data){
				$("#contenido").html(data);				
				$('#crearBackUps').click(function(){backups('crear');});				
				}
         });
	});
	$('#linkRestaurarBackUps').click(function(){
		vista=$('#usuarioActual').text();		
		$.ajax({
			type: "POST",
			url: 'frmrestaurarbackup.php',
			data: 'vista='+$('#usuarioActual').text()+"&openFrom=revisar", 
			beforeSend: beforeSendImg(),
			success: function(data){
					$("#contenido").html(data);
					$('#restaurarBackUps').click(function(){backups('restaurar');});
					$('#descargar').click(function(){downloadBackUps()});
				}
         });
	});	
});
function tinyMceInit(){

	tinymce.init({
			selector: ".tinymce",
			plugins: [
		         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
		         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
		         "table contextmenu directionality emoticons paste textcolor",
		         "code"
		   ],
		   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
		   toolbar2: "| link unlink anchor | image media | forecolor backcolor  | print preview code",
		   image_advtab: true		   
		});

}