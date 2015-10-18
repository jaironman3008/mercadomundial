<?php
	$archivo=$_REQUEST['f'];
	$downloadfilename = $downloadfilename !== null ? $downloadfilename : basename($archivo);
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename=' . $downloadfilename);
//		header('Content-Disposition: attachment; filename='.$_REQUEST['f']);
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . filesize($archivo));
	ob_clean();
	flush();
	readfile($archivo);
	exit;