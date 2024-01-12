<?php
require_once "../../clases/Conexion.php";
$con = new conectar();
$conexion = $con->conexion();
session_start();
$sql = "SELECT 
ins.nombre,
ins.descripcion,
SUM(inv.cantidad) AS total_cantidad,
ins.precio,
img.ruta,
IFNULL(cat.nombre, 'No disponible') AS categoria,
IFNULL(prov.razon_social, 'No disponible') AS proveedor,
ins.id_insumo
FROM 
insumos AS ins 
INNER JOIN 
imagenesInsumos AS img ON ins.id_imagen = img.id_imagen
LEFT JOIN 
categoriasInsumos AS cat ON ins.id_categoria = cat.id_categoria
LEFT JOIN 
proveedores AS prov ON ins.id_proveedor = prov.id_proveedor
LEFT JOIN 
inventario_insumos AS inv ON ins.id_insumo = inv.id_insumo
WHERE
ins.estado = true
GROUP BY
ins.id_insumo
HAVING
total_cantidad > 0";
$result = mysqli_query($conexion, $sql);

$mostrarActualizar = false; // Variable para controlar la visibilidad de la columna "Actualizar"

// Verificación del tipo de usuario para mostrar u ocultar la columna "Actualizar"
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
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered" style="text-align: center;" id="tabla-insumos">
        <thead>
            <tr>
                <th>Nombre <br> <input type="text" id="filtro-nombre" class="filtro-input"></th>
                <th>Descripcion <br> <input type="text" id="filtro-descripcion" class="filtro-input"></th>
                <th>Cantidad <br> <input type="text" id="filtro-cantidad" class="filtro-input"></th>
                <th>Precio <br> <input type="text" id="filtro-precio" class="filtro-input"></th>
                <th>Imagen</th>
                <th>Categoria <br> <input type="text" id="filtro-categoria" class="filtro-input"></th>
                <th>Proveedor <br> <input type="text" id="filtro-proveedor" class="filtro-input"></th>
                <th>Actualizar</th>
            </tr>
        </thead>
        <tbody>
            <?php mysqli_data_seek($result, 0); ?>

            <?php while ($ver = mysqli_fetch_row($result)) : ?>
                <tr class="insumo-row <?php echo ($ver[2] < 5) ? 'resaltar' : ''; ?>" id="<?php echo $ver[7]; ?>">
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
                    <td><?php echo $ver[6]; ?></td>
                    <td>
                        <span data-toggle="modal" data-target="#actualizarInsumo" class="btn btn-warning btn-xs" onclick="actualizarDatosInsumo('<?php echo $ver[7]; ?>')">
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
        var table = $('#tabla-insumos').DataTable({
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
        $('#tabla-insumos thead input').on('keyup change', function() {
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
    #tabla-insumos_filter.text-right {
        text-align: right;
        padding-right: 548px;
    }

    .resaltar {
        background-color: #ffa8b0 !important;
        /* Tono de lila más oscuro */
    }

    /* Alinear horizontalmente el campo de búsqueda */
    #tabla-insumos_filter.text-center {
        text-align: center;
        padding-right: 0;
    }

    /* Estilo para colocar el texto del filtro en la fila adecuada */
    #tabla-insumos thead th {
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
    #tabla-insumos thead th .filtro-input {
        background-color: #ccc;
    }

    #tabla-insumos thead th input {
        border-radius: 4px;
    }

    /* Ajustes adicionales para emular el estilo proporcionado */
    #tabla-insumos_filter input {
        min-width: 0;
        max-width: none;
        width: 100%;
        background-color: #ccc;
    }

    #tabla-insumos thead th .filtro-input {
        max-width: none;
        width: 100%;
    }
</style>