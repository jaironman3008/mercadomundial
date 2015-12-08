<?php
include_once(MAINPATH."/usuarios/Usuario.php");
class DominioManage
{
	protected $currentUser;
	
	public function __construct(){
		$this->session('userId');
		// $this->currentUser = get_c
	}
	
	protected function inputPost($postName = "")
	{
		if ($postName == "")
		{
			$response = $_POST;
		}
		else
		{
			$response = isset($_POST[$postName]) ? $_POST[$postName] : NULL;
		}
		return $response;
	}

	protected function session($variableSessionName = "")
	{
		if ($variableSessionName == "")
		{
			$response = $_SESSION;
		}
		else
		{
			$response = isset($_SESSION[$variableSessionName]) ? $_SESSION[$variableSessionName] : NULL;
		}
		return $response;
	}

	protected function setVariableSession($variableSessionName, $variableSessionValue)
	{
		if (!is_null($variableSessionName) && $variableSessionName != "")
		{
			$_SESSION[$variableSessionName] = $variableSessionValue;
		}
		else
		{
			exit('Session variable wrong setting in ' . get_called_class());
		}
	}

}
