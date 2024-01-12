<?php
session_start();
require_once "../../clases/Conexion.php";
$con = new conectar();
$conexion = $con->conexion();
$sql = "SELECT
pro.nombre,
pro.descripcion,
SUM(inv.cantidad) AS total_cantidad,
pro.precio,
ima.ruta,
IFNULL(cat.nombre, 'No disponible') AS nombre_categoria,
pro.id_producto
FROM
productos AS pro
INNER JOIN
imagenes AS ima ON pro.id_imagen = ima.id_imagen
LEFT JOIN
categoriasProductos AS cat ON pro.id_categoria = cat.id_categoria
LEFT JOIN
inventario_productos AS inv ON pro.id_producto = inv.id_producto
WHERE
pro.estado = true
GROUP BY
pro.id_producto
HAVING
total_cantidad > 0";
$result = mysqli_query($conexion, $sql);

$mostrarActualizar = false;
if (isset($_SESSION['nombre'])) {
    $nombreUsuario = $_SESSION['nombre'];
    $sql_tipo = "SELECT tipo FROM usuarios WHERE nombre = '$nombreUsuario'";
    $result_tipo = mysqli_query($conexion, $sql_tipo);

    if ($result_tipo && mysqli_num_rows($result_tipo) > 0) {
        $fila_tipo = mysqli_fetch_assoc($result_tipo);
        $_SESSION['tipo'] = $fila_tipo['tipo'];
        if ($_SESSION['tipo'] === 'Administrador') {
            $mostrarActualizar = true;
        }
    }
}
?>

<div style="margin-top: 20px;"></div>
<div class="">
    <table class="table table-hover table-condensed table-bordered" style="text-align: center;" id="tabla-productos">

        <thead>
            <tr>
                <th style="text-align: center;">Nombre <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Descripción <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Cantidad <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Precio <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Imagen</th>
                <th style="text-align: center;">Categoría <br> <input type="text" class="filtro-input"></th>
                <th style="text-align: center;">Actualizar</th>

            </tr>
        </thead>
        <tbody>
            <?php while ($ver = mysqli_fetch_row($result)) : ?>
                <tr class="producto-row <?php echo ($ver[2] < 5) ? 'resaltar' : ''; ?>" id="<?php echo $ver[6]; ?>">
                    <td><?php echo $ver[0]; ?></td>
                    <td><?php echo $ver[1]; ?></td>
                    <td><?php echo $ver[2]; ?></td>
                    <td><?php echo $ver[3]; ?></td>
                    <td>
                        <?php
                        $imgVer = explode("/", $ver[4]);
                        $imgruta = $imgVer[1] . "/" . $imgVer[2] . "/" . $imgVer[3];
                        ?>
                        <img width="60" height="80" src="<?php echo $imgruta ?>">
                    </td>
                    <td><?php echo $ver[5]; ?></td>
                    <td>
                        <span data-toggle="modal" data-target="#actualizarProducto" class="btn btn-warning btn-xs" onclick="actualizarDatosProducto('<?php echo $ver[6]; ?>')">
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

    /* Resaltar filas con cantidad menor a 5 */
    .resaltar {
        background-color: #ffa8b0 !important;
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