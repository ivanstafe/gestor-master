<?php 
require_once "../../clases/Conexion.php";
require_once "../../clases/Gastos.php";

$obj = new Gastos();

$datos = array(
    $_POST['idGasto'],
    $_POST['categoriaSelectEditar'], 
    $_POST['nombreEditar'],
    $_POST['descripcionEditar'],
    $_POST['cantidadEditar'],
    $_POST['precioEditar'],
    $_POST['fechaPagoEditar'], 
    $_POST['metodoDePagoEditar'], 
    $_POST['numeroDeFacturaEditar'],
    $_POST['estadoPagoEditar']
);

$response = $obj->actualizaGasto($datos);

// $file = 'respuesta_actualiza_gasto.txt';
// $content = "Respuesta: " . $response . "\nDatos: " . print_r($datos, true) . "\n";
// file_put_contents($file, $content, FILE_APPEND);

echo $response;
?>
