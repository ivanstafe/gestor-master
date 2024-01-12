<?php
require_once "../../clases/Conexion.php";

$con = new conectar();
$conexion = $con->conexion();

$idinsumo = $_POST['idInsumo']; 

// $archivo = 'datos_obtenidos.txt';
// $contenido = "ID de Insumo recibido: $idinsumo\n";

// file_put_contents($archivo, $contenido, FILE_APPEND);

$sql = "SELECT id_insumo, nombre, cantidad, precio 
        FROM insumos 
        WHERE id_insumo='$idinsumo'"; 

$contenidoSQL = "Consulta SQL: $sql\n";
file_put_contents($archivo, $contenidoSQL, FILE_APPEND);

$result = mysqli_query($conexion, $sql);

if (!$result) {
   
    $error = "Error en la consulta a la base de datos\n";
    file_put_contents($archivo, $error, FILE_APPEND);


    $errorJson = array("error" => "Error en la consulta a la base de datos");
    echo json_encode($errorJson);
    exit;
}

$ver = mysqli_fetch_row($result);

$datos = array(
    "id_insumo" => $ver[0], 
    "nombre" => $ver[1],
    "cantidad" => $ver[2],
    "precio" => $ver[3]
);


// $contenidoDatos = "Datos obtenidos: " . json_encode($datos) . "\n";
// file_put_contents($archivo, $contenidoDatos, FILE_APPEND);

echo json_encode($datos);
?>
