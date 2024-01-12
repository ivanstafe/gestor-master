<?php 

class ventas{
	public function obtenDatosProducto($idproducto){
		$con=new conectar();
		$conexion=$con->conexion();

		$sql = "SELECT 
				    pro.nombre,
				    pro.descripcion,
				    pro.cantidad,
				    img.ruta,
				    pro.precio
				FROM
				    productos AS pro
				        INNER JOIN
				    imagenes AS img ON pro.id_imagen = img.id_imagen
				        AND pro.id_producto = '$idproducto'";
		$result=mysqli_query($conexion,$sql);

		$ver=mysqli_fetch_row($result);

		$d=explode('/', $ver[3]);

		$img=$d[1].'/'.$d[2].'/'.$d[3];

		$data=array(
			'nombre' => $ver[0],
			'descripcion' => $ver[1],
			'cantidad' => $ver[2],
			'ruta' => $img,
			'precio' => $ver[4]
		);		
		return $data;
	}

	
	public function crearVenta($idCliente, $tipoVenta, $descuento = 0) {
		$con = new conectar();
		$conexion = $con->conexion();
	
		$fecha = date('Y-m-d');
		$idventa = self::creaFolioCabeceraRemito();
		$idusuario = $_SESSION['iduser'];
		$totalVenta = 0;
	
		$idcliente = $idCliente;
	
		$sqlCabecera = "INSERT INTO cabecera_remito (cliente_id, fecha, descuentos, metodo_pago) VALUES ('$idcliente', '$fecha', '$descuento', '$tipoVenta')";
		$resultCabecera = mysqli_query($conexion, $sqlCabecera);
	
		if ($resultCabecera) {
			$idCabecera = mysqli_insert_id($conexion);
	
			$datos = $_SESSION['tablaComprasTemp'];
			foreach ($datos as $dato) {
				$d = explode("||", $dato);
				$precio = $d[3];
				$cantidad = $d[6];
				$importe = $precio * $cantidad; // Calcula el importe sin el descuento
	
				// Aplicar descuento al importe si se proporciona un valor de descuento mayor que cero
				if ($descuento > 0) {
					$importeConDescuento = $importe - ($importe * ($descuento / 100));
				} else {
					$importeConDescuento = $importe; // Si no hay descuento, el importe con descuento es igual al importe sin cambios
				}
	
				// Insertar el importe con descuento en la tabla detalle_remito
				$sqlDetalle = "INSERT INTO detalle_remito (cabecera_remito_id, producto_id, cantidad, importe) VALUES ('$idCabecera', '$d[0]', '$cantidad', '$importeConDescuento')";
				mysqli_query($conexion, $sqlDetalle);
	
				$totalVenta += $importeConDescuento; // Sumar el importe con descuento al total de la venta
			}
	
			return $totalVenta; // Retorna el total de la venta con los descuentos aplicados
		} else {
			return 0;
		}
	}
	
	
	
	
	public function creaFolioCabeceraRemito(){
		$con = new conectar();
		$conexion = $con->conexion();
	
		$sql = "SELECT id FROM cabecera_remito ORDER BY id DESC LIMIT 1";
		$result = mysqli_query($conexion, $sql);
	
		if (mysqli_num_rows($result) > 0) {
			$id = mysqli_fetch_row($result)[0];
			return $id + 1;
		} else {
			return 1; // Si no hay registros en la tabla, empezamos desde el folio 1.
		}
	}
	
	public function nombreCliente($idCliente){
		$c= new conectar();
		$conexion=$c->conexion();

		 $sql="SELECT apellido,nombre
			from clientes 
			where id_cliente='$idCliente'";
		$result=mysqli_query($conexion,$sql);

		$ver=mysqli_fetch_row($result);

		return $ver[0]." ".$ver[1];
	}

	public function obtenerTotal($idCabecera) {
		$c = new conectar();
		$conexion = $c->conexion();
	
		$sql = "SELECT SUM(importe) AS total FROM detalle_remito WHERE cabecera_remito_id = '$idCabecera'";
		$result = mysqli_query($conexion, $sql);
	
		if (mysqli_num_rows($result) > 0) {
			$total = mysqli_fetch_assoc($result)['total'];
			return $total;
		} else {
			return 0; // Si no hay registros en la tabla "detalle_remito", el total es cero.
		}
	}
	
       //borra
	// public function eliminarArticulos(){
	// 	$c=new conectar();
	// 	$conexion=$c->conexion();

		

	// 	$sql="DELETE FROM articulos WHERE id_producto IN(SELECT id_producto FROM ventas);";
	// 	$result=mysqli_query($conexion,$sql);

	
	// }

}

?>