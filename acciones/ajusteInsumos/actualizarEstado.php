<?php
require_once "../../clases/Conexion.php";
$con = new conectar();
$conexion = $con->conexion();


// $requestData = print_r($_REQUEST, true);
// file_put_contents('data_received.txt', $requestData);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_insumo']) && isset($_POST['nuevo_estado'])) {
        $idInsumo = $_POST['id_insumo'];
        $nuevoEstado = $_POST['nuevo_estado'] === 'true' ? 1 : 0; // Convertir a booleano

       
        $sqlUpdate = "UPDATE insumos SET estado = $nuevoEstado WHERE id_insumo = $idInsumo";
        $resultado = mysqli_query($conexion, $sqlUpdate);

        if ($resultado) {
            echo "El estado del insumo se actualizó correctamente.";
        } else {
            echo "Hubo un problema al actualizar el estado del producto.";
        }
    }
}
?>

