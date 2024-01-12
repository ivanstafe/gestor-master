<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Productos</title>

</head>

<body>
    <?php
    require_once "../../clases/Conexion.php";
    $con = new conectar();
    $conexion = $con->conexion();
    $sql = "SELECT p.id_producto, p.nombre, p.descripcion, ip.cantidad, ip.precio, p.fechaCaptura
            FROM productos AS p
            INNER JOIN inventario_productos AS ip ON p.id_producto = ip.id_producto
            WHERE p.estado = TRUE;";
    $result = mysqli_query($conexion, $sql);
    ?>

    <div class="table-responsive">

        <div style="margin-top: 20px;"></div>
        <table class="table table-hover table-condensed table-bordered" style="text-align: left;" id="tabla-inventario">
            <thead>
                <tr>
                    <th style="text-align: center;">ID de producto <br> <input type="text" id="filtro-id" class="filtro-input"></th>
                    <th style="text-align: center;">Nombre <br> <input type="text" id="filtro-nombre" class="filtro-input"></th>
                    <th style="text-align: center;">Descripción <br> <input type="text" id="filtro-descripcion" class="filtro-input"></th>
                    <th style="text-align: center;">Cantidad <br> <input type="text" id="filtro-cantidad" class="filtro-input"></th>
                    <th style="text-align: center;">Precio <br> <input type="text" id="filtro-precio" class="filtro-input"></th>
                    <th style="text-align: center;">Fecha de Captura <br> <input type="text" id="filtro-fecha" class="filtro-input"></th>
                </tr>
            </thead>

            <tbody>
                <?php
                while ($producto = mysqli_fetch_assoc($result)) :
                    $id_producto = !empty($producto['id_producto']) ? $producto['id_producto'] : '-';
                    $nombre = !empty($producto['nombre']) ? $producto['nombre'] : '-';
                    $descripcion = !empty($producto['descripcion']) ? $producto['descripcion'] : '-';
                    $cantidad = !empty($producto['cantidad']) ? $producto['cantidad'] : '-';
                    $precio = !empty($producto['precio']) ? $producto['precio'] : '-';
                    $fechaCaptura = !empty($producto['fechaCaptura']) ? $producto['fechaCaptura'] : '-';
                ?>
                    <tr <?php echo ($cantidad < 0) ? 'style="background-color: #ccffcc;"' : ''; ?>>
                        <td><?php echo $id_producto; ?></td>
                        <td><?php echo $nombre; ?></td>
                        <td><?php echo $descripcion; ?></td>
                        <td><?php echo $cantidad; ?></td>
                        <td><?php echo $precio; ?></td>
                        <td><?php echo $fechaCaptura; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

            <tfoot>
                <tr id="total-cantidad" class="resaltar">
                    <td colspan="3" style="text-align: center;">
                        Estado Actual del Inventario:

                    </td>
                    <td> <span class="total-cantidad"></span></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#tabla-inventario').DataTable({
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
                },
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api();
                    var total = api.column(3, {
                        page: 'current'
                    }).data().reduce(function(a, b) {
                        return parseInt(a) + parseInt(b);
                    }, 0);

                    $('#total-cantidad .total-cantidad').text(total);

                    if (total < 5) {
                        $('#total-cantidad').addClass('resaltar');
                    } else {
                        $('#total-cantidad').removeClass('resaltar');
                    }
                }
            });

            // Agregar filtros por columna
            $('#filtro-id, #filtro-nombre, #filtro-descripcion, #filtro-cantidad, #filtro-precio, #filtro-fecha').on('keyup change', function() {
                var columnIndex = $(this).closest('th').index(); // Obtener el índice de la columna
                if (table.column(columnIndex).search() !== this.value) {
                    table
                        .column(columnIndex)
                        .search(this.value)
                        .draw();
                }
            });

            $('#tabla-inventario_filter input').attr('id', 'search-box');
            $('#tabla-inventario_filter').addClass('text-right');

            $('#fechaInicio, #fechaFin').on('change', function() {
                var fechaInicio = $('#fechaInicio').val();
                var fechaFin = $('#fechaFin').val();

                table.rows().every(function(index, element) {
                    var rowData = this.data(); // Datos de la fila actual
                    var fechaProducto = rowData[5]; // Fecha en la columna 5

                    // Verificar si la fecha está dentro del rango especificado
                    if ((fechaInicio === '' || fechaProducto >= fechaInicio) && (fechaFin === '' || fechaProducto <= fechaFin)) {
                        this.nodes().to$().show();
                    } else {
                        this.nodes().to$().hide();
                    }
                });
            });
        });
    </script>

    <style>
        .total-cantidad {
            font-weight: bold;
            margin-left: 5px;
        }

        #tabla-inventario th,
        #tabla-inventario td {
            text-align: center;
        }

        .resaltar {
            background-color: lightcoral !important;
        }

        /* Alinear horizontalmente el campo de búsqueda */
        #tabla-inventario_filter.text-center {
            text-align: center;
            padding-right: 0;
        }

        /* Estilo para colocar el texto del filtro en la fila adecuada */
        #tabla-inventario thead th {
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

        /* Resaltar filas con cantidad menor a 5 */
        .resaltar {
            background-color: lightcoral !important;
        }

        /* Ocultar el campo de búsqueda de DataTables */
        .dataTables_filter {
            display: none;
        }

        /* Estilo para los inputs de filtro */
        .filtro-input {
            max-width: 100px;
            text-align: center;
            margin-bottom: 0.5em;
            border: 1px solid #ccc;
            background-color: #eee;
            color: black;
            padding: 4px;
            font-size: 13px;
        }

        /* Estilo específico para el input de filtro en el encabezado */
        #tabla-inventario thead th .filtro-input {
            background-color: #ccc;
        }

        #tabla-inventario thead th input {
            border-radius: 4px;
        }

        /* Ajustes adicionales para emular el estilo proporcionado */
        #tabla-inventario_filter input {
            min-width: 0;
            max-width: none;
            width: 100%;
            background-color: #ccc;
        }

        #tabla-inventario thead th .filtro-input {
            max-width: none;
            width: 80%;
        }
    </style>


</body>

</html>