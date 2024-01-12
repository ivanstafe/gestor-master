<?php
require_once "../../clases/Conexion.php";
$con = new conectar();
$conexion = $con->conexion();


// $requestData = print_r($_REQUEST, true);
// file_put_contents('data_received.txt', $requestData);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_producto']) && isset($_POST['nuevo_estado'])) {
        $idProducto = $_POST['id_producto'];
        $nuevoEstado = $_POST['nuevo_estado'] === 'true' ? 1 : 0; // Convertir a booleano

        
        $sqlUpdate = "UPDATE productos SET estado = $nuevoEstado WHERE id_producto = $idProducto";
        $resultado = mysqli_query($conexion, $sqlUpdate);

        if ($resultado) {
            echo "El estado del producto se actualizó correctamente.";
        } else {
            echo "Hubo un problema al actualizar el estado del producto.";
        }
    }
}
?>

