<?php
require_once "../../clases/Conexion.php";
$con = new conectar();
$conexion = $con->conexion();
session_start();

$sql = "SELECT id_categoria, nombre FROM categoriasGastos";
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
<div class="table-container" style="margin-left: auto; margin-right: auto;">
    <table class="table table-hover table-condensed table-bordered" style="text-align: center;" id="tabla-categoriaGastos">
        <thead>
            <tr>
                <th style="text-align: center;">Categoria</th>
                <th style="background: color #333;;">Actualizar</th>
            </tr>
            <tr>
                <th class="filter"><input type="text" id="filtro-categoria"></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php mysqli_data_seek($result, 0); ?>
            <?php while ($ver = mysqli_fetch_row($result)) : ?>
                <tr class="categoria-row" id="<?php echo $ver[0]; ?>">
                    <td><?php echo $ver[1] ?></td>
                    <td>
                        <span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#actualizaCategoria" onclick="editaCategoria('<?php echo $ver[0]; ?>','<?php echo $ver[1]; ?>')">
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
        var table = $('#tabla-categoriaGastos').DataTable({
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

        // Deshabilitar inputs de búsqueda de DataTables (excepto el primero)
        $('#tabla-categoriaGastos thead input').not('#filtro-categoria').prop('disabled', true);

        // Aplicar la búsqueda individual en el primer input
        $('#filtro-categoria').on('keyup change', function() {
            if (table.search() !== this.value) {
                table
                    .search(this.value)
                    .draw();
            }
        });
    });
</script>

<style>
    /* Estilo para ajustar el ancho de los filtros de búsqueda */
    #tabla-categoriaGastos input {
        max-width: 100px;
        text-align: center;
        margin-bottom: 0.5em;
        border: 1px solid #ccc;
        background-color: #eee;
        color: black;
        padding: 4px;
        font-size: 12px;
    }

    /* Estilo específico para el input de filtro */
    #tabla-categoriaGastos_filter input {
        background-color: #ccc;
    }

    #filtro-categoria {
        max-width: 100px;
        text-align: center;
        margin-bottom: 0.5em;
        border: 1px solid #ccc;
        background-color: #eee;
        color: black;
        padding: 4px;
        font-size: 12px;
    }

    /* Estilo para colocar el texto del filtro en la fila adecuada */
    #tabla-categoriaGastos thead th {
        position: relative;
        text-align: center;
        background-color: #333;
        border: 1px solid #333;
        color: white;
    }

    #tabla-categoriaGastos thead th div {
        margin-bottom: 0.5em;
    }

    #tabla-categoriaGastos thead th input {
        position: absolute;
        width: calc(100% - 1em);
        box-sizing: border-box;
        margin: -17px;
        margin-left: -50px;
        border-radius: 4px;
    }

    /* Ajustar el ancho mínimo y máximo de los filtros */
    #tabla-categoriaGastos_filter input {
        min-width: 0;
        max-width: none;
        width: 100%;
    }

    /* Estilo para filas de datos */
    #tabla-categoriaGastos tbody tr {
        background-color: #fff;
        /* Color de fondo blanco */
        color: #000;
        /* Color del texto negro */
    }

    /* Ocultar el campo de búsqueda de DataTables */
    .dataTables_filter {
        display: none;
    }
</style>