<?php
include_once(MAINPATH.'/DBManager.php');

class classVenta extends DBManager
{
	private $listadetalleventa;
	private $codventa;
	private $selectventa;
	private $misclientes;
	private $clienteyventa;
	private $listacomprador;
	private $detallecobro;
	private $max;
	private $total;
	private $selectventarever;
	private $listagarante;
	private $calcularprec;

	public function __construct()
	{
		$this->listadetalleventa = array();
		$this->codventa = array();
		$this->selectventa = array();
		$this->misclientes = array();
		$this->clienteyventa = array();
		$this->listacomprador = array();
		$this->detallecobro = array();
		$this->max = array();
		$this->total = '';
		$this->selectventarever = array();
		$this->listagarante = array();
		$this->calcularprec = '';
	}

	public function detalletemp($usuario)
	{
		if ($this->mySql == true)
		{

			$query = "select t.idproducto,g.idgrupo 
						from tablatemp t, productos p, grupos g
						where t.idproducto=p.idproducto and
						p.idgrupo=g.idgrupo and 
						t.vendedor='$usuario'";
			$result = $this->mySql->query($query);

			if (!$result)
				return false;
			else
			{

				while ($reg = $result->fetch_assoc())
				{

					$this->listadetalleventa[] = $reg;

				}
				return $this->listadetalleventa;
			}
		}
	}

	public function getidventa()
	{
		if ($this->mySql == true)
		{

			$query = "select max(idventa) as idvent from ventas";
			$result = $this->mySql->query($query);

			if (!$result)
				return false;
			else
			{

				while ($reg = $result->fetch_assoc())
				{

					$this->codventa[] = $reg;

				}
				return $this->codventa;
			}
		}
	}

	public function insertVenta($idcliente, $idusuario, $montoventa, $cuotamensual, $cuotainicial, $nrocuota, $fechainicio, $tipoventa, $idgarante, $estado)
	{
		if ($this->mySql == true)
		{

			$query = "INSERT INTO ventas(idcliente, idusuario, montodeventa,cuotamensual,cuotainicial,nrocuotas,fechainicial,fechaventa,horaventa,tipoventa,idgarante,estado) VALUES ('$idcliente','$idusuario','$montoventa','$cuotamensual','$cuotainicial','$nrocuota','$fechainicio',now(),now(),'$tipoventa','$idgarante','$estado')";
			$result = $this->mySql->query($query);

			if (!$result)
				return false;
			else
				return true;
		}
	}

	public function insertdetallventa($idventa, $idproducto, $idgrupo)
	{
		if ($this->mySql == true)
		{

			$query = "INSERT INTO detalleventa VALUES ('$idventa',$idproducto,'$idgrupo')";
			$result = $this->mySql->query($query);

			if (!$result)
				return false;
			else
				return true;
		}
	}

	public function insertcobros($idventa, $nrocuota, $fechavcto, $saldoinicial, $interesmensual, $amortizacion, $cuota, $saldofinal, $interesmora, $estado)
	{
		if ($this->mySql == true)
		{
			$query = "insert into cobros (idventa,nrocuota,fechavcto,saldoinicial,interesmensual,amortizacion,cuota,saldofinal,interesmora,estado) values ('$idventa','$nrocuota','$fechavcto','$saldoinicial','$interesmensual','$amortizacion','$cuota','$saldofinal','$interesmora','$estado')";
			$result = $this->mySql->query($query);
			if (!$result)
				return false;
			else
				return true;
		}
	}

	public function updatecobros($idcobro, $mora, $sw)
	{
		if ($this->mySql == true)
		{
			switch($sw)
			{
				case 'pagototal' :
					$query = "update cobros set estado='pagototal', fechapago=now() where idcobro='$idcobro'";
					break;
				default :
					$query = "update cobros set estado='cancelada', fechapago=now() where idcobro='$idcobro'";
					break;
			}

			$result = $this->mySql->query($query);
			if (!$result)
				return false;
			else
				return true;
		}
	}

	public function updateckboxsms($idcliente, $smstype, $smsstate)
	{
		if ($this->mySql == true)
		{
			$query = "update clientes set $smstype='$smsstate' where idcliente='$idcliente'";
			$result = $this->mySql->query($query);
			if (!$result)
				return false;
			else
				return true;
		}
	}

	public function updateventa($codigo, $sw, $obser)
	{
		if ($this->mySql == true)
		{
			switch($sw)
			{
				case '' :
					$query = "update ventas set estado='cancelada' where idventa='$codigo'";
					break;
				case 'sindeuda' :
					$query1 = "select sum(cuota+interesmora) as total
									from cobros 
									where estado='cancelada' and
									idventa=$codigo";
					$query2 = "select saldoinicial+ sum(interesmora)
									from cobros 
									where estado='pagototal' and
									idventa=$codigo group by idventa";
					$query3 = "select cuotainicial from ventas where idventa='$codigo'";

					$result1 = $this->mySql->query($query1);
					$t1 = mysql_result($result1, 0);
					$result2 = @$this->mySql->query($query2);
					$t2 = mysql_result($result2, 0);
					$result3 = $this->mySql->query($query3);
					$t3 = mysql_result($result3, 0);
					$res = $t1 + $t2 + $t3;
					$query = "update ventas set estado='cancelada', montodeventa='$res' where idventa='$codigo'";
					break;
				case 'enproceso' :
					$query = "update ventas set estado='en proceso' where idventa='$codigo'";
					break;
				case 'enmora' :
					$query = "update ventas set estado='pendiente' where idventa='$codigo'";
					break;
				case 'revertido' :
					$query1 = "update ventas set estado='revertido', observacion='$obser' where idventa='$codigo'";
					$query2 = "update productos p set estado='recuperado' 
											where idproducto in(
												select p.idproducto from detalleventa dv, ventas v
												where p.idproducto=dv.idproducto and
													dv.idventa=v.idventa and
													v.idventa='$codigo'
											)";
					$query3 = "update cobros set estado='congelado' where idventa='$codigo' and estado='pendiente'";
					break;
				case 'reventa' :
					$query = "update ventas set estado='cancelada', observacion='complemento de la venta $obser' where idventa='$codigo'";
					break;
			}
			if ($sw == 'revertido')
			{
				$result1 = $this->mySql->query($query1);
				$result2 = $this->mySql->query($query2);
				$result3 = $this->mySql->query($query3);
				if (!$result1 || !$result2 || !$result3)
					return false;
				else
					return true;
			}
			else
			{
				$result = $this->mySql->query($query);
				if (!$result)
					return false;
				else
					return true;
			}
		}
	}

	public function selectventarevertida($idproducto)
	{
		if ($this->mySql == true)
		{
			$consulta = "select v.idventa 
						from ventas v, detalleventa dv, productos p
						where v.idventa=dv.idventa and
						dv.idproducto=p.idproducto and
						p.idproducto='$idproducto' and
						v.estado='revertido'";
			$result = $this->mySql->query($consulta);

			if (!$result)
				return false;
			else
			{
				while ($res = $result->fetch_assoc())
				{
					$this->selectventarever[] = $res;
				}
				return $this->selectventarever;
			}
		}
	}

	public function selectventa($codigo)
	{
		if ($this->mySql == true)
		{
			$consulta = "select v.idventa,fecha_registro,hora_registro, c.idcliente,c.nombre, c.appaterno, c.apmaterno, tc.tipo,c.ci,c.expedido_en,c.fecha_nacimiento,c.zona,c.direccion,c.telefonocel,c.telefonofij,c.profesion,c.ocupacion,c.lugar_trabajo,c.ingreso_mensual,c.email,u.usuario,v.montodeventa, v.cuotamensual, v.cuotainicial, v.nrocuotas, v.fechaventa, v.tipoventa 
						from ventas v, clientes c, usuarios u, tipo_cliente tc
						where
						v.idusuario=u.idusuario and
						v.idcliente=c.idcliente and
						c.idtipo_cliente=tc.idtipo_cliente and
						v.idventa='$codigo'";
			$res = $this->mySql->query($consulta);
			if (!$res)
				return false;
			else
			{
				while ($reg = $res->fetch_assoc())
				{
					$this->listacomprador[] = $reg;
				}
				return $this->listacomprador;
			}
		}
	}

	public function selectgarante($ci)
	{
		if ($this->mySql == true)
		{
			$consulta = "select * from garantes g
						where
						g.ci='$ci'";
			$res = $this->mySql->query($consulta);
			if (!$res)
				return false;
			else
			{
				while ($reg = $res->fetch_assoc())
				{
					$this->listagarante[] = $reg;
				}
				return $this->listagarante;
			}
		}
	}

	public function detallecobro($idcobro1, $idcobro2)
	{
		if ($this->mySql == true)
		{
			$consulta = "select sum(cuota) as detallerecibo from cobros/*cuota*/
						where idcobro>=$idcobro1 and
						idcobro<=$idcobro2  
						union
						select  sum(interesmora) as mora  from cobros/*mora*/
						where idcobro>=$idcobro1 and
						idcobro<=$idcobro2 
						union
						select fechavcto  from cobros/*fechavcto*/
						where idcobro=$idcobro1
						union
						select nrocuota  from cobros/*nrocuota*/
						where idcobro>=$idcobro1 and
						idcobro<=$idcobro2
						union
						select saldoinicial from cobros/*saldo*/
						where idcobro=$idcobro2+1
						union
						select fechavcto as sgtefecha from cobros/*sgtefecha*/
						where idcobro=$idcobro2+1";
			$res = $this->mySql->query($consulta);
			if (!$res)
				return false;
			else
			{
				while ($reg = $res->fetch_assoc())
				{
					$this->detallecobro[] = $reg;
				}
				return $this->detallecobro;
			}
		}
	}

	public function insertrecibo($idventa, $detalle, $nrocuotas, $mora, $cuota)
	{
		if ($this->mySql == true)
		{

			$query = "INSERT INTO recibos(idventa,detalle,nrocuotas,mora,cuota,hora,fecha) VALUES('$idventa','$detalle','$nrocuotas','$mora','$cuota',now(),now())";
			$result = $this->mySql->query($query);

			if (!$result)
				return false;
			else
				return true;
		}
	}

	public function insertgarante($nombre, $appaterno, $apmaterno, $cig, $expedido_en, $telefonocelg, $telefonofijg, $lugardetrabajog, $ingresomensualg)
	{
		if ($this->mySql == true)
		{

			$query = "INSERT INTO garantes(nombre,appaterno,apmaterno,ci,expedido_en,telefonocel,telefonofij,lugardetrabajo,ingresomensual,fechareg,horareg) VALUES('$nombre','$appaterno','$apmaterno','$cig','$expedido_en','$telefonocelg','$telefonofijg','$lugardetrabajog','$ingresomensualg',now(),now())";
			$result = $this->mySql->query($query);

			if (!$result)
				return false;
			else
				return true;
		}
	}

	public function selectMaxid($sw)
	{
		if ($this->mySql == true)
		{
			switch($sw)
			{
				case 'recibo' :
					$query = "select max(idrecibo) as maxidrecibo from recibos";
					break;
				case 'venta' :
					$query = "select max(idventa) as idvent from ventas";
					break;
				case 'garante' :
					$query = "select max(idgarante) as maxidgarante from garantes";
					break;
			}
			$result = $this->mySql->query($query);

			if (!$result)
				return false;
			else
			{
				while ($reg = @$result->fetch_assoc())
				{
					$this->max[] = $reg;
				}
				return $this->max;
			}

		}
	}

	public function selectMax($sw)
	{
		if ($this->mySql == true)
		{
			switch($sw)
			{
				case 'recibo' :
					$query = "select max(idrecibo) as maxidrecibo from recibos";
					break;
				case 'venta' :
					$query = "select max(idventa) as idvent from ventas";
					break;
				case 'garante' :
					$query = "select max(idgarante) as maxidgarante from garantes";
					break;
			}
			$result = $this->mySql->query($query);

			if (!$result)
				return false;
			else
			{
				while ($reg = @$result->fetch_assoc())
				{
					$this->max[] = $reg;
				}
				return $this->max;
			}
		}
	}

	public function misclientes($usuario, $from, $desde, $hasta)
	{
		if ($this->mySql == true)
		{
			$swuser = "and usuario='$usuario'";
			$rangofecha = "v.fechaventa>='$desde' and v.fechaventa<='$hasta' and";
			if ($usuario == '')
				$swuser = '';
			if ($desde == '' || $hasta == '')
				$rangofecha = '';

			switch($from)
			{
				case 'todos' :
					$query = "select v.idventa,c.idcliente,c.nombre,c.appaterno,c.apmaterno, c.ci,c.telefonocel,c.smspromocion,c.smsmora,c.smscredito, count(idventa) as nventas,u.nombre as nameuser,u.appaterno as appuser,u.apmaterno as apmuser
										from clientes c, ventas v, usuarios u
										where c.idcliente=v.idcliente and
										v.idusuario=u.idusuario $swuser group by c.nombre";
					break;
				case 'casimora' :
					$query = "select v.idventa,c.idcliente, c.nombre,c.appaterno,c.apmaterno,c.ci,c.telefonocel,c.smspromocion,c.smsmora,c.smscredito,u.nombre as nameuser,u.appaterno as appuser,u.apmaterno as apmuser,co.fechavcto
											from cobros co, clientes c,ventas v, usuarios u
											where co.idventa=v.idventa and
											v.idcliente=c.idcliente and
											v.idusuario=u.idusuario  $swuser and									
											co.interesmora<=0 and
											co.estado='pendiente' and
											v.estado!='en proceso' and
											co.fechavcto<= curdate() group by idcliente";
					break;
				case 'enmora' :
					$query = "select v.idventa,c.idcliente, c.nombre,c.appaterno,c.apmaterno,c.ci,c.telefonocel,c.smspromocion,c.smsmora,c.smscredito,u.nombre as nameuser,u.appaterno as appuser,u.apmaterno as apmuser,co.fechavcto
										from cobros co, clientes c,ventas v, usuarios u
										where co.idventa=v.idventa and
										v.idcliente=c.idcliente and
										v.idusuario=u.idusuario  $swuser and
										co.interesmora>0 and
										co.estado='pendiente' and
										v.estado!='en proceso'";
					break;
				case 'enproceso' :
					$query = "select v.idventa,c.idcliente, c.nombre,c.appaterno,c.apmaterno,c.ci,c.telefonocel,u.nombre as nameuser,u.appaterno as appuser,u.apmaterno as apmuser,co.fechavcto
											from cobros co, clientes c,ventas v, usuarios u
											where co.idventa=v.idventa and
											v.idcliente=c.idcliente and
											v.idusuario=u.idusuario  $swuser and
											co.interesmora>0 and
											co.estado='pendiente' and
											v.estado ='en proceso' group by idcliente";
					break;
				case 'revertido' :
					$query = "select v.idventa,c.idcliente,c.nombre, c.appaterno, c.apmaterno,c.ci,c.telefonocel,u.nombre as nameuser,u.appaterno as appuser,u.apmaterno as apmuser
											from clientes c, ventas v, usuarios u
											where c.idcliente=v.idcliente and
											v.estado='revertido' and
											v.idusuario=u.idusuario  $swuser";
					break;
				case 'porcobrar' :
					$query = "select c.idcliente, c.nombre,c.appaterno,c.apmaterno,c.ci,c.telefonocel,u.nombre as nameuser,u.appaterno as appuser,u.apmaterno as apmuser
											from cobros co, clientes c,ventas v, usuarios u
											where co.idventa=v.idventa and
											v.idcliente=c.idcliente and
											v.idusuario=u.idusuario  $swuser and									
											co.interesmora<=0 and
											co.estado='pendiente' and
											v.estado!='en proceso' and
											co.fechavcto<= curdate() group by idcliente
											union
											select c.idcliente, c.nombre,c.appaterno,c.apmaterno,c.ci,c.telefonocel,u.nombre as nameuser,u.appaterno as appuser,u.apmaterno as apmuser
											from cobros co, clientes c,ventas v, usuarios u
											where co.idventa=v.idventa and
											v.idcliente=c.idcliente and
											v.idusuario=u.idusuario  $swuser and
											co.interesmora>0 and
											co.estado='pendiente' and
											v.estado!='en proceso'";
					break;
				case 'todas' :
					$query = "select v.idventa,v.fechaventa,c.nombre,c.appaterno,c.apmaterno,g.descripcion,v.montodeventa
										from ventas v, usuarios u,clientes c, detalleventa dv, productos p, grupos g 
										where v.idusuario=u.idusuario $swuser and										
										$rangofecha
										v.idcliente=c.idcliente and
										v.idventa=dv.idventa and
										dv.idgrupo=g.idgrupo and
										p.idgrupo=g.idgrupo and
										dv.idproducto=p.idproducto order by idventa";
					break;
				case 'alcredito' :
					$query = "select v.idventa,v.fechaventa,c.nombre,c.appaterno,c.apmaterno,g.descripcion,v.montodeventa
										from ventas v, usuarios u,clientes c, detalleventa dv, productos p, grupos g 
										where v.idusuario=u.idusuario $swuser and										
										$rangofecha
										v.idcliente=c.idcliente and
										v.idventa=dv.idventa and
										dv.idgrupo=g.idgrupo and
										p.idgrupo=g.idgrupo and
										dv.idproducto=p.idproducto and
										tipoventa='credito' order by idventa";
					break;
				case 'alcontado' :
					$query = "select v.idventa,v.fechaventa,c.nombre,c.appaterno,c.apmaterno,g.descripcion,v.montodeventa
										from ventas v, usuarios u,clientes c, detalleventa dv, productos p, grupos g 
										where v.idusuario=u.idusuario $swuser and										
										$rangofecha
										v.idcliente=c.idcliente and
										v.idventa=dv.idventa and
										dv.idgrupo=g.idgrupo and
										p.idgrupo=g.idgrupo and
										dv.idproducto=p.idproducto and
										tipoventa='contado' order by idventa";
			}

			$result = $this->mySql->query($query);
			if (!$result)
				return false;
			else
			{
				while ($reg = $result->fetch_assoc())
				{
					$this->misclientes[] = $reg;
				}
				return $this->misclientes;
			}
		}
	}

	public function clienteyventa($idcliente, $from)
	{
		if ($this->mySql == true)
		{
			switch($from)
			{
				case 'todos' :
					$query = "select idventa,c.nombre,c.appaterno,c.apmaterno, montodeventa, cuotamensual, cuotainicial, nrocuotas, fechainicial, fechaventa,horaventa, tipoventa,estado 
									from clientes c, ventas v
									where c.idcliente=v.idcliente and
									c.idcliente='$idcliente'";
					break;
				case 'casimora' :
					$query = "select v.idventa,c.nombre,c.appaterno,c.apmaterno, montodeventa, cuotamensual, cuotainicial, nrocuotas, fechainicial, fechaventa,horaventa, tipoventa,v.estado 
											from clientes c, ventas v, cobros co
											where c.idcliente=v.idcliente and
											c.idcliente='$idcliente' and
											v.idventa=co.idventa and
											co.interesmora<=0 and
											co.estado='pendiente' and
											v.estado!='en proceso' and
											co.fechavcto<= curdate()";
					break;
				case 'enmora' :
					$query = "select v.idventa,c.nombre,c.appaterno,c.apmaterno, montodeventa, cuotamensual, cuotainicial, nrocuotas, fechainicial, fechaventa,horaventa, tipoventa,v.estado 
										from clientes c, ventas v, cobros co
										where c.idcliente=v.idcliente and
										c.idcliente='$idcliente' and
										v.idventa=co.idventa and
										co.interesmora>0 and
										co.estado='pendiente' and
										v.estado!='en proceso'";
					break;
				case 'enproceso' :
					$query = "select v.idventa,c.nombre,c.appaterno,c.apmaterno, montodeventa, cuotamensual, cuotainicial, nrocuotas, fechainicial, fechaventa,horaventa, tipoventa,v.estado 
											from clientes c, ventas v, cobros co
											where c.idcliente=v.idcliente and
											c.idcliente='$idcliente' and
											v.idventa=co.idventa and
											co.interesmora>0 and
											co.estado='pendiente' and
											v.estado='en proceso'";
					break;
				case 'revertido' :
					$query = "select v.observacion
											from clientes c, ventas v
											where c.idcliente='$idcliente' and
											c.idcliente=v.idcliente and
											v.estado='revertido' 
											union												
											select g.descripcion
											from clientes c, productos p, ventas v, detalleventa dv, grupos g
											where p.idgrupo=g.idgrupo and
											p.idproducto=dv.idproducto and
											dv.idventa=v.idventa and
											v.idcliente=c.idcliente and
											c.idcliente='$idcliente' and
											v.estado='revertido'";
					break;
				case 'porcobrar' :
					$query = "select v.idventa,c.nombre,c.appaterno,c.apmaterno, montodeventa, cuotamensual, cuotainicial, nrocuotas, fechainicial, fechaventa,horaventa, tipoventa,v.estado 
											from clientes c, ventas v, cobros co
											where c.idcliente=v.idcliente and
											c.idcliente='$idcliente' and
											v.idventa=co.idventa and
											co.interesmora<=0 and
											co.estado='pendiente' and
											v.estado!='en proceso' and
											co.fechavcto<= curdate()
											union
											select v.idventa,c.nombre,c.appaterno,c.apmaterno, montodeventa, cuotamensual, cuotainicial, nrocuotas, fechainicial, fechaventa,horaventa, tipoventa,v.estado 
											from clientes c, ventas v, cobros co
											where c.idcliente=v.idcliente and
											c.idcliente='$idcliente' and
											v.idventa=co.idventa and
											co.interesmora>0 and
											co.estado='pendiente' and
											v.estado!='en proceso'";
				case 'pendiente' :
					$query = "select idventa,c.nombre,c.appaterno,c.apmaterno, montodeventa, cuotamensual, cuotainicial, nrocuotas, fechainicial, fechaventa,horaventa, tipoventa,estado 
									from clientes c, ventas v
									where c.idcliente=v.idcliente and
									v.estado='pendiente' and
									c.idcliente='$idcliente'";
					break;
			}

			$result = $this->mySql->query($query);
			if (!$result)
				return false;
			else
			{
				while ($reg = $result->fetch_assoc())
				{
					$this->clienteyventa[] = $reg;
				}
				return $this->clienteyventa;
			}
		}
	}

	public function calcularprecio($precio, $idproducto)
	{
		if ($this->mySql == true)
		{
			$query1 = "select v.idventa 
					from ventas v, detalleventa dv, productos p
					where v.idventa=dv.idventa and
					dv.idproducto=p.idproducto and
					p.idproducto='$idproducto'";
			$result1 = $this->mySql->query($query1);
			$idventa = mysql_result($result1, 0);
			$query2 = "select sum(cuota) as congeladosinpagar from cobros c
					where idventa='$idventa' and
					c.estado='congelado'";
			$query3 = "select sum(interesmora) as morasinpagar from cobros c
					where idventa='$idventa' and
					c.estado='congelado'";
			$result2 = $this->mySql->query($query2);
			$congeladosinpagar = mysql_result($result2, 0);
			$result3 = $this->mySql->query($query3);
			$morasinpagar = mysql_result($result3, 0);
			$query4 = "select sum(cuota) as cobrosinpagar from cobros c
					where idventa='$idventa'";
			$result4 = $this->mySql->query($query4);
			$cobrosinpagar = mysql_result($result4, 0);
			$query5 = "select (($congeladosinpagar*100)/$cobrosinpagar) as porsinpagar";
			$result5 = $this->mySql->query($query5);
			$porsinpagar = mysql_result($result5, 0);
			$query6 = "select '$morasinpagar'+(('$porsinpagar'/100)*'$precio') as precio";
			$result6 = $this->mySql->query($query6);
			$precio = mysql_result($result6, 0);

			if (!$result1 || !$result2 || !$result3 || !$result4 || !$result5 || !$result6)
				return '!error';
			else
			{
				return $precio;
			}
		}
	}

	/***********************************************************DISTRIBUIR LAS FECHAS
	 * ENTRE LOS MESES*/
	public function facvent($mes, $dia, $hora, $id)
	{
		if ($this->mySql)
		{
			$query = "update facturas set fechafactura='2013/$mes/$dia', horafactura='$hora' where idfactura='$id'";
			$query2 = "update ventas set fechaventa='2013/$mes/$dia', horaventa='$hora' where idventa='$id'";
			$result = $this->mySql->query($query);
			$result2 = $this->mySql->query($query2);
			if (!$result || !$result2)
				return false;
			else
				return true;
		}
	}
}

/*$objetoventa=new classVenta;
 $objetoventa->updateventa(4,'reventa','1');
 $codventa=$objetoventa->SelectMaxid('venta');
 echo $codventa[0]['maxidventa'];*/
?>
