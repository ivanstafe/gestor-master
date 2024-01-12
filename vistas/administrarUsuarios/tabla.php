<?php
require_once "../../clases/Conexion.php";

$obj = new conectar();
$conexion = $obj->conexion();

$sql = "SELECT id_usuario, 
				nombre,
				apellido,
				tipo,
				password,
				fechaCaptura
		from usuarios";
$result = mysqli_query($conexion, $sql);
?>


<div style="margin-top: 20px;"></div>

<!-- <div class="table-responsive"> -->
<div class="">
    <table class="table table-hover table-condensed table-bordered" style="text-align: center;" id="tabla-usuarios">
        <thead>
            <tr>
                <th>Nombre <br> <input type="text" id="" class="filtro-input"></th>
                <th>Apellido <br> <input type="text" id="filtro-apellido" class="filtro-input"></th>
                <th>Tipo <br> <input type="text" id="filtro-tipo" class="filtro-input"></th>
                <th>Contraseña <br> <input type="text" id="filtro-contraseña" class="filtro-input"></th>
                <th>fechaCaptura <br> <input type="text" id="filtro-fecha" class="filtro-input"></th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php mysqli_data_seek($result, 0); // NO es necesario reiniciar el puntero de la consulta 
            ?>
            <?php while ($ver = mysqli_fetch_row($result)) : ?>
                <tr class="usuario-row" id="<?php echo $ver[0]; ?>">
                    <td><?php echo $ver[1]; ?></td>
                    <td><?php echo $ver[2]; ?></td>
                    <td><?php echo $ver[3]; ?></td>
                    <td class="scrollable-cell scrollable-password"><?php echo $ver[4]; ?></td>
                    <td><?php echo $ver[5]; ?></td>
                    <td>
                        <span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#actualizarUsuario" onclick="actualizarDatosUsuario('<?php echo $ver[0]; ?>')">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </span>
                    </td>
                    <td>
                        <span class="btn btn-danger btn-xs" onclick="eliminarUsuario('<?php echo $ver[0]; ?>')">
                            <span class="glyphicon glyphicon-remove"></span>
                        </span>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        // Inicializar DataTables
        var table = $('#tabla-usuarios').DataTable({
            "order": [],
            "language": {
                "emptyTable": "No se encontraron registros",
                "zeroRecords": "No se encontraron resultados que coincidan con el filtro",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(filtrado de _MAX_ registros en total)",
                "lengthMenu": "Mostrar _MENU_ entradas",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });

        // Aplicar la búsqueda individual en cada input
        $('#tabla-usuarios thead input').on('keyup change', function() {
            var columnIndex = $(this).closest('th').index();
            table
                .column(columnIndex)
                .search(this.value)
                .draw();
        });
    });
</script>


<style>
    /* Alinear el campo de búsqueda horizontalmente */
    #tabla-usuarios_filter.text-right {
        text-align: right;
        padding-right: 548px;
    }

    .resaltar {
        background-color: #ffa8b0 !important;
        /* Tono de lila más oscuro */
    }

    /* Alinear horizontalmente el campo de búsqueda */
    #tabla-usuarios_filter.text-center {
        text-align: center;
        padding-right: 0;
    }

    /* Estilo para colocar el texto del filtro en la fila adecuada */
    #tabla-usuarios thead th {
        position: relative;
        text-align: center;
        background-color: #333;
        border: 1px solid #333;
        color: white;
    }

    /* Reducir el tamaño de las celdas */
    .table th,
    .table td {
        font-size: 12px;
        max-width: 80px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Ocultar el campo de búsqueda de DataTables */
    .dataTables_filter {
        display: none;
    }

    /* Estilo para los inputs de filtro */
    .filtro-input {
        max-width: 60%;
        text-align: center;
        margin-bottom: 0.5em;
        border: 1px solid #ccc;
        background-color: #eee;
        color: black;
        padding: 4px;
        font-size: 13px;
    }

    /* Estilo específico para el input de filtro en el encabezado */
    #tabla-usuarios thead th .filtro-input {
        background-color: #ccc;
    }

    #tabla-usuarios thead th input {
        border-radius: 4px;
    }

    /* Ajustes adicionales para emular el estilo proporcionado */
    #tabla-usuarios_filter input {
        min-width: 0;
        max-width: none;
        width: 100%;
        background-color: #ccc;
    }

    #tabla-usuarios thead th .filtro-input {
        max-width: none;
        width: 100%;
    }
</style>