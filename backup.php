<?php
// session_start();
include_once('DBManager.php');
class Backup{
	
	private $opcion;
	private $observacion;
	private $numtablas;
	private $ckbox;
	private $filename;
	private $fecha;
	private $hora;
	private $tablas;
	private $listabackups;
	private $dbName;
	private $lastId;
	private $conectar;
		
	public function __construct($opc=''){
		
		$this->conectar = new Conectar();
		$this->dbName='dbtutienda';		
		$this->opcion=$opc;
		$this->observacion=$_POST['observacion'];
		$this->numtablas=$_POST['numtablas'];
		$this->ckbox=$_POST['ckbox'];
		$this->filename="backups/".$_POST['filename'];
		$this->fecha=$_POST['fecha'];
		$this->hora=$_POST['hora'];
		$this->lastId=array();
		$this->tablas=array();
		$this->listabackups=array();
	}
	public function ejecutarOpcion(){
	
		switch($this->opcion){
			case 'crear' : self::resumenCrearBackups($this->observacion,$this->numtablas,$this->ckbox);break;
			case 'restaurar': self::resumenRestaurarBackups($this->filename, $this->fecha,$this->hora);break;
		}
	
	}
	public function resumenCrearBackups($observacion,$numtablas,$ckbox){//ckbox no se recibe pero no se usa por que se cambia el valor al inicio de la funcion
		$ckbox=self::dbtablas();
		if(count($ckbox)==0)
		$resumen="<br><br><br><font class='hora'>Error!!! Debe incluir almenos una tabla</font>";
		else{
			for($i=0;$i<count($ckbox);$i++){
					if($i==(count($ckbox))-1)
					$tablas.=$ckbox[$i]['Tables_in_dbtutienda'];
					else
					$tablas.=$ckbox[$i]['Tables_in_dbtutienda'].",";
			}
			if(($numtablas-1)==count($ckbox)){		
				$detalle="Backups completo";
				}
			else{		
				$detalle=$tablas;
				}
			self::backupTables($tablas, $detalle, $this->observacion, 'backups');
			$id=self::maxId();
			//$this->conectar->insertbitacora('Creacion de Backup',$_SESSION['usuarioactual'],$id[0]['id']);
			
			$resumen="<h1>Resumen de Backups</h1>
			<p>El punto de restauracion se creo exitosamen, y en el se incluyeron ".count($ckbox)." tablas
				</p>";									
		}
		echo $resumen;
	}
	public function resumenRestaurarBackups($filename, $fecha, $hora){
		$resumen="<h1>Restauracion del sistema</h1>";
		if(self::restaurarbackups($filename)==true){	
			$mensaje="El sistema fue exitosamente restaurado.";			
		}
		else{
			$mensaje="<b>Ocurrio un error</b>, no se pudo restaurar. Intente de nuevo, si el problema persiste comuniquese 
			con el administrador";
		}
		$resumen.="
			<p>
				$mensaje<br>
				Punto de restauracion escogido:<br>
				<b>".$fecha."</b> a horas <b>".$hora."</b>
			</p>
		";
		echo $resumen;		
	}
	public function dbtablas(){
		if($this->conectar->con()==true){//aki colocar el nombre de la base de datos
			$query="show tables  where Tables_in_dbtutienda!='backups'";
			$result=mysql_query($query);
			if(!$result) return false;
			else{
				while($reg=mysql_fetch_assoc($result)){
					$this->tablas[]=$reg;
				}
				return $this->tablas;
			}
		}
	}
	public function getbackups(){
		if($this->conectar->con()==true){
				$query="select * from backups order by idbackup desc limit 1";
				$result=mysql_query($query);
				if(!$result) return false;
				else{
					while($reg=mysql_fetch_assoc($result)){
						$this->listabackups[]=$reg;
					}
					return $this->listabackups;
				}
		}	
	}
    public function backupTables($tables = '*',$detalle,$observacion, $outputDir = '.')
    {
		if($this->conectar->con()==true){
			try
			{          
				if($tables == '*')
				{
					$tables = array();
					$result = mysql_query('SHOW TABLES');
					while($row = mysql_fetch_row($result))
					{
						$tables[] = $row[0];
					}
				}
				else
				{
					$tables = is_array($tables) ? $tables : explode(',',$tables);
				}
	 
				$sql = 'CREATE DATABASE IF NOT EXISTS '.$this->dbName.";\n\n";
				$sql .= 'USE '.$this->dbName.";\n\n";
	 
				foreach($tables as $table)
				{
					"<font class='hora'>Backing up ".$table." table...</font>";
	 
					$result = mysql_query('SELECT * FROM '.$table);
					$numFields = mysql_num_fields($result);
	 
					$sql .= 'DROP TABLE IF EXISTS '.$table.';';
					$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
					$sql.= "\n\n".$row2[1].";\n\n";
					
					for ($i = 0; $i < $numFields; $i++)
					{
						while($row = mysql_fetch_row($result))
						{
							$sql .= 'INSERT INTO '.$table.' VALUES(';
							for($j=0; $j<$numFields; $j++)
							{
								$row[$j] = addslashes($row[$j]);
								$row[$j] = ereg_replace("\n","\\n",$row[$j]);
								if (isset($row[$j]))
								{
									$sql .= '"'.$row[$j].'"' ;
								}
								else
								{
									$sql.= '""';
								}
	 
								if ($j < ($numFields-1))
								{
									$sql .= ',';
								}
							} 
							$sql.= ");\n";
						}
					}
	 
					$sql.="\n\n\n"; 
					" <font>OK</font>" . "<br/>";
				}
			}
			catch (Exception $e)
			{
				var_dump($e->getMessage());
				return false;
			}
	 
			return $this->saveFile($sql,$detalle,$observacion, $outputDir);
		}
    }    
    protected function saveFile(&$sql,$detalle,$observacion, $outputDir = '.')
    {		
        if (!$sql) return false;
 
        try
        {
			$name=date("dmY-His", time()).'.sql';
            $handle = fopen($outputDir.'/'.$name,'w+');
            fwrite($handle, $sql);
            fclose($handle);
			$consulta="insert into backups(filename,fecha,hora,descripcion) value('$name',now(),now(),'$observacion')";
			$result=mysql_query($consulta);
        }
        catch (Exception $e)
        {
            var_dump($e->getMessage());
            return false;
        }
 
        return true;
    }		
	public function restaurarbackups($filename){	
		
		if($this->conectar->con()==true){
			// Temporary variable, used to store current query
			$templine = '';
			// Read in entire file
			
			$lines = file($filename);
			// Loop through each line
			foreach ($lines as $line)
			{
				// Skip it if it's a comment
				if (substr($line, 0, 2) == '--' || $line == '')
					continue;	 
				// Add this line to the current segment
				$templine .= $line;
				// If it has a semicolon at the end, it's the end of the query
				if (substr(trim($line), -1, 1) == ';')
				{
					// Perform the query
					$result=mysql_query($templine);// or print('Error ejecutando consulta \'<strong>' . $templine . '\': ' . mysql_error() . '<br/><br/>');
					if(!$result){
						$respuesta= false;
						break;
					}
					else $respuesta= true;
					// Reset temp variable to empty
					$templine = '';
				}
			}
			return $respuesta;
		}
	}
	public function maxId(){
		if($this->conectar->con()==true){
			$query="select max(idbackup) as id from backups";
			$result=mysql_query($query);
			if(!$result)
				return false;
			else{
				while($reg=mysql_fetch_assoc($result)){
					$this->lastId[]=$reg;
				}
				return $this->lastId;
			}
		}
	}
}
$bk= new Backup($_POST['opcion'],$db);
$bk->ejecutarOpcion();
?>