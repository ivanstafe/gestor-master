<?php 

require_once "../../clases/Conexion.php";
require_once "../../clases/Productos.php";

$obj = new productos();
$idPro = $_POST['idPro'];


$datosProducto = $obj->obtenerDatosProducto($idPro);


$logData = json_encode($datosProducto);


$logFilePath = 'log.txt';


file_put_contents($logFilePath, $logData . "\n", FILE_APPEND);


echo json_encode($datosProducto);
?>
