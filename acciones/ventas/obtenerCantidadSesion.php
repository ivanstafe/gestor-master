<?php
session_start();

if (isset($_POST['idProducto'])) {
    $idProducto = $_POST['idProducto'];

    // $logFile = 'log_obtener_cantidad.txt';
    // $logData = "ID del producto recibido: " . $idProducto . "\n";
    // file_put_contents($logFile, $logData, FILE_APPEND);

    

    $cantidadParaProducto = 0;

    if (isset($_SESSION['tablaComprasTemp'])) {
        foreach ($_SESSION['tablaComprasTemp'] as $producto) {
            $detallesProducto = explode("||", $producto);
            $productoID = $detallesProducto[0]; 

            if ($productoID == $idProducto) {
                $cantidadParaProducto += intval($detallesProducto[6]); 

                // $logDataCantidad = "Cantidad para el producto " . $idProducto . ": " . $cantidadParaProducto . "\n";
                // file_put_contents($logFile, $logDataCantidad, FILE_APPEND);
            }
        }
    }

    // Devolver la cantidad obtenida como respuesta a la solicitud AJAX
    echo $cantidadParaProducto;
} else {
    echo "No se proporcionó el ID del producto";
}


?>