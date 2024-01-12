<?php

class AjusteInsumos
{
    public function ajustarInsumo($datos)
    {
        $con = new conectar();
        $conexion = $con->conexion();

        $archivo = 'datos_enviados.txt';
        $contenido = print_r($datos, true);
        file_put_contents($archivo, $contenido);

        $sql = "INSERT INTO ajustes_insumos_test (id_insumo, cantidad, motivo, id_usuario, fechaCaptura) 
                VALUES ('$datos[id_insumo]', '$datos[cantidad]', '$datos[motivo]', '$datos[id_usuario]', '$datos[fecha]')";

        return mysqli_query($conexion, $sql);
    }
}

?>
