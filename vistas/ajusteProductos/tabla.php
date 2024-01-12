<?php
require_once "../../clases/Conexion.php";
$con = new conectar();
$conexion = $con->conexion();
$sql = "SELECT p.id_producto, cp.nombre as categoria, p.id_imagen, p.id_usuario, p.nombre, p.descripcion, p.cantidad, p.precio, a.fechaCaptura,
        a.id_ajuste_producto, a.motivo as ajuste_motivo, p.estado as ajuste_estado
        FROM productos p
        INNER JOIN categoriasProductos cp ON p.id_categoria = cp.id_categoria
        LEFT JOIN ajustes_productos_test a ON p.id_producto = a.id_producto";

$result = mysqli_query($conexion, $sql);
?>


<div style="margin-top: 20px;"></div>

<div class="">
    <table class="table table-hover table-condensed table-bordered" style="text-align: center;" id="tabla-productos">
        <thead>
            <tr>
                <th style="text-align: center;">ID de Producto <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">ID de Ajuste <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Nombre <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Categoria <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Descripcion <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Cantidad <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Precio <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Motivo <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Usuario <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Estado <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Fecha <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Activar <br> Desactivar</th>
                <th style="text-align: center;">Ajustar </th>
            </tr>
        </thead>
        <tbody>
            <?php mysqli_data_seek($result, 0); // Reiniciar el puntero de la consulta 
            ?>
            <?php while ($ver = mysqli_fetch_row($result)) : ?>
                <tr class="producto-row <?php echo ($ver[9] || $ver[10] || $ver[8]) ? 'ajuste-realizado' : ''; ?>" id="<?php echo $ver[0]; ?>">
                    <td><?php echo (trim($ver[0]) !== '') ? $ver[0] : '-'; ?></td>
                    <td><?php echo (trim($ver[9]) !== '') ? $ver[9] : '-'; ?></td>
                    <td><?php echo (trim($ver[4]) !== '') ? $ver[4] : '-'; ?></td>
                    <td><?php echo (trim($ver[1]) !== '') ? $ver[1] : '-'; ?></td>
                    <td><?php echo (trim($ver[5]) !== '') ? $ver[5] : '-'; ?></td>
                    <td><?php echo (trim($ver[6]) !== '') ? $ver[6] : '-'; ?></td>
                    <td><?php echo (trim($ver[7]) !== '') ? $ver[7] : '-'; ?></td>
                    <td><?php echo (trim($ver[10]) !== '') ? $ver[10] : '-'; ?></td>
                    <td><?php echo (trim($ver[3]) !== '') ? $ver[3] : '-'; ?></td>
                    <td><?php echo $ver[11] ? 'Activo' : 'Inactivo'; ?></td>
                    <td><?php echo (trim($ver[8]) !== '') ? $ver[8] : '-'; ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="cambiarEstado('<?php echo $ver[0]; ?>', <?php echo $ver[11] ? 'true' : 'false'; ?>)">
                            <?php echo $ver[11] ? 'Desactivar' : 'Activar'; ?>
                        </button>

                    </td>
                    <td>
                        <span data-toggle="modal" data-target="#ajustarProducto" class="btn btn-warning btn-xs" onclick="ajustarProducto('<?php echo $ver[0]; ?>')">
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
        var table = $('#tabla-productos').DataTable({
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
        $('#tabla-productos thead input').on('keyup change', function() {
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
    #tabla-productos_filter.text-right {
        text-align: right;
        padding-right: 548px;
    }

    .resaltar {
        background-color: #ffa8b0 !important;
        /* Tono de lila más oscuro */
    }

    /* Alinear horizontalmente el campo de búsqueda */
    #tabla-productos_filter.text-center {
        text-align: center;
        padding-right: 0;
    }

    /* Estilo para colocar el texto del filtro en la fila adecuada */
    #tabla-productos thead th {
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
    #tabla-productos thead th .filtro-input {
        background-color: #ccc;
    }

    #tabla-productos thead th input {
        border-radius: 4px;
    }

    /* Ajustes adicionales para emular el estilo proporcionado */
    #tabla-productos_filter input {
        min-width: 0;
        max-width: none;
        width: 100%;
        background-color: #ccc;
    }

    #tabla-productos thead th .filtro-input {
        max-width: none;
        width: 100%;
    }
</style>