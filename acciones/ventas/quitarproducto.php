<?php 
session_start();

if (isset($_POST['id_producto'])) {
    $idProducto = $_POST['id_producto'];

    foreach ($_SESSION['tablaComprasTemp'] as $index => $producto) {
        $d = explode("||", $producto);
        if ($d[0] === $idProducto) {
            unset($_SESSION['tablaComprasTemp'][$index]);
            $_SESSION['tablaComprasTemp'] = array_values($_SESSION['tablaComprasTemp']);
            $response = array(
                'success' => true,
                'message' => 'Elemento eliminado correctamente',
                'deleted_id' => $idProducto,
                'sesionActualizada' => $_SESSION['tablaComprasTemp']
            );
            echo json_encode($response);
            return;
        }
    }
}

$response = array(
    'success' => false,
    'message' => 'No se pudo eliminar el producto'
);
echo json_encode($response);

?>
