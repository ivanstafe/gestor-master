<?php

session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/AjusteProductos.php";

$obj = new AjusteProductos();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['idProductoEditar'], $_POST['cantidadEditar'], $_POST['motivoSEditar'])) {
        $iduser = $_SESSION['iduser'];
        $fecha = date("Y-m-d");

        $datos = array(
            'id_producto' => $_POST['idProductoEditar'],
            'cantidad' => $_POST['cantidadEditar'],      
            'motivo' => $_POST['motivoSEditar'],
            'id_usuario' => $iduser,
            'fecha' => $fecha
        );

        $resultado = $obj->ajustarProducto($datos);

        if ($resultado === true) {
            echo "1"; // Éxito
        } else {
            echo "0"; // Error
        }
    } else {
        echo "Error: Datos incompletos";
    }
} else {
    echo "Error: Método no permitido";
}

?>


