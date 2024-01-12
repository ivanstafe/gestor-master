<?php
require_once "../../clases/Conexion.php";
$con = new conectar();
$conexion = $con->conexion();
session_start();

$sql = "SELECT gas.nombre,
        gas.descripcion,
        gas.cantidad,
        gas.precio,
        IFNULL(cat.nombre, 'No disponible') AS nombre_categoria,
        gas.id_gasto,
        gas.fecha_gasto,
        gas.metodo_pago,
        gas.numero_factura,
        gas.estado_pago 
        FROM gastos AS gas
        LEFT JOIN categoriasGastos AS cat ON gas.id_categoria = cat.id_categoria";

$result = mysqli_query($conexion, $sql);
?>

<div style="margin-top: 20px;"></div>

<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered" style="text-align: center;" id="tabla-gastos">
        <thead>
            <tr>
                <th>Nombre <br> <input type="text" id="filtro-nombre" class="filtro-input"></th>
                <th>Descripcion <br> <input type="text" id="filtro-descripcion" class="filtro-input"></th>
                <th>Cantidad <br> <input type="text" id="filtro-cantidad" class="filtro-input"></th>
                <th>Precio <br> <input type="text" id="filtro-precio" class="filtro-input"></th>
                <th>Categoria <br> <input type="text" id="filtro-categoria" class="filtro-input"></th>
                <th>Fecha <br> <input type="text" id="filtro-fecha" class="filtro-input"></th>
                <th>Metodo pago <br> <input type="text" id="filtro-metodo-pago" class="filtro-input"></th>
                <th>Numero factura <br> <input type="text" id="filtro-nfactura" class="filtro-input"></th>
                <th>Estado pago <br> <input type="text" id="filtro-estado" class="filtro-input"></th>
                <th>Actualizar</th>
            </tr>
        </thead>
        <tbody>
            <?php mysqli_data_seek($result, 0); // Reiniciar el puntero de la consulta 
            ?>

            <?php while ($ver = mysqli_fetch_assoc($result)) : ?>
                <tr class="gasto-row" id="<?php echo $ver['id_gasto']; ?>">
                    <td><?php echo $ver['nombre']; ?></td>
                    <td><?php echo $ver['descripcion']; ?></td>
                    <td><?php echo $ver['cantidad']; ?></td>
                    <td><?php echo $ver['precio']; ?></td>
                    <td><?php echo $ver['nombre_categoria']; ?></td>
                    <td><?php echo $ver['fecha_gasto']; ?></td>
                    <td><?php echo $ver['metodo_pago']; ?></td>
                    <td><?php echo $ver['numero_factura']; ?></td>
                    <td><?php echo $ver['estado_pago']; ?></td>

                    <td>
                        <span data-toggle="modal" data-target="#actualizarGasto" class="btn btn-warning btn-xs" onclick="actualizarDatosGasto('<?php echo $ver['id_gasto']; ?>')">
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
        var table = $('#tabla-gastos').DataTable({
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
        $('#tabla-gastos thead input').on('keyup change', function() {
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
    #tabla-gastos_filter.text-right {
        text-align: right;
        padding-right: 548px;
    }

    .resaltar {
        background-color: #ffa8b0 !important;
        /* Tono de lila más oscuro */
    }

    /* Alinear horizontalmente el campo de búsqueda */
    #tabla-gastos_filter.text-center {
        text-align: center;
        padding-right: 0;
    }

    /* Estilo para colocar el texto del filtro en la fila adecuada */
    #tabla-gastos thead th {
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
    #tabla-gastos thead th .filtro-input {
        background-color: #ccc;
    }

    #tabla-gastos thead th input {
        border-radius: 4px;
    }

    /* Ajustes adicionales para emular el estilo proporcionado */
    #tabla-gastos_filter input {
        min-width: 0;
        max-width: none;
        width: 100%;
        background-color: #ccc;
    }

    #tabla-gastos thead th .filtro-input {
        max-width: none;
        width: 100%;
    }
</style>