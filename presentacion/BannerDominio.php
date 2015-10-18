<?
include_once('Banner.php');

class BannerDominio{
	private $idBanner;
	private $verBanner;
	private $banner;
	private $titulo;
	private $img;
	private $imgTemp;
	private $ruta;
	private $opcion;
	
	public function __construct($sw=''){
	
		$this->idBanner=$_POST['idBanner'];
		$this->verBanner=$_POST['verBanner'];
		$this->banner=new Banner();
		$this->img=$_FILES['archivo']['name'];
		$this->imgTemp=$_FILES['archivo']['tmp_name'];
		$this->ruta="../images/banner/images/";
		$this->titulo=$_POST['titulo'];
		$this->opcion=$sw;
	}
	public function guardarBanner($titulo,$image){
	
		if($this->imgTemp!=''){
			$mTipo = self::extension($image);
			if ((strtolower($mTipo) != 'jpg') && (strtolower($mTipo) != 'png'))
				echo"<br><br><br><h1>La extencion .$mTipo no es imagen.Los archivos soportados son jpg, png y gif!!</h1>";
			else{
				$size = filesize($this->imgTemp);
				if($size < 307200){
					if(!is_dir($this->ruta))
						mkdir($this->ruta, 0777);
					if ($image && move_uploaded_file($this->imgTemp,$this->ruta.$image))
					{  	
						$this->banner->redimensionarImagen($this->ruta,$image);
						if($this->banner->guardarBanner($titulo,$image)==true)		
						echo'<br><br><br><h1>Nuevo Banner agregado exitosamente!!</h1>';
					
						else echo'<br><br><br><h1>No se pudo guardar!!</h1>';
					}
				}
				else echo "<br><br><br><h1>Tu archivo de imagen no debe superar los 300KB!!</h1>";		
			}
		}
		else
			echo'<br><br><br><h1>Debes agregar una imagen!!</h1>';		
	}
	
	public function extension($str) 
	{
			return end(explode(".", $str));
	}
	
	public function actualizarBanner($idBanner,$verBanner){
	
		$this->banner->actualizarBanners($idBanner,$verBanner);
		include_once('VistaBanner.php');	
	}
	public function main(){
		switch($this->opcion){
			case 'actualizarBanner':self::actualizarBanner($this->idBanner,$this->verBanner);break;
			case 'guardarBanner':self::guardarBanner($this->titulo,$this->img);break;
		}
	}
}
$bd=new BannerDominio($_POST['opcion']);
$bd->main();