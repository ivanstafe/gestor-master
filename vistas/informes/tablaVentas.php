<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de Barras SVG</title>
    <script src="https://d3js.org/d3.v5.min.js"></script> <!-- librería D3.js -->
</head>

<?php
require_once "../../clases/Conexion.php";
$con = new conectar();
$conexion = $con->conexion();
$sql = "SELECT c.id AS id_remito, CONCAT(cl.nombre, ' ' , cl.apellido) AS cliente, p.nombre AS producto, d.cantidad AS cantidad, d.importe, c.fecha
        FROM cabecera_remito c
        INNER JOIN detalle_remito d ON c.id = d.cabecera_remito_id
        INNER JOIN productos p ON d.producto_id = p.id_producto
        INNER JOIN clientes cl ON c.cliente_id = cl.id_cliente
        GROUP BY c.id, p.nombre"; // Agrupar por ID del remito y nombre del producto
$result = mysqli_query($conexion, $sql);
?>

<div class="table-responsive">
    <label>Filtrar por fecha:</label>
    <br>
    <small>Fecha de inicio</small>
    <input type="date" class="form-control" id="fechaInicio" placeholder="Fecha inicio">
    <small>Fecha de fin</small>
    <input type="date" class="form-control" id="fechaFin" placeholder="Fecha fin">
    <div style="margin-top: 20px;"></div>
    <table class="table table-hover table-condensed table-bordered" style="text-align: center;" id="tabla-ventas">

        <thead>
            <tr>
                <th style="text-align: center;">Remito N° <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Cliente <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Producto <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Cantidad <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Precio <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Fecha Remito <br> <input type="text" class="filtro-input"></th>
            </tr>

        </thead>
        <tbody>
            <?php
            $totalCantidad = 0;
            $totalPrecio = 0;
            while ($ver = mysqli_fetch_assoc($result)) :
                $totalCantidad += $ver['cantidad'];
                $totalPrecio += $ver['cantidad'] * $ver['importe'];
            ?>
                <tr class="venta-row">
                    <td><?php echo (trim($ver['id_remito']) !== '') ? $ver['id_remito'] : '-'; ?></td>
                    <td><?php echo (trim($ver['cliente']) !== '') ? $ver['cliente'] : '-'; ?></td>
                    <td><?php echo (trim($ver['producto']) !== '') ? $ver['producto'] : '-'; ?></td>
                    <td><?php echo (trim($ver['cantidad']) !== '') ? $ver['cantidad'] : '-'; ?></td>
                    <td><?php echo (trim($ver['importe']) !== '') ? $ver['importe'] : '-'; ?></td>
                    <td><?php echo (trim($ver['fecha']) !== '') ? $ver['fecha'] : '-'; ?></td>
                </tr>

            <?php endwhile; ?>
        </tbody>
        <!-- Agregar la fila de totales en el footer de la tabla -->
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><span id="total-cantidad"><?php echo $totalCantidad; ?></span></td>
                <td><span id="total-precio"><?php echo $totalPrecio; ?></span></td>
                <td></td>
            </tr>
        </tfoot>

    </table>
</div>


<svg width="800" height="400" id="grafico-barras"></svg>

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
        // // Agregar el identificador "search-box" al campo de búsqueda
        // $('#tabla-insumos_filter input').attr('id', 'search-box');

        // // Alinear horizontalmente el campo de búsqueda
        // $('#tabla-insumos_filter').addClass('text-right');

        // Escuchar el evento de búsqueda
        $('#tabla-ventas').on('search.dt', function() {
            recalcularTotales(); // Llama a la función de recálculo cuando se realiza una búsqueda
        });

        // Escuchar el evento de cambio de fecha
        $('#fechaInicio, #fechaFin').on('change', function() {
            recalcularTotales();
        });
        totalOriginalCantidad = parseFloat($('#total-cantidad').text());
        totalOriginalPrecio = parseFloat($('#total-precio').text());
        // Calcular totales inicialmente
        recalcularTotales();
    });

    function recalcularTotales() {
        var totalCantidad = 0;
        var totalPrecio = 0;

        var fechaInicio = $('#fechaInicio').val();
        var fechaFin = $('#fechaFin').val();

        $('#tabla-ventas tbody tr:visible').each(function() {
            var fechaGasto = $(this).find('td:eq(5)').text();

            // Verificar si la fecha está dentro del rango especificado
            if ((fechaInicio === '' || fechaGasto >= fechaInicio) && (fechaFin === '' || fechaGasto <= fechaFin)) {
                var cantidad = parseFloat($(this).find('td:eq(3)').text());
                var precioText = $(this).find('td:eq(4)').text().replace('$', '').replace(',', '');
                var precio = parseFloat(precioText);

                totalCantidad += cantidad;
                totalPrecio += cantidad * precio;

                $(this).show();
            } else {
                $(this).hide();
            }
        });
        // Actualizar totales
        $('#total-cantidad').text(totalCantidad.toFixed(2));
        $('#total-precio').text(totalPrecio.toFixed(2));

        var datosGrafico = obtenerDatosGrafico();
        dibujarGraficoBarras(datosGrafico);
    }
    // Función para obtener los datos del gráfico de barras
    function obtenerDatosGrafico() {
        var datos = [];
        var filasVisibles = $('#tabla-ventas tbody tr:visible');
        console.log('Obtener datos del gráfico ejecutado');

        console.log('Número de filas visibles:', filasVisibles.length);

        // Iterar a través de todas las filas de la tabla visible
        $('#tabla-ventas tbody tr:visible').each(function() {
            var nombre = $(this).find('td:eq(2)').text(); // Corregido a 'td:eq(1)'
            var cantidad = parseFloat($(this).find('td:eq(3)').text().replace('$', '').replace(',', '')); // Corregido a 'td:eq(2)'
            datos.push({
                nombre: nombre,
                cantidad: cantidad

            });
        });
        console.log('Datos para el gráfico:', datos);
        return datos;
    }


    function dibujarGraficoBarras(datos) {

        console.log('Datos recibidos para dibujar el gráfico:', datos);


        var svg = d3.select("#grafico-barras");
        svg.selectAll("*").remove();

        var ancho = 800;
        var alto = 400;

        var svg = d3.select("#grafico-barras")
            .attr("width", ancho)
            .attr("height", alto);

        // márgenes
        var margen = {
            superior: 100,
            derecho: 100,
            inferior: 100,
            izquierdo: 100
        };
        var anchoGrafico = ancho - margen.izquierdo - margen.derecho;
        var altoGrafico = alto - margen.superior - margen.inferior;


        var escalaX = d3.scaleBand()
            .domain(datos.map(function(d) {
                return d.nombre;
            }))
            .range([0, anchoGrafico])
            .padding(0.1);

        // Escala Y
        var escalaY = d3.scaleLinear()
            .domain([0, d3.max(datos, function(d) {
                return d.cantidad;
            })])
            .nice()
            .range([altoGrafico, 0]);

        var g = svg.append("g")
            .attr("transform", "translate(" + margen.izquierdo + "," + margen.superior + ")");

        // Barras
        g.selectAll("rect")
            .data(datos)
            .enter().append("rect")
            .attr("x", function(d) {
                return escalaX(d.nombre);
            })
            .attr("y", function(d) {
                return escalaY(d.cantidad);
            })
            .attr("width", escalaX.bandwidth())
            .attr("height", function(d) {
                return altoGrafico - escalaY(d.cantidad);
            })
            .attr("fill", "steelblue");


        g.append("g")
            .attr("class", "eje-x")
            .attr("transform", "translate(0," + altoGrafico + ")")
            .call(d3.axisBottom(escalaX))
            .selectAll("text")
            .attr("dy", "0.5em")
            .attr("transform", "rotate(-45)")
            .style("text-anchor", "end");


        g.append("g")
            .attr("class", "eje-y")
            .call(d3.axisLeft(escalaY).ticks(5));


        g.append("text")
            .attr("class", "etiqueta-eje-y")
            .attr("transform", "rotate(-90)")
            .attr("y", 0 - margen.izquierdo)
            .attr("x", 0 - altoGrafico / 2)
            .attr("dy", "1em")
            .style("text-anchor", "middle")
            .text("Cantidad");


        svg.append("text")
            .attr("x", (ancho / 2))
            .attr("y", margen.superior / 2)
            .attr("text-anchor", "middle")
            .style("font-size", "16px")
            .text("Gráfico de Barras de Productos Mas Vendidos");
    }
    // Fin grafico


    $('#fechaInicio, #fechaFin').on('change', function() {
        recalcularTotales();
    });
</script>



<style>
    /* Alinear el campo de búsqueda horizontalmente */
    #tabla-ventas_filter.text-right {
        text-align: right;
        padding-right: 548px;
    }

    .resaltar {
        background-color: #ffa8b0 !important;
        /* Tono de lila más oscuro */
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
    #tabla-ventas thead th .filtro-input {
        background-color: #ccc;
    }

    #tabla-ventas thead th input {
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
</body>

</html>