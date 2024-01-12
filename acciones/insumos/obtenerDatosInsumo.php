<?php

require_once "../../clases/Conexion.php";
require_once "../../clases/Insumos.php";

$obj = new Insumos();

$idIns = $_POST['idIns'];

$datosInsumo = $obj->obtenerDatosInsumo($idIns);

$datosJson = json_encode($datosInsumo);

$archivo = fopen("content.txt", "w") or die("No se puede abrir el archivo");
fwrite($archivo, $datosJson);
fclose($archivo);

echo $datosJson;
?>
