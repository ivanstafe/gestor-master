<?php 

    require_once "../../clases/Conexion.php";
    
    $con = new conectar();
    $conexion = $con->conexion();
    
    $idproducto = $_POST['idproducto'];
    
    $sql = "SELECT id_producto, nombre, cantidad 
            FROM productos 
            WHERE id_producto='$idproducto'";
    $result = mysqli_query($conexion, $sql);
    
    if (!$result) {

        $error = array("error" => "Error en la consulta a la base de datos");
        echo json_encode($error);
        exit;
    }
    
    $ver = mysqli_fetch_row($result);
    
    $datos = array(
        "id_producto" => $ver[0],
        "nombre" => $ver[1],
        "cantidad" => $ver[2]
    );
    
    echo json_encode($datos);

    
