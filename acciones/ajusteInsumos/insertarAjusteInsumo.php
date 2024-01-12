<?php

session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/AjusteInsumos.php";

$obj = new AjusteInsumos();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['idInsumoEditar'], $_POST['cantidadEditar'], $_POST['motivoEditar'])) {
        $iduser = $_SESSION['iduser'];
        $fecha = date("Y-m-d");

        $datos = array(
            'id_insumo' => $_POST['idInsumoEditar'],
            'cantidad' => $_POST['cantidadEditar'],
            'motivo' => $_POST['motivoEditar'],
            'id_usuario' => $iduser,
            'fecha' => $fecha
        );

        // file_put_contents('put_content.txt', print_r($datos, true)); 

        $resultado = $obj->ajustarInsumo($datos);

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


