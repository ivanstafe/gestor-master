

<?php 
	class productos{
		public function agregaImagen($datos){
			$con=new conectar();
			$conexion=$con->conexion();

			$fecha=date('Y-m-d');

			$sql="INSERT into imagenes (id_categoria,
										nombre,
										ruta,
										fechaSubida)
							values ('$datos[0]',
									'$datos[1]',
									'$datos[2]',
									'$fecha')";
			$result=mysqli_query($conexion,$sql);

			return mysqli_insert_id($conexion);
		}
		public function insertaProducto($datos)
{
    $con = new conectar();
    $conexion = $con->conexion();

    $fecha = date('Y-m-d');

    $sql = "INSERT INTO productos (id_categoria, id_imagen, id_usuario, nombre, descripcion, precio, fechaCaptura) 
            VALUES ('$datos[0]', '$datos[1]', '$datos[2]', '$datos[3]', '$datos[4]', '$datos[6]', '$fecha')";

    $resultProducto = mysqli_query($conexion, $sql);

    if ($resultProducto) {
        $idProducto = mysqli_insert_id($conexion);

        // Modificar para obtener el precio del producto desde la tabla productos
        $queryPrecio = "SELECT precio FROM productos WHERE id_producto = '$idProducto'";
        $resultPrecio = mysqli_query($conexion, $queryPrecio);

        if ($resultPrecio && mysqli_num_rows($resultPrecio) > 0) {
            $row = mysqli_fetch_assoc($resultPrecio);
            $precio = $row['precio'];

            // Insertar en la tabla de inventario_productos con el precio obtenido
            $cantidad = $datos[5]; // Cantidad del producto
            $queryInventario = "INSERT INTO inventario_productos (id_producto, cantidad, precio, fecha_ingreso) 
                                VALUES ('$idProducto', '$cantidad', '$precio', '$fecha')";

            $resultInventario = mysqli_query($conexion, $queryInventario);

            if ($resultInventario) {

                return true;
            } else {

                return false;
            }
        } else {

            return false;
        }
    } else {

        return false;
    }
}


		public function obtenerDatosProducto($idProducto){
    $con = new conectar();
    $conexion = $con->conexion();

    $sql = "SELECT p.id_producto, 
                   p.id_categoria, 
                   p.nombre,
                   p.descripcion,
                   SUM(ip.cantidad) as total_cantidad,
                   p.precio 
            FROM productos AS p
            INNER JOIN inventario_productos AS ip ON p.id_producto = ip.id_producto
            WHERE p.id_producto='$idProducto'
            GROUP BY p.id_producto"; // Agrupar por ID de producto para sumar las cantidades

    $result = mysqli_query($conexion,$sql);

    $ver = mysqli_fetch_assoc($result);

    return $ver;
}


public function actualizarProducto($datos){
    $con = new conectar();
    $conexion = $con->conexion();
    
    $sql = "UPDATE productos 
            SET 
                nombre='$datos[1]',
                descripcion='$datos[2]',
                precio='$datos[4]'
            WHERE id_producto='$datos[0]'";
    
    $result = mysqli_query($conexion, $sql);
    
    if($result){
        // Verificar si se proporciona una cantidad para actualizar el inventario
        if(isset($datos[3]) && !empty($datos[3])) {
            $sqlInventario = "INSERT INTO inventario_productos (id_producto, cantidad, fecha_ingreso, precio)
                              VALUES ('$datos[0]', '$datos[3]', CURDATE(), '$datos[4]')";
            return mysqli_query($conexion, $sqlInventario);
        }
        // Si no se proporciona cantidad, simplemente retorna true (actualización exitosa sin cambios en inventario)
        return true;
    }
    return $result;
}

		
		
		public function eliminarProducto($idProducto){
			$con = new conectar();
			$conexion = $con->conexion();
		
			$sql = "DELETE FROM productos
					WHERE id_producto='$idProducto'";
			$result = mysqli_query($conexion, $sql);
		
			if($result){
				$sqlInventario = "DELETE FROM inventario_productos 
								  WHERE id_producto='$idProducto'";
				$resultInventario = mysqli_query($conexion, $sqlInventario);
				
				return $resultInventario ? 1 : 0;
			}
			return 0;
		}
		

		public function obtenIdImg($idProducto){
			$con= new conectar();
			$conexion=$con->conexion();

			$sql="SELECT id_imagen 
					from productos 
					where id_producto='$idProducto'";
			$result=mysqli_query($conexion,$sql);

			return mysqli_fetch_row($result)[0];
		}

		public function obtenRutaImagen($idImg){
			$con= new conectar();
			$conexion=$con->conexion();

			$sql="SELECT ruta 
					from imagenes 
					where id_imagen='$idImg'";

			$result=mysqli_query($conexion,$sql);

			return mysqli_fetch_row($result)[0];
		}

	}

 ?>