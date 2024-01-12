<?php
require_once "../../clases/Conexion.php";

// $file = 'depurador.txt';
// $data = "Solicitud recibida en el script PHP\n";
// file_put_contents($file, $data, FILE_APPEND);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idproducto'])) {
    $productoId = $_POST['idproducto'];

    $data = "ID de producto recibido: $productoId\n";
    file_put_contents($file, $data, FILE_APPEND);

    $con = new conectar();
    $conexion = $con->conexion();

    // Preparar la consulta con una sentencia preparada
    $sql = "SELECT cantidad FROM productos WHERE id_producto = ?";
    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "i", $productoId);
        
        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);
        
        // Obtener resultados
        mysqli_stmt_bind_result($stmt, $cantidadDisponible);
        mysqli_stmt_fetch($stmt);

        if ($cantidadDisponible !== null) {
            $data = "Cantidad disponible para el producto con ID $productoId: $cantidadDisponible\n";
            file_put_contents($file, $data, FILE_APPEND);

            echo $cantidadDisponible;
        } else {
            $data = "No se encontró la cantidad disponible para el producto con ID $productoId\n";
            file_put_contents($file, $data, FILE_APPEND);
    
            echo "No se encontró la cantidad disponible para el producto";
        }

        mysqli_stmt_close($stmt);
    } else {
        $data = "Error en la preparación de la consulta\n";
        file_put_contents($file, $data, FILE_APPEND);

        echo "Error al obtener la cantidad disponible del producto";
    }

    mysqli_close($conexion);
} else {
    $data = "No se recibió el ID del producto en la solicitud\n";
    file_put_contents($file, $data, FILE_APPEND);

    echo "No se recibió el ID del producto";
}
?>
