<?php

require_once "../../clases/Conexion.php";
$con = new conectar();
$conexion = $con->conexion();

$sql = "SELECT id_usuario,
					nombre,
					apellido,
					user
			from usuarios";
$result = mysqli_query($conexion, $sql);

?>


<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
    <caption><label>Usuarios:</label></caption>
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Usuario</th>
        <th>Actualizar</th>
        <th>Eliminar</th>
    </tr>

    <?php while ($ver = mysqli_fetch_row($result)) : ?>

        <tr>
            <td><?php echo $ver[1]; ?></td>
            <td><?php echo $ver[2]; ?></td>
            <td><?php echo $ver[3]; ?></td>
            <td>
                <a data-toggle="modal" data-target="#actualizaUsuarioModal" class="btn btn-warning btn-xs" onclick="agregaDatosUsuario('<?php echo $ver[0]; ?>')">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>
            </td>
            <td>
                <a class="btn btn-danger btn-xs" onclick="eliminarUsuario('<?php echo $ver[0]; ?>')">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>