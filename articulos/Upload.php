<?php
include_once('../articulos/ArticuloDominio.php');
class UpLoadImage{
	
	private $ruta;
	private $banner;
	
	public function __construct(){
		$categoria=$_POST['categoria'];
		$this->ruta="../images/".$categoria."/";
		//$this->banner=new Banner();
		
	}
	
	public function upLoad(){
		//comprobamos que sea una petición ajax
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{		 
			//obtenemos el archivo a subir
			$file = $_FILES['archivo']['name'];
			//$name=self::extraerNombre($file);
			
			
		 
			//comprobamos si existe un directorio para subir el archivo
			//si no es así, lo creamos
			if(!is_dir($this->ruta)) 
				mkdir($this->ruta, 0777);
			 
			//comprobamos si el archivo ha subido
			if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],$this->ruta.$file))
			{  
				//$this->banner->insertBanner($file,$name);
				//$this->banner->redimensionarImagen($this->ruta,$file);				
			   echo $file;//devolvemos el nombre del archivo para pintar la imagen
			}
		}	
		else{
			throw new Exception("Error Processing Request", 1);    
		}	
	}
	public function extraerNombre($file){		
		$i=0;		
		while(substr($file,$i,1)!='.'){
			$name.=substr($file,$i,1);			
			$i++;
		}
		$name;
		return $name;
	}
}
$uli=new UpLoadImage();
$uli->upLoad();