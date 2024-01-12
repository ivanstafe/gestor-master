<?php



	class AjusteProductos
	{



		public function ajustarProducto($datos)
{
    $con = new conectar();
    $conexion = $con->conexion();


    $sql = "INSERT INTO ajustes_productos_test (id_producto, cantidad, motivo, id_usuario, fechaCaptura) 
            VALUES ('$datos[id_producto]', '$datos[cantidad]', '$datos[motivo]', '$datos[id_usuario]', '$datos[fecha]')";

    return mysqli_query($conexion, $sql);
}

}


?>