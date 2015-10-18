<?php
//function download_file($archivo, $downloadfilename = null) {
	$archivo=$_REQUEST['f'];
	if (file_exists($archivo)){
		echo"
			<script>
				window.location.href = 'download.php?f=".$archivo."';
			</script>
		";        
	}
	else{
		echo"
			<script>
				alert('El archivo que intenta descargar no existe');
				$(document).ready(function(){	
					
				$.ajax({
					type: 'GET',
					url: 'frmrestaurarbackup.php',					
					beforeSend: beforeSendImg(),
					success: function(data){
								$('#contenido').html(data);						
							}			
				 });
				 });
			</script>
		";
	}	

//}
/*
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$_REQUEST['f']);
readfile("backups/".$_REQUEST['f']); 
exit;*/