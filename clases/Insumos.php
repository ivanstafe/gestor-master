<?php
class insumos
{
    public function agregaImagen($datos)
    {
        $con = new conectar();
        $conexion = $con->conexion();

        $fecha = date('Y-m-d');

        $sql = "INSERT INTO imagenesInsumos (id_categoria, nombre, ruta, fechaSubida)
                VALUES ('$datos[0]', '$datos[1]', '$datos[2]', '$fecha')";
        $result = mysqli_query($conexion, $sql);

        return mysqli_insert_id($conexion);
    }

    public function insertaInsumo($datos) {
        $con = new conectar();
        $conexion = $con->conexion();
    
        $fecha = date('Y-m-d');
        
        $sqlInsumos = "INSERT INTO insumos (id_categoria, id_imagen, id_usuario, id_proveedor, nombre, descripcion, fechaCaptura)
                       VALUES ('$datos[0]', '$datos[1]', '$datos[2]', '$datos[7]', '$datos[3]', '$datos[4]', '$fecha')";
        $resultInsumos = mysqli_query($conexion, $sqlInsumos);
    
        if ($resultInsumos) {
            $idInsumo = mysqli_insert_id($conexion);
            $cantidad = mysqli_real_escape_string($conexion, $datos[5]);
    
            $sqlInventario = "INSERT INTO inventario_insumos (id_insumo, cantidad, fecha_ingreso, id_proveedor, metodo_pago, numero_factura, fecha_pago, estado_pago, precio)
                              VALUES ('$idInsumo', '$cantidad', '$fecha', '$datos[7]', '$datos[8]', '$datos[9]', '$datos[10]', '$datos[11]', '$datos[6]')";
            $resultInventario = mysqli_query($conexion, $sqlInventario);
    
            if ($resultInventario) {
                return 1; 
            } else {
                return 0; 
            }
        } else {
            return 0; 
        }
    }
    
    
    
    public function obtenerDatosInsumo($idIns)
    {
        $con = new conectar();
        $conexion = $con->conexion();
    
        // Consulta para obtener datos del insumo y su cantidad total en inventario
        $sql = "SELECT i.id_insumo, i.id_categoria, i.nombre, i.descripcion, 
                       SUM(ii.cantidad) as cantidad_total, i.precio, i.id_proveedor,
                       ii.metodo_pago, ii.numero_factura, ii.fecha_pago, ii.estado_pago
                FROM insumos i
                LEFT JOIN inventario_insumos ii ON i.id_insumo = ii.id_insumo
                WHERE i.id_insumo = '$idIns'";
                
        $result = mysqli_query($conexion, $sql);
    
        $datos = array();
        
        if ($result) {
            $ver = mysqli_fetch_assoc($result);
    
            // Asignar los datos obtenidos a un arreglo
            $datos = array(
                "id_insumo" => $ver['id_insumo'],
                "id_categoria" => $ver['id_categoria'],
                "nombre" => $ver['nombre'],
                "descripcion" => $ver['descripcion'],
                "cantidad_total" => $ver['cantidad_total'],
                "precio" => $ver['precio'],
                "id_proveedor" => $ver['id_proveedor'],
                "metodo_pago" => $ver['metodo_pago'],
                "numero_factura" => $ver['numero_factura'],
                "fecha_pago" => $ver['fecha_pago'],
                "estado_pago" => $ver['estado_pago']
            );
        }
    
        return $datos;
    }
    




    public function actualizaInsumo($datos)
{
    $con = new conectar();
    $conexion = $con->conexion();

    $toggleCantidad = $datos[11];

    $sqlInsumos = "UPDATE insumos 
                   SET nombre='$datos[2]',
                       descripcion='$datos[3]'
                   WHERE id_insumo='$datos[0]'";

    $resultInsumos = mysqli_query($conexion, $sqlInsumos);

    if ($resultInsumos) {
        // Verificar si se proporciona una cantidad para actualizar el inventario
        if (!empty($datos[4])) {
            // Verificar si la cantidad es negativa antes de la inserción
            if ($datos[4] >= 0) {
                $sqlInventario = "INSERT INTO inventario_insumos (id_insumo, cantidad, fecha_ingreso, id_proveedor, metodo_pago, numero_factura, fecha_pago, estado_pago, precio) 
                                  VALUES ('$datos[0]', '$datos[4]', CURDATE(), '$datos[6]', '$datos[7]', '$datos[8]', '$datos[9]', '$datos[10]', '$datos[5]')";
                return mysqli_query($conexion, $sqlInventario);
            } else {
                // Si la cantidad es negativa, obtener el precio de la tabla insumos
                $sqlPrecioInsumo = "SELECT precio FROM insumos WHERE id_insumo='$datos[0]'";
                $resultPrecioInsumo = mysqli_query($conexion, $sqlPrecioInsumo);

                if ($resultPrecioInsumo && mysqli_num_rows($resultPrecioInsumo) > 0) {
                    $row = mysqli_fetch_assoc($resultPrecioInsumo);
                    $precioInsumo = $row['precio'];

                    $sqlInventario = "INSERT INTO inventario_insumos (id_insumo, cantidad, fecha_ingreso, id_proveedor, metodo_pago, numero_factura, fecha_pago, estado_pago, precio) 
                                      VALUES ('$datos[0]', '$datos[4]', CURDATE(), NULL, NULL, NULL, NULL, NULL, '$precioInsumo')";
                    return mysqli_query($conexion, $sqlInventario);
                } 
            }
        }

        return true;
    }

    return $resultInsumos;
}


    public function eliminaInsumo($idInsumo)
    {
        $con = new conectar();
        $conexion = $con->conexion();

        $sql = "DELETE FROM insumos WHERE id_insumo='$idInsumo'";
        $result = mysqli_query($conexion, $sql);

        if ($result) {
            return 1;
        }
    }

    public function obtenIdImg($idInsumo)
    {
        $c = new conectar();
        $conexion = $c->conexion();

        $sql = "SELECT id_imagen FROM insumos WHERE id_insumo='$idInsumo'";
        $result = mysqli_query($conexion, $sql);

        return mysqli_fetch_row($result)[0];
    }

    public function obtenRutaImagen($idImg)
    {
        $con = new conectar();
        $conexion = $con->conexion();

        $sql = "SELECT ruta FROM imagenesInsumos WHERE id_imagen='$idImg'";
        $result = mysqli_query($conexion, $sql);

        return mysqli_fetch_row($result)[0];
    }
}
?>
