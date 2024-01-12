<?php
require_once "../../clases/Conexion.php";
require_once "../../clases/Insumos.php";

$obj = new Insumos();

$datos = array(
    $_POST['idInsumo'],
    $_POST['categoriaSelectEditar'],
    $_POST['nombreEditar'],
    $_POST['descripcionEditar'],
    $_POST['cantidadEditar'],
    $_POST['precioEditar'],
    $_POST['proveedorSelectEditar'],
    $_POST['metodoPagoEditar'],
    $_POST['numeroFacturaEditar'],
    $_POST['fechaPagoEditar'],
    $_POST['estadoPagoEditar'],
    $_POST['accionSeleccionada'], 
    $_POST['toggleCantidad']
);

// $log = "Datos recibidos: " . implode(", ", $datos) . "\n";
// file_put_contents("datos.txt", $log, FILE_APPEND); 

echo $obj->actualizaInsumo($datos);
?>
