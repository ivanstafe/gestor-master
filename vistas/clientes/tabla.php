<?php
require_once "../../clases/Conexion.php";

$obj = new conectar();
$conexion = $obj->conexion();
session_start();

$sql = "SELECT id_cliente, 
				nombre,
				apellido,
				direccion,
                cuit,
				email,
				telefono,
                telefono2
		from clientes";
$result = mysqli_query($conexion, $sql);

// Lógica para ocultar las opciones de edición y eliminación si el usuario no es Administrador
if (isset($_SESSION['nombre'])) {
    $nombreUsuario = $_SESSION['nombre'];
    $sql_tipo = "SELECT tipo FROM usuarios WHERE nombre = '$nombreUsuario'";
    $result_tipo = mysqli_query($conexion, $sql_tipo);

    if ($result_tipo && mysqli_num_rows($result_tipo) > 0) {
        $fila_tipo = mysqli_fetch_assoc($result_tipo);
        $_SESSION['tipo'] = $fila_tipo['tipo'];
    }
}
?>

<div style="margin-top: 20px;"></div>

<div class="">
    <table class="table table-hover table-condensed table-bordered" style="text-align: center;" id="tabla-clientes">
        <thead>
            <tr>
                <th>Nombre <br> <input type="text" id="filtro-nombre" class="filtro-input"></th>
                <th>Apellido <br> <input type="text" id="filtro-apellido" class="filtro-input"></th>
                <th>Direccion <br> <input type="text" id="filtro-direccion" class="filtro-input"></th>
                <th>CUIT <br> <input type="text" id="filtro-cuit" class="filtro-input"></th>
                <th>Email <br> <input type="text" id="filtro-email" class="filtro-input"></th>
                <th>Tel.1 <br> <input type="text" id="filtro-tel1" class="filtro-input"></th>
                <th>Tel.2 <br> <input type="text" id="filtro-tel2" class="filtro-input"></th>
                <th>Actualizar</th>
            </tr>
        </thead>
        <tbody>
            <?php mysqli_data_seek($result, 0); // NO es necesario reiniciar el puntero de la consulta 
            ?>

            <?php while ($ver = mysqli_fetch_row($result)) : ?>
                <tr class="cliente-row" id="<?php echo $ver[0]; ?>">
                    <td><?php echo $ver[1]; ?></td>
                    <td><?php echo $ver[2]; ?></td>
                    <td><?php echo $ver[3]; ?></td>
                    <td><?php echo $ver[4]; ?></td>
                    <td><?php echo $ver[5]; ?></td>
                    <td><?php echo $ver[6]; ?></td>
                    <td><?php echo $ver[7]; ?></td>

                    <td>
                        <span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#actualizarCliente" onclick="actualizarDatosCliente('<?php echo $ver[0]; ?>')">
                            <span class="glyphicon glyphicon-pencil"></span>
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
        var table = $('#tabla-clientes').DataTable({
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
        $('#tabla-clientes thead input').on('keyup change', function() {
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
    #tabla-clientes_filter.text-right {
        text-align: right;
        padding-right: 548px;
    }

    .resaltar {
        background-color: #ffa8b0 !important;
        /* Tono de lila más oscuro */
    }

    /* Alinear horizontalmente el campo de búsqueda */
    #tabla-clientes_filter.text-center {
        text-align: center;
        padding-right: 0;
    }

    /* Estilo para colocar el texto del filtro en la fila adecuada */
    #tabla-clientes thead th {
        position: relative;
        text-align: center;
        background-color: #333;
        border: 1px solid #333;
        color: white;
    }

    /* Reducir el tamaño de las celdas */
    .table th,
    .table td {
        font-size: 13px;
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
        max-width: 100%;
        text-align: center;
        margin-bottom: 0.5em;
        border: 1px solid #ccc;
        background-color: #eee;
        color: black;
        padding: 4px;
        font-size: 13px;
    }

    /* Estilo específico para el input de filtro en el encabezado */
    #tabla-clientes thead th .filtro-input {
        background-color: #ccc;
    }

    #tabla-clientes thead th input {
        border-radius: 4px;
    }

    /* Ajustes adicionales para emular el estilo proporcionado */
    #tabla-clientes_filter input {
        min-width: 0;
        max-width: none;
        width: 100%;
        background-color: #ccc;
    }

    #tabla-clientes thead th .filtro-input {
        max-width: none;
        width: 100%;
    }
</style>