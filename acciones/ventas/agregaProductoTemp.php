<?php
session_start();
require_once "../../clases/Conexion.php";

$con = new conectar();
$conexion = $con->conexion();

$idcliente = $_POST['clienteVenta'];
$idproducto = $_POST['productoVenta'];
$descripcion = $_POST['descripcionV'];
$cantidad = $_POST['cantidadV'];
$precio = $_POST['precioV'];
$descuento = $_POST['descuentoV'];

$file = 'depurador.txt';

$data = "ID Cliente: " . $idcliente . "\n" .
        "ID Producto: " . $idproducto . "\n" .
        "Descripción: " . $descripcion . "\n" .
        "Cantidad: " . $cantidad . "\n" .
        "Precio: " . $precio . "\n";

// Cálculo del descuento si el valor es numérico
$descuentoCalculado = 0;
if (is_numeric($descuento)) {
    $descuentoCalculado = $precio * ($descuento / 100);
    $precio -= $descuentoCalculado; // Aplicar el descuento al precio
}

$data .= "Descuento: " . $descuentoCalculado . "\n";

file_put_contents($file, $data, FILE_APPEND);

$sql = "SELECT nombre, apellido 
        FROM clientes 
        WHERE id_cliente='$idcliente'";
$result = mysqli_query($conexion, $sql);

$c = mysqli_fetch_row($result);

$ncliente = $c[1] . " " . $c[0];

$sql = "SELECT nombre 
        FROM productos 
        WHERE id_producto='$idproducto'";
$result = mysqli_query($conexion, $sql);

$nombreproducto = mysqli_fetch_row($result)[0];

$producto = $idproducto . "||" .
    $nombreproducto . "||" .
    $descripcion . "||" .
    $precio . "||" . // Usar el precio con descuento si se aplicó uno
    $ncliente . "||" .
    $idcliente . "||" . 
    $cantidad; 

$_SESSION['tablaComprasTemp'][] = $producto;
?>
