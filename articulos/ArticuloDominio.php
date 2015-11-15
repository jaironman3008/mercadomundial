<?php
include_once('Articulo.php');
include_once('PaqueteArticuloDominio.php');
@include_once('../mensajes/MensajeDominio.php');

class ArticuloDominio{
	
	private $articulo;
	private $articulo2;
	private $paqueteArticuloDominio;
	private $paqueteArticuloDominio2;
	private $mensaje;
	private $curUser;
	private $opcion;
	private $descripcion;
	private $idcategoria;
	private $precio;
	private $idusuario;
	private $estado;
	private $ubicacion;
	private $moneda;
	private $oferta;
	private $img;
	private $imgTemp;
	private $subasta;
	private $idArticulo;
	private $ruta;
	private $idArticuloRevisado;
	private $respuestaRevision;
	private $sugerenciaRevision;
	
	public function __construct($sw=''){
	
		$this->articulo=new Articulo();
		$this->articulo2=new Articulo();
		$this->paqueteArticuloDominio = new PaqueteArticuloDominio();
		$this->paqueteArticuloDominio2 = new PaqueteArticuloDominio();
		$this->mensaje=new Mensaje();
		$this->curUser=isset($_POST['curUser'])?$_POST['curUser']:"";
		$this->opcion=$sw;
		$this->descripcion=isset($_POST['descripcion'])?$_POST['descripcion']:"";
		$this->categoria=isset($_POST['categoria'])?$_POST['categoria']:"";
		$this->precio=isset($_POST['precio'])?$_POST['precio']:"";
		$this->usuario=isset($_POST['usuario'])?$_POST['usuario']:"";
		$this->estado=isset($_POST['estado'])?$_POST['estado']:"";
		$this->ubicacion=isset($_POST['ubicacion'])?$_POST['ubicacion']:"";
		$this->moneda=isset($_POST['moneda'])?$_POST['moneda']:"";
		$this->oferta=isset($_POST['oferta'])?$_POST['oferta']:"";
		$this->subasta=isset($_POST['subastar'])?$_POST['subastar']:"";
		$this->img=isset($_FILES['archivo']['name'])?$_FILES['archivo']['name']:"";
		$this->imgTemp=isset($_FILES['archivo']['tmp_name'])?$_FILES['archivo']['tmp_name']:"";
		$this->idArticulo=isset($_POST['idArticulo'])?$_POST['idArticulo']:"";
		$this->idArticuloRevisado=isset($_POST['idArticuloRevisado'])?$_POST['idArticuloRevisado']:"";
		$this->respuestaRevision=isset($_POST['respuestaRevision'])?$_POST['respuestaRevision']:"";
		$this->sugerenciaRevision=isset($_POST['sugerenciaRevision'])?$_POST['sugerenciaRevision']:"";
		$this->ruta="../images/".$this->categoria."/";
		
	}
	
	public function insertArticulo($descripcion,$categoria,$precio,$image,$usuario,$estado,$ubicacion,$moneda){		
		if($this->imgTemp!=''){
				$mTipo = self::extension($image);
				if ((strtolower($mTipo) != 'jpg') && (strtolower($mTipo) != 'png') && (strtolower($mTipo) != 'gif') && (strtolower($mTipo) != 'jpeg') && (strtolower($mTipo) != 'bmp')&& (strtolower($mTipo) != 'tiff'))
				echo"<br><br><br><h1>La extencion .$mTipo no es imagen.Los archivos soportados son jpg, png, bmp, tiff y gif!!</h1>";
				else{
					if(!is_dir($this->ruta))
						mkdir($this->ruta, 0777);
					$idArticulo=(self::getMaxIdArticulo())+1;
					if ($image && move_uploaded_file($this->imgTemp,$this->ruta.$idArticulo."_".$image)){
						if($this->articulo->insertArticulo($descripcion,$categoria,$precio,$idArticulo."_".$image,$usuario,$estado,$ubicacion,$moneda)==true){			
							$idArticulo=$this->articulo2->getMaxIdArticulo();//estoy buscando al usuario*/*/*/*/*/*/*/						
							$idPaqueteArticulo=$this->paqueteArticuloDominio->obtenerPaqueteArticulo();

						
							if($this->paqueteArticuloDominio2->insertDetallePaqueteArticulos($idPaqueteArticulo,$idArticulo[0]['idart'])==true){
								$mensaje="<p>Estimado usuario, su publicacion pasara por un proceso de revision que tardará un maximo de
										24 horas, si se llega a encontrar irregularidades en los datos ingresado su publicacion no sera 
										dado de alta.<br>Atentamente<br>La Administracion</p>";
							}
							echo"<h1>Articulo Guardado!!</h1><br>$mensaje";
						}					
						else echo'<br><br><br><h1>No se pudo guardar!!</h1>';
					}
					else{
						echo"<br><br><br><h1>La imagen no se pudo subir, por lo tanto no se ingreso ningun dato del aticulo!!</h1>";	
					}
				}
			}
		else{
			if($this->articulo->insertArticulo($descripcion,$categoria,$precio,'',$usuario,$estado,$ubicacion,$moneda)==true){			
							$idArticulo=$this->articulo2->getMaxIdArticulo();//estoy buscando al usuario*/*/*/*/*/*/*/						
							$idPaqueteArticulo=$this->paqueteArticuloDominio->obtenerPaqueteArticulo();

						
							if($this->paqueteArticuloDominio2->insertDetallePaqueteArticulos($idPaqueteArticulo,$idArticulo[0]['idart'])==true){
								$mensaje="<p>Estimado usuario, su publicacion pasara por un proceso de revision que tardará un maximo de
										24 horas, si se llega a encontrar irregularidades en los datos ingresado su publicacion no sera 
										dado de alta.<br>Atentamente<br>La Administracion</p>";
							}
							echo"<h1>Articulo Guardado!!</h1><br>$mensaje";
						}					
						else echo'<br><br><br><h1>No se pudo guardar!!</h1>';
		}

	}
	
	public function getArticuloFromId($id){
		$articulo=$this->articulo->getArticuloFromId($id);
		return $articulo;
		
	}
	
	public function getId($usuario){
		return $this->articulo->getId($usuario);
	}
	public function getMaxIdArticulo(){
		$id=$this->articulo->getMaxIdArticulo();
		$idArticulo=$id[0]['idart'];
		return $idArticulo;
	}
	public function departamentos(){
		return $this->articulo->departamentos();
	}
	public function getMonedas(){
		return $this->articulo->getMonedas();
	}
	public function getCountMisArticulos($usuario){
		$idUsuario=self::getId($usuario);
		return $this->articulo->getCountMisArticulos($idUsuario[0]['idusuario']);
	}
	public function actualizarArticulo($descripcion,$precio,$oferta,$image,$estado,$subasta,$idArticulo){
		$lista=self::getArticuloFromId($idArticulo);
		$fechaVenta='';
		$horaVenta='';
		if($estado=='vendido'){
			$fechaVenta=date('Y-m-d');
			$horaVenta=date('H:i:s');
		}		
		if($this->imgTemp!=''){
			$mTipo = self::extension($image);
			if ((strtolower($mTipo) != 'jpg') && (strtolower($mTipo) != 'png') && (strtolower($mTipo) != 'gif') && (strtolower($mTipo) != 'jpeg') && (strtolower($mTipo) != 'bmp')&& (strtolower($mTipo) != 'tiff'))
				echo"<br><br><br><h1>La extencion .$mTipo no es imagen.Los archivos soportados son jpg, png, bmp, tiff y gif!!</h1>";
			else{
					if(!is_dir($this->ruta))
						mkdir($this->ruta, 0777);
					if ($image && move_uploaded_file($this->imgTemp,$this->ruta.$idArticulo."_".$image)){  	
						if($this->articulo->actualizarArticulo($descripcion,$precio,$oferta,$idArticulo."_".$image,$estado,$subasta,$idArticulo,$fechaVenta,$horaVenta)==true)		
						echo'<br><br><br><h1>Articulo Editado!!</h1>';
					
						else echo'<br><br><br><h1>No se pudo editar!!</h1>';
					}
			}
		}
		else{
			if($this->articulo->actualizarArticulo($descripcion,$precio,$oferta,$lista[0]['img'],$estado,$subasta,$idArticulo,$fechaVenta,$horaVenta)==true)		
					echo'<br><br><br><h1>Articulo Editado!!</h1>';
				
					else echo'<br><br><br><h1>No se pudo editar!!</h1>';
		}
	}	
	public function extension($str) 
	{
		return end(explode(".", $str));
	}
	public function respuestaRevisarArticulo(){
		$sendFrom=$this->curUser;//usuario que hizo la revision
		$articulo=$this->articulo->getArticuloFromId($this->idArticuloRevisado);//buscando anfitrion
		$sendTo=$this->articulo2->getUsuario($articulo[0]['idusuario']);//anfritrion
		$asunto="SOLICITUD DE NUEVO ARTICULO";
		
		if($this->articulo->respuestaRevisarArticulo($this->respuestaRevision,$this->idArticuloRevisado)==true){//SI SE MODIFICO AL INVITADO
			if($this->respuestaRevision=='aceptado'){//SI LA MODIFICACION FUE POSITIVA	
				$mensaje="Estimado usuario le informamos que su intento de publicacion en fecha ".$articulo[0]['fechareg']." a horas ".$articulo[0]['horareg']." ha sido aceptada";
				if($this->mensaje->insertMensaje($sendFrom,$sendTo[0]['usuario'],$asunto,$mensaje)==true)//SI SE NOTIFICO AL ANFITRION
					$notificacion="<br><p>El usuario que publico este articulo ya ha sido notificado</p>";
				else$notificacion="<br><p>Ocurrio un error y no se pudo notificar al usuario que hizo la publicacion</p>";//SI FALLO LA NOTIFICACION AL ANFITRION
				
				echo"<br><br><br><h1>El articulo fue dado de alta Exitosamente!!</h1>".$notificacion;
				
			}
			else{//SI LA MODIFICACION FUE NEGATIVA
				$mensaje="Estimado usuario le informamos que su intento de publicacion en fecha ".$articulo[0]['fechareg']." a horas ".$articulo[0]['horareg']." ha sido rechazada";
				if($this->mensaje->insertMensaje($sendFrom,$sendTo[0]['usuario'],$asunto,$mensaje)==true)
					$notificacion="<br><p>El usuario que publico este articulo ya ha sido notificado</p>";
				else$notificacion="<br><p>Ocurrio un error y no se pudo notificar al usuario que hizo la publicacion</p>";	
					echo"<br><br><br><h1>Se denego correctamente la publicacion a este articulo!!</h1>".$notificacion;
			}
		}
		else//SI NO SE PUDO MODIFICAR AL INVITADO
			echo"<br><br><br><h1>Ocurrio un error..Intente de nuevo!!</h1>";
	}
	public function sugerenciaRevisionArticulo(){
		$sendFrom=$this->curUser;//usuario que hizo la revision
		$articulo=$this->articulo->getArticuloFromId($this->idArticuloRevisado);//buscando anfitrion
		$sendTo=$this->articulo2->getUsuario($articulo[0]['idusuario']);//anfritrion
		$asunto="SOLICITUD DE NUEVO ARTICULO";
		$mensaje=$this->sugerenciaRevision;
		if($this->mensaje->insertMensaje($sendFrom,$sendTo[0]['usuario'],$asunto,$mensaje)==true){
			echo"<h1>Se ha notificado al usuario que hizo la publicacion</h1>";
		}
		else{
			echo"<h1>Ocurrio un error...NO se pudo notificar, intente de nuevo</h1>";
		}
	}
	public function main(){
	
		switch($this->opcion){
			case 'insertArticulo': 
				self::insertArticulo($this->descripcion,$this->categoria,$this->precio,$this->img,$this->usuario,$this->estado,$this->ubicacion,$this->moneda);
				break;
			case 'actualizarArticulo':
				self::actualizarArticulo($this->descripcion,$this->precio,$this->oferta,$this->img,$this->estado,$this->subasta,$this->idArticulo);
				break;
			case 'respuestaRevisarArticulo':
				self::respuestaRevisarArticulo();
				break;
			case 'sugerenciaRevisionArticulo':
				self::sugerenciaRevisionArticulo();
				break;
		}
	}
}
$ad=new ArticuloDominio(isset($_POST['opcion'])?$_POST['opcion']:"");
$ad->main();