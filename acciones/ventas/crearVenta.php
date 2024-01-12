<?php 
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/Ventas.php";

$obj = new Ventas(); 

$idCliente = $_POST['clienteVenta'];
$descuento = $_POST['descuento']; 
$tipoVenta = $_POST['tipoVenta']; 


// file_put_contents('log.txt', print_r($_POST, true)); 

if (empty($_SESSION['tablaComprasTemp'])) {
    echo 0;
} else {
   
    $result = $obj->crearVenta($idCliente, $tipoVenta, $descuento);

    unset($_SESSION['tablaComprasTemp']);

    echo $result;
}
?>
