<!DOCTYPE html>
<html>

<head>
    <title>Nota de Crédito</title>
    <style type="text/css">
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table:first-of-type {
            page-break-after: always;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        thead {
            background-color: #f2f2f2;
        }

        tbody {
            font-size: 0.813rem;
        }

        .corner-image {
            float: left;
            max-width: 50px;
            margin-right: 10px;
        }

        .corner-text {
            float: right;
        }

        /* Estilos para la impresión */
        @media print {
            body {
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .duplicated-content {
                float: left;
                width: 50%;
            }
        }

        /* Fuera de cualquier otro bloque @media */
        @page {
            size: A4;
            /* Cambiar el tamaño de la página según tus necesidades */
        }
    </style>
</head>

<body>
    <?php
    require_once "../../clases/Conexion.php";
    require_once "../../clases/Ventas.php";

    $objv = new ventas();

    $c = new conectar();
    $conexion = $c->conexion();
    $id = $_GET['id'];

    $folio = '';
    $fecha = '';
    $nombreCliente = '';
    $apellidoCliente = '';
    $telefonoCliente = '';
    $direccionCliente = '';


    $sql = "SELECT
          c.id AS id_cabecera_nota_credito,
          c.fecha AS fecha_cabecera_nota_credito,
          c.cliente_id AS id_cliente,
          cl.nombre AS nombre_cliente,
          cl.apellido AS apellido_cliente,
          cl.telefono AS telefono_cliente,
          cl.direccion AS direccion_cliente,
          p.nombre AS nombre_producto,
          d.cantidad AS cantidad_producto,
          p.precio AS precio_producto,
          c.descuentos AS descuento_producto,
          p.descripcion AS descripcion_producto
         FROM
          cabecera_nota_credito c
         INNER JOIN
          detalle_nota_credito d ON c.id = d.cabecera_nota_credito_id
         INNER JOIN
          productos p ON d.producto_id = p.id_producto
         INNER JOIN
          clientes cl ON c.cliente_id = cl.id_cliente
         WHERE
          c.id = '$id';";

    $result = mysqli_query($conexion, $sql);

    $ver = mysqli_fetch_row($result);
    if ($ver !== null) {
        $folio = $ver[0];
        $fecha = $ver[1];
        $idcliente = $ver[2];
        $nombreCliente = $ver[3];
        $apellidoCliente = $ver[4];
        $telefonoCliente = $ver[5];
        $direccionCliente = $ver[6];
    } else {
        echo "No se encontraron resultados para el ID: $id";
    }

    ?>

    <table>
        <thead>
            <tr>
                <th></th>
                <!-- <th class="corner-image"><img src="../../foto.webp"></th> -->
                <th colspan="4" class="corner-text">
                    <h5>NOTA DE CRÉDITO ORIGINAL</h5>
                </th>
            </tr>
            <tr>
                <th colspan="3" class="corner-text">Código de Nota de Crédito: <?php echo $folio; ?></th>
                <th colspan="2" class="corner-text">Fecha: <?php echo $fecha; ?></th>
            </tr>
            <tr>
                <th colspan="2" class="corner-text">Cliente: <?php echo $nombreCliente . " " . $apellidoCliente; ?></th>
                <th colspan="2" class="corner-text">Teléfono: <?php echo $telefonoCliente; ?> </th>
                <th colspan="1" class="corner-text">Dirección: <?php echo $direccionCliente; ?></th>
            </tr>
            <tr>
                <th>Cantidad</th>
                <th>Producto</th>
                <th>P/Unitario</th>
                <th>Descuento</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT
                      c.id AS id_cabecera_nota_credito,
                      c.fecha AS fecha_cabecera_nota_credito,
                      c.cliente_id AS id_cliente,
                      p.nombre AS nombre_producto,
                      d.cantidad AS cantidad_producto,
                      p.precio AS precio_producto,
                      c.descuentos AS descuento_producto,
                      p.descripcion AS descripcion_producto,
                      d.importe
                     FROM
                      cabecera_nota_credito c
                     INNER JOIN
                      detalle_nota_credito d ON c.id = d.cabecera_nota_credito_id
                     INNER JOIN
                      productos p ON d.producto_id = p.id_producto
                     WHERE
                      c.id = '$id';";

            $result = mysqli_query($conexion, $sql);
            $totalFactura = 0;
            $totalDescuento = 0;

            while ($mostrar = mysqli_fetch_row($result)) {
                $descuento = $mostrar[6];
                $importe = $mostrar[8]; // Variable d.importe
                $totalFactura += floatval($importe); // Suma el importe como un número flotante

                // Añade el descuento al total de descuentos
                $totalDescuento += floatval($descuento);

            ?>
                <tr>
                    <td><?php echo $mostrar[4]; ?></td>
                    <td><?php echo $mostrar[3]; ?></td>
                    <td><?php echo $mostrar[5]; ?></td>
                    <td><?php echo $descuento; ?></td>
                    <td><?php echo $importe; ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td colspan="4">Total Nota de Crédito:</td>
                <td><?php echo "$" . number_format($totalFactura, 2); ?></td>
            </tr>
            <!-- <tr>
    <td colspan="4">Total Factura con Descuento:</td>
    <td></td>
</tr>
<tr> -->
            <td colspan="4" style="text-align: left-center;">
                <p style="width: 30%; margin-top: 10px;">Sello: </p>
            </td>
            <td colspan="1" style="text-align: left;">
                <p style="width: 70%;">Firma: </p>
            </td>
            </tr>

    </table>
    <table>
        <thead>
            <tr>
                <th></th>
                <!-- <th class="corner-image"><img src="{{../../imh.path() . '1espada-removebg-preview.jpg'}}"></th> -->
                <th colspan="4" class="corner-text">
                    <h5>NOTA DE CRÉDITO DUPLICADO</h5>
                </th>
            </tr>
            <tr>
                <th colspan="3" class="corner-text">Código de Nota de Crédito: <?php echo $folio; ?></th>
                <th colspan="2" class="corner-text">Fecha: <?php echo $fecha; ?></th>
            </tr>
            <tr>
                <th colspan="2" class="corner-text">Cliente: <?php echo $nombreCliente . " " . $apellidoCliente; ?></th>
                <th colspan="2" class="corner-text">Teléfono: <?php echo $telefonoCliente; ?> </th>
                <th colspan="1" class="corner-text">Dirección: <?php echo $direccionCliente; ?></th>
            </tr>
            <tr>
                <th>Cantidad</th>
                <th>Producto</th>
                <th>P/Unitario</th>
                <th>Descuento</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT
                      c.id AS id_cabecera_nota_credito,
                      c.fecha AS fecha_cabecera_nota_credito,
                      c.cliente_id AS id_cliente,
                      p.nombre AS nombre_producto,
                      d.cantidad AS cantidad_producto,
                      p.precio AS precio_producto,
                      c.descuentos AS descuento_producto,
                      p.descripcion AS descripcion_producto,
                      d.importe
                     FROM
                      cabecera_nota_credito c
                     INNER JOIN
                      detalle_nota_credito d ON c.id = d.cabecera_nota_credito_id
                     INNER JOIN
                      productos p ON d.producto_id = p.id_producto
                     WHERE
                      c.id = '$id';";

            $result = mysqli_query($conexion, $sql);
            $totalFactura = 0;
            $totalDescuento = 0;

            while ($mostrar = mysqli_fetch_row($result)) {
                $descuento = $mostrar[6];
                $importe = $mostrar[8]; // Variable d.importe
                $totalFactura += floatval($importe); // Suma el importe como un número flotante

                // Añade el descuento al total de descuentos
                $totalDescuento += floatval($descuento);

            ?>
                <tr>
                    <td><?php echo $mostrar[4]; ?></td>
                    <td><?php echo $mostrar[3]; ?></td>
                    <td><?php echo $mostrar[5]; ?></td>
                    <td><?php echo $descuento; ?></td>
                    <td><?php echo $importe; ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td colspan="4">Total Nota de Crédito:</td>
                <td><?php echo "$" . number_format($totalFactura, 2); ?></td>
            </tr>
            <!-- <tr>
    <td colspan="4">Total Factura con Descuento:</td>
    <td></td>
</tr>
<tr> -->
            <td colspan="4" style="text-align: left-center;">
                <p style="width: 30%; margin-top: 10px;">Sello: </p>
            </td>
            <td colspan="1" style="text-align: left;">
                <p style="width: 70%;">Firma: </p>
            </td>
            </tr>
        </tbody>
    </table>
</body>

</html>