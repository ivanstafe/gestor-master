<?php
require_once "../../clases/Conexion.php";
require_once "../../clases/Ventas.php";

$c = new conectar();
$conexion = $c->conexion();

$obj = new ventas();

$sql = "SELECT cr.id,
                   cr.fecha,
                   cr.cliente_id,
                   c.nombre as nombre_cliente,
                   c.apellido as apellido_cliente
            FROM cabecera_remito cr
            INNER JOIN clientes c ON cr.cliente_id = c.id_cliente
            GROUP BY cr.id";

$result = mysqli_query($conexion, $sql);
?>


<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">

            <table class="table table-hover table-condensed table-bordered" style="text-align: center;" id="tabla-ventas">
                <thead>
                    <tr>
                        <th style="text-align: center;">Folio <br> <input type="text" id="" class="filtro-input"></th>
                        <th style="text-align: center;">Fecha <br> <input type="text" id="" class="filtro-input"></th>
                        <th style="text-align: center;">Cliente <br> <input type="text" id="" class="filtro-input"></th>
                        <th style="text-align: center;">Total de compra <br> <input type="text" id="" class="filtro-input"></th>
                        <th style="text-align: center;">Remitos</th>
                    </tr>


                </thead>
                <tbody>
                    <?php while ($ver = mysqli_fetch_row($result)) : ?>
                        <tr>
                            <td><?php echo $ver[0] ?></td>
                            <td><?php echo $ver[1] ?></td>
                            <td>
                                <?php
                                echo $ver[3] . ' ' . $ver[4]; // Mostrar el nombre del cliente directamente desde la consulta
                                ?>
                            </td>
                            <td>
                                <?php
                                echo "$" . $obj->obtenerTotal($ver[0]);
                                ?>
                            </td>
                            <td>
                                <a href="../acciones/ventas/crearTicketPdf.php?id=<?php echo $ver[0] ?>" class="btn btn-success btn-sm">
                                    Generar <span class="glyphicon glyphicon-list-alt"></span>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Inicializar DataTables
        var table = $('#tabla-ventas').DataTable({
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
        $('#tabla-ventas thead input').on('keyup change', function() {
            var columnIndex = $(this).closest('th').index();
            table
                .column(columnIndex)
                .search(this.value)
                .draw();
        });
    });
</script>
<style>
    /* Reducir el tamaño de las celdas */
    .table td {
        max-width: 100px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Alinear el campo de búsqueda horizontalmente */
    #tabla-ventas_filter.text-right {
        text-align: right;
        padding-right: 548px;
    }

    .resaltar {
        background-color: #ffa8b0 !important;
    }

    /* Alinear horizontalmente el campo de búsqueda */
    #tabla-ventas_filter.text-center {
        text-align: center;
        padding-right: 0;
    }

    /* Estilo para colocar el texto del filtro en la fila adecuada */
    #tabla-ventas thead th {
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
    #tabla-ventas thead th .filtro-input {
        background-color: #ccc;
    }

    #tabla- thead th input {
        border-radius: 4px;
    }

    /* Ajustes adicionales para emular el estilo proporcionado */
    #tabla-ventas_filter input {
        min-width: 0;
        max-width: none;
        width: 100%;
        background-color: #ccc;
    }

    #tabla-ventas thead th .filtro-input {
        max-width: none;
        width: 100%;
    }
</style>