<?php
include_once('usuarios/usercontrol.php');
include_once('presentacion/Banner.php');
include_once('presentacion/Navegador.php');
include_once('presentacion/Head.php');
include_once('presentacion/Contenido.php');

class Index{
	private $head;
	private $contenido;
	private $banner;
	private $srcImg1;
	private $srcImg2;
	private $userControl;
	private $view;
	
	public function __construct(){
		
		$this->head=new Head();
		$this->banner=new Banner();
		$this->navegador=new Navegador();		
		$this->contenido=new Contenido();
		$this->userControl=new UserControl();
		$this->srcImg1='images/banner/images/';
		$this->srcImg2='images/banner/tooltips/';
		$this->view=$vista;
		
	}
		
	public function main(){			
		if (isset($_POST['grabar']) and $_POST['grabar']=='si')
		{			
			$this->userControl->logueo();	
			
		}
		$retornar="<html>";
		$retornar.=$this->head->imprimirHead();
		$retornar.="<body>";
		$retornar.=$this->banner->imprimirBanner($this->srcImg1,$this->srcImg2);
		$retornar.=$this->navegador->imprimirNavegador();
		$retornar.="<div id='main'>";		
		$retornar.=$this->contenido->imprimirContenido();
		$retornar.="</div>";
		$retornar.="</body>";
		$retornar.="</html>";
		
		echo $retornar;
			
	}		
}
$index=new Index();
$index->main();