<?php 
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/Notas.php";

$obj = new Ventas(); 

$idCliente = $_POST['clienteVenta'];
$descuento = $_POST['descuento']; 



file_put_contents('log.txt', print_r($_POST, true)); 

if (empty($_SESSION['tablaNotasTemp'])) {
    echo 0;
} else {
   
    $result = $obj->crearNota($idCliente, $descuento);

    unset($_SESSION['tablaNotasTemp']);

    echo $result;
}
?>
