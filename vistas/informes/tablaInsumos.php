<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de Barras SVG</title>
    <script src="https://d3js.org/d3.v5.min.js"></script> <!-- librería D3.js -->
</head>

<body>
    <?php
    require_once "../../clases/Conexion.php";
    $con = new conectar();
    $conexion = $con->conexion();
    $sql = "SELECT 
    i.nombre AS Nombre,
    i.descripcion AS Descripción,
    inv.cantidad AS Cantidad,
    i.precio AS Precio,
    c.nombre AS Categoría,
    i.id_insumo,
    i.fechaCaptura AS Fecha,
    p.razon_social AS Proveedor,
    inv.metodo_pago,
    inv.numero_factura,
    inv.estado_pago
FROM 
    insumos i
INNER JOIN 
    categoriasInsumos c ON i.id_categoria = c.id_categoria
INNER JOIN 
    proveedores p ON i.id_proveedor = p.id_proveedor
INNER JOIN
    inventario_insumos inv ON i.id_insumo = inv.id_insumo
ORDER BY 
    i.id_insumo;

";
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
        <table class="table table-hover table-condensed table-bordered" style="text-align: center;" id="tabla-insumos">

            <thead>
                <tr>
                    <th style="text-align: center;">Nombre</th>
                    <th style="text-align: center;">Descripción</th>
                    <th style="text-align: center;">Cantidad</th>
                    <th style="text-align: center;">Precio</th>
                    <th style="text-align: center;">Categoría</th>
                    <th style="text-align: center;">Fecha</th>
                    <th style="text-align: center;">Proveedor</th>
                    <th style="text-align: center;">Metodo de pago</th>
                    <th style="text-align: center;">Numero de factura</th>
                    <th style="text-align: center;">Estado de pago</th>
                </tr>
                <tr>
                    <th><input type="text" class="input-1"></th>
                    <th><input type="text" class="input-2"></th>
                    <th><input type="text" class="input-3"></th>
                    <th><input type="text" class="input-4"></th>
                    <th><input type="text" class="input-5"></th>
                    <th><input type="text" class="input-6"></th>
                    <th><input type="text" class="input-7"></th>
                    <th><input type="text" class="input-8"></th>
                    <th><input type="text" class="input-9"></th>
                    <th><input type="text" class="input-10"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalCantidad = 0;
                $totalPrecio = 0;
                while ($ver = mysqli_fetch_row($result)) :
                    $totalCantidad += $ver[2];
                    $totalPrecio += $ver[2] * $ver[3];
                ?>
                    <tr class="insumo-row" id="<?php echo $ver[5]; ?>" <?php echo ($ver[2] < 0) ? 'style="background-color: #fff4c2;"' : ''; ?>>
    <td><?php echo trim($ver[0]) !== '' ? $ver[0] : '-'; ?></td>
    <td><?php echo trim($ver[1]) !== '' ? $ver[1] : '-'; ?></td>
    <td><?php echo trim($ver[2]) !== '' ? $ver[2] : '-'; ?></td>
    <td><?php echo trim($ver[3]) !== '' ? $ver[3] : '-'; ?></td>
    <td><?php echo trim($ver[4]) !== '' ? $ver[4] : '-'; ?></td>
    <td><?php echo trim($ver[6]) !== '' ? $ver[6] : '-'; ?></td>
    <td><?php echo trim($ver[7]) !== '' ? $ver[7] : '-'; ?></td>
    <td><?php echo trim($ver[8]) !== '' ? $ver[8] : '-'; ?></td>
    <td><?php echo trim($ver[9]) !== '' ? $ver[9] : '-'; ?></td>
    <td><?php echo trim($ver[10]) !== '' ? $ver[10] : '-'; ?></td>
</tr>




                <?php endwhile; ?>
            </tbody>
            <!-- Agregar la fila de totales en el footer de la tabla -->
            <tfoot>
                <tr>
                    <td colspan="2"><strong>Totales:</strong></td>
                    <td><span id="total-cantidad"><?php echo $totalCantidad; ?></span></td>
                    <td><span id="total-precio"><?php echo $totalPrecio; ?></span></td>
                    <td colspan="6"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <svg width="400" height="300" id="grafico-barras"></svg>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            var tabla = $('#tabla-insumos').DataTable({
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

            // Inicializar filtros individuales por columna
            $('#tabla-insumos thead th').each(function() {
                var title = $(this).text();
                $(this).html('<div>' + title + '</div>');
            });

            $('#tabla-insumos thead tr:eq(1) th').each(function() {
                $(this).append('<input type="text" placeholder="' + $(this).text() + '">');
            });

            // Aplicar la búsqueda individual en cada columna
            tabla.columns().every(function() {
                var that = this;

                $('input', this.header()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                        recalcularTotales(); // Actualizar totales al cambiar los filtros
                    }
                });
            });

            // Escuchar el evento de cambio de fecha
            $('#fechaInicio, #fechaFin').on('change', function() {
                recalcularTotales();
            });

            // Calcular totales inicialmente
            recalcularTotales();
        });

        // Función para recalcular totales
        function recalcularTotales() {
            var totalCantidad = 0;
            var totalPrecio = 0;

            var fechaInicio = $('#fechaInicio').val();
            var fechaFin = $('#fechaFin').val();

            $('#tabla-insumos tbody tr').each(function() {
                var fechaGasto = $(this).find('td:eq(5)').text();

                if ((fechaInicio === '' || fechaGasto >= fechaInicio) && (fechaFin === '' || fechaGasto <= fechaFin)) {
                    var cantidad = parseFloat($(this).find('td:eq(2)').text());
                    var precioText = $(this).find('td:eq(3)').text().replace('$', '').replace(',', '');
                    var precio = parseFloat(precioText);

                    totalCantidad += cantidad;
                    totalPrecio += cantidad * precio;

                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            $('#total-cantidad').text(totalCantidad.toFixed(2));
            $('#total-precio').text(totalPrecio.toFixed(2));

            // Obtener datos del gráfico solo con respecto a los filtros de fecha
            var datosGrafico = obtenerDatosGrafico();
            console.log('Datos obtenidos:', datosGrafico);
            dibujarGraficoBarras(datosGrafico);
        }


        // Función para obtener datos del gráfico de barras
        function obtenerDatosGrafico() {
            var datos = [];
            $('#tabla-insumos tbody tr:visible').each(function() {
                var nombre = $(this).find('td:eq(0)').text();
                var precio = parseFloat($(this).find('td:eq(3)').text().replace('$', '').replace(',', ''));
                datos.push({
                    nombre: nombre,
                    precio: precio
                });
            });
            console.log('Datos para el gráfico:', datos);
            return datos;
        }

        // Función para dibujar el gráfico de barras
        function dibujarGraficoBarras(datos) {
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

            var escalaY = d3.scaleLinear()
                .domain([0, d3.max(datos, function(d) {
                    return d.precio;
                })])
                .nice()
                .range([altoGrafico, 0]);

            var g = svg.append("g")
                .attr("transform", "translate(" + margen.izquierdo + "," + margen.superior + ")");

            g.selectAll("rect")
                .data(datos)
                .enter().append("rect")
                .attr("x", function(d) {
                    return escalaX(d.nombre);
                })
                .attr("y", function(d) {
                    return escalaY(d.precio);
                })
                .attr("width", escalaX.bandwidth())
                .attr("height", function(d) {
                    return altoGrafico - escalaY(d.precio);
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
                .text("Precio");

            svg.append("text")
                .attr("x", (ancho / 2))
                .attr("y", margen.superior / 2)
                .attr("text-anchor", "middle")
                .style("font-size", "16px")
                .text("Gráfico de Barras de Precios de Gastos");
        }
    </script>

    <style>
        #tabla-insumos input {
            max-width: 90px;
            text-align: center;
            margin-bottom: 0.5em;
            border: 1px solid #ccc;
            background-color: #eee;
            color: black;
            padding: 4px;
            font-size: 13px;
        }


        #tabla-insumos_filter input {
            background-color: #ccc;
        }


        #tabla-insumos thead th {
            position: relative;
            text-align: center;
            background-color: #333;
            border: 1px solid #333;
            color: white;
        }

        #tabla-insumos thead th div {
            margin-bottom: 0.5em;
        }

        #tabla-insumos thead th input {
            position: absolute;
            width: calc(100% - 1em);
            box-sizing: border-box;
            margin: -17px;
            margin-left: -50px;
            border-radius: 4px;
        }


        #tabla-insumos_filter input {
            min-width: 0;
            max-width: none;
            width: 100%;
        }


        #tabla-insumos tbody tr {
            background-color: #fff;
            color: #000;
        }

        /* Ocultar el campo de búsqueda de DataTables */
        .dataTables_filter {
            display: none;
        }
    </style>
</body>

</html>