<?php
include_once(MAINPATH.'/DBManager.php');
class Banner extends DBManager
{

	private $banner;
	private $bannerArray;
	private $listaBanners;
	private $depositoImg;
	private $listaCountBanners;

	public function __construct()
	{
		parent::__construct();
		$this->banner = array();
		$this->bannerArray = isset($_POST['ckbox']) ? $_POST['ckbox'] : "";
		$this->listaBanners = array();
		$this->depositoImg = array();
		$this->listaCountBanners = array();
	}

	public function imprimirBanner($images, $toolTips)
	{
		$retornar = "<div id='banner' align='justify'>";

		if (!isset($_SESSION['autentica']) || $_SESSION['autentica'] != 'SIP')
		{
			$retornar .= "<img src='images/bannerindex.png' width='960px' height='360px'>";
		}
		else
		{
			$retornar .= self::wowSlider($images, $toolTips);
		}
		$retornar .= "</div>";

		return $retornar;
	}

	public function wowSlider($images, $toolTips)
	{

		$lista = self::getImgBanner('si');
		$depositoImg = self::getDepositoImg($_SESSION['usuarioactual']);
		$lenght = count($lista);
		if ($depositoImg[0]['depositoImg'] != '')
		{
			$img1 = "<li><img width='960px' height='360px' src='images/depositos/" . $depositoImg[0]['depositoImg'] . "' title='Mi Deposito'/></li>";
			$img2 = "<a title='Mi Deposito'><img src='images/depositos/" . $depositoImg[0]['depositoImg'] . "'/></a>";
			//$lista[$lenght]['img']=$depositoImg[0]['depositoImg'];
			//$lista[$lenght]['title']='Mi Deposito';
			//$lista[$lenght]['deposito']='si';
		}

		$slider = "<div id='wowslider-container1'>
					<div class='ws_images'>
						<ul>";
		for ($i = 0; $i < count($lista); $i++)
		{
			//if(!isset($lista[$i]['deposito']))
			$slider .= "<li><img width='960px' height='360px' src='" . $images . $lista[$i]['img'] . "' title='" . $lista[$i]['title'] . "'/></li>";
			//else
			//$slider.="<li><img width='960px' height='360px'
			// src='images/depositos/".$depositoImg[0]['depositoImg']."' title='Mi
			// Deposito'/></li>";
		}

		//$slider.=$img1;
		$slider .= "</ul>
					</div>
					<div class='ws_bullets'>
						<div>";
		for ($i = 0; $i < count($lista); $i++)
		{
			//if(!isset($lista[$i]['deposito']))
			$slider .= "<a title='" . $lista[$i]['title'] . "'><img src='" . $toolTips . $lista[$i]['img'] . "'/></a>";
			//else
			//	$slider.="<a title='Mi Deposito'><img width='128' height='48'
			// src='images/depositos/".$depositoImg[0]['depositoImg']."'/></a>";
		}
		//var_dump($lista);
		//$slider.="<a title='Mi Deposito'><img
		// src='images/depositos/".$depositoImg[0]['depositoImg']."'/></a>";
		$slider .= "	
						</div>
					</div>					
				</div>
				
				<script type='text/javascript' src='js/wowSlider/wowslider.js'></script>
				<script type='text/javascript' src='js/wowSlider/script.js'></script>";
		//printf($slider);
		/*<script type='text/javascript' src='engine1/wowslider.js'></script>
		 <script type='text/javascript' src='engine1/script.js'></script>*/
		return $slider;
	}

	public function getImgBanner($sw = 'todos')
	{

		switch($sw)
		{
			case 'si' :
				$query = "select * from banners where ver='si'";
				break;
			case 'no' :
				$query = "select * from banners where ver='no'";
				break;
			default :
				$query = "select * from banners";
		}
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
		{
			while ($reg = $result->fetch_assoc())
			{
				$this->banner[] = $reg;
			}
			return $this->banner;
		}

	}

	public function getDepositoImg($usuario)
	{

		$query = "select depositoImg from usuarios where usuario='$usuario'";
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
		{
			while ($reg = $result->fetch_assoc())
			{
				$this->depositoImg[] = $reg;
			}
			return $this->depositoImg;
		}

	}

	public function redimensionarImagen($ruta, $filename)
	{
		//Ruta de la original
		$extencion = substr(strrchr($filename, '.'), 1);
		$extencion = strtolower($extencion);

		$dir = $ruta . $filename;
		$rtOriginal = $dir;
		switch($extencion)
		{
			case 'jpg' :
				$original = imagecreatefromjpeg($rtOriginal);
				break;
			case 'jpeg' :
				$original = imagecreatefromjpeg($rtOriginal);
				break;
			case 'png' :
				$original = imagecreatefrompng($rtOriginal);
				break;
		}
		//Crear variable de imagen a partir de la original

		//Definir tamaño máximo y mínimo
		$ancho_final = 256;
		$alto_final = 96;

		//Recoger ancho y alto de la original
		list($ancho, $alto) = getimagesize($rtOriginal);

		$lienzo = imagecreate($ancho_final, $alto_final);

		//Copiar $original sobre la imagen que acabamos de crear en blanco ($tmp)
		imagecopyresampled($lienzo, $original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);

		//Limpiar memoria
		imagedestroy($original);

		//Definimos la calidad de la imagen final
		$cal = 90;

		//Se crea la imagen final en el directorio indicado
		//imagetruecolortopalette($lienzo, false, 255);
		switch($extencion)
		{
			case 'jpg' :
				imagejpeg($lienzo, "../images/banner/tooltips/" . $filename, $cal);
				break;
			case 'jpeg' :
				imagejpeg($lienzo, "../images/banner/tooltips/" . $filename, $cal);
				break;
			default :
				imagepng($lienzo, "../images/banner/tooltips/" . $filename, 9);
		}
	}

	public function guardarConfigBanner()
	{
		$success = 0;
		for ($i = 0; $i < count($bannerArray); $i++)
		{
			if (self::actualizarBanner($bannerArray[$i]) == true)
			{
				$success = $success + 1;
			}
		}
		if ($success == count($bannerArray))
			return count($bannerArray) . " imagen(es) seran mostradas en el Banner";
		else
			return "La peticion no se realizo completamente!!!";

	}

	public function actualizarBanners($idBanner, $verBanner)
	{

		if ($verBanner == 'si')
			$ver = 'no';
		else
			$ver = 'si';
		$query = "update banners set ver='$ver' where idbanner='$idBanner'";
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
			return true;

	}

	public function guardarBanner($title, $img)
	{

		$query = "insert into banners(img,title,ver) values('$img','$title','si')";
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
			return true;

	}

	public function getBanners($registrosAEmpezar = '', $registrosAMostrar = '')
	{

		$query = "select * from banners limit $registrosAEmpezar, $registrosAMostrar";
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
		{
			while ($reg = $result->fetch_assoc())
			{
				$this->listaBanners[] = $reg;
			}
			return $this->listaBanners;
		}

	}

	public function getCountBanners()
	{

		$query = "select * from banners";
		$result = $this->mySql->query($query);
		if (!$result)
			return false;
		else
		{
			while ($reg = $result->fetch_assoc())
			{
				$this->listaCountBanners[] = $reg;
			}
			return $this->listaCountBanners;
		}
	}

}
