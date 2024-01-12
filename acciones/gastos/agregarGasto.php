<?php
session_start();
$iduser = $_SESSION['iduser'];
require_once "../../clases/Conexion.php";
require_once "../../clases/Gastos.php";

$obj = new Gastos();

$datos = array(
    $_POST['categoriasSelect'],
    $iduser, 
    $_POST['nombre'],
    $_POST['descripcion'],
    $_POST['cantidad'],
    $_POST['precio'],
    $_POST['fechaPago'],
    $_POST['metodoPago'],
    $_POST['numeroFactura'],
    $_POST['estadoPago']
);

echo $obj->insertaGasto($datos);
?>
