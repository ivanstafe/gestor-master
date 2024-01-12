<?php
session_start();
require_once "../../clases/Conexion.php";

$con = new conectar();
$conexion = $con->conexion();
?>

<strong>
  <div id="nombreclienteVenta"></div>
</strong>

<div class="">
  <table class="table table-bordered table-hover table-condensed" style="text-align: center;">
    <thead>
      <tr>
        <td>Nombre</td>
        <td>Imagen</td>
        <td>Descripción</td>
        <td>Precio</td>
        <td>Cantidad</td>
        <td>Quitar</td>
      </tr>
    </thead>
    <tbody>
      <?php
      $total = 0;
      $cliente = "";

      if (isset($_SESSION['tablaComprasTemp'])) {
        $productos_agregados = [];

        foreach ($_SESSION['tablaComprasTemp'] as $key => $producto) {
          $datos = explode("||", $producto);

          // Multiplica el precio por la cantidad y sumarlo al total - para las agregaciones multiples !!!
          $total += $datos[3] * intval($datos[6]);
          $cliente = $datos[4];

          $sqlImagen = "SELECT ima.ruta
                        FROM productos AS pro
                        INNER JOIN imagenes AS ima ON pro.id_imagen = ima.id_imagen
                        WHERE pro.id_producto = " . $datos[0];

          $resultImagen = mysqli_query($conexion, $sqlImagen);
          $rowImagen = mysqli_fetch_assoc($resultImagen);

          if (isset($productos_agregados[$datos[0]])) {
            $productos_agregados[$datos[0]]['cantidad'] += intval($datos[6]);
          } else {
            $productos_agregados[$datos[0]] = [
              'nombre' => $datos[1],
              'descripcion' => $datos[2],
              'precio' => $datos[3],
              'cantidad' => intval($datos[6]),
              'imagen' => $rowImagen['ruta'],
              'id' => $datos[0]
            ];
          }
        }

        foreach ($productos_agregados as $key => $producto) {
      ?>
          <tr>
            <td><?php echo $producto['nombre'] ?></td>
            <td>
              <?php
              $imgVer = explode("/", $producto['imagen']);
              $imgruta = $imgVer[1] . "/" . $imgVer[2] . "/" . $imgVer[3];
              ?>
              <img class="img-thumbnail" width="80" height="80" src="<?php echo $imgruta ?>" alt="Imagen del producto">
            </td>

            <td><?php echo $producto['descripcion'] ?></td>
            <td><?php echo $producto['precio'] ?></td>
            <td><?php echo $producto['cantidad'] ?></td>
            <td>
              <span class="btn btn-danger btn-xs" onclick="quitarP('<?php echo $producto['id']; ?>')">
                <span class="glyphicon glyphicon-remove"></span>
              </span>
            </td>
          </tr>
      <?php
        }
      }
      ?>

      <tr>
        <td colspan="6"></td>
      </tr>

      <tr>
        <td colspan="2"></td>
        <td colspan="2" class="text-left">
          <label for="venta_tipo">Tipo de Venta:</label>
          <select id="venta_tipo" name="venta_tipo">
            <option value="contado">Venta al contado</option>
            <option value="cuenta_corriente">Cuenta corriente</option>
            <option value="tarjeta de credito">Tarjeta de crédito</option>
            <option value="transferencia bancaria">Transferencia bancaria</option>
            <option value="otros">Otros</option>
          </select>
        </td>
        <td colspan="2" class="text-left">
          <label for="descuento">Descuento (%):</label>
          <input type="number" id="descuento" name="descuento" min="0" max="100" step="1" placeholder="Ingrese el descuento">
        </td>
      </tr>

      <tr>
        <td colspan="4"></td>
        <td colspan="2" class="text-left">
          <strong>Total:</strong>
          <span id="total">
            <?php
            if (isset($_SESSION['tablaComprasTemp'])) {
              echo "$" . $total;
            } else {
              echo "$" . $total;
            }
            ?>
          </span>
        </td>
      </tr>

      <tr>
        <td colspan="6" class="text-right">
          <span class="btn btn-custom" onclick="crearVenta()">
            <span class="glyphicon glyphicon-file"></span>
            Generar Venta
          </span>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<script>
  document.getElementById('descuento').addEventListener('input', function() {
    var total = <?php echo $total; ?>;
    var descuento = document.getElementById('descuento').value;

    if (descuento !== '') { // Verifica si se ingresó un descuento
      var nuevoTotal = total - (total * (descuento / 100));
      document.getElementById('total').innerText = "$" + nuevoTotal.toFixed(2);
    } else {
      document.getElementById('total').innerText = "$" + total.toFixed(2);
    }
  });
</script>



<script type="text/javascript">
  $(document).ready(function() {
    nombre = "<?php echo @$cliente ?>";
    $('#nombreclienteVenta').text("Cliente: " + nombre);
  });

  function quitarP(idProducto) {
    $.ajax({
      type: "POST",
      data: {
        id_producto: idProducto
      }, 
      url: "../acciones/ventas/quitarproducto.php",
      success: function(response) {
        console.log('Respuesta del servidor:', response);
        $('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php", function() {
          alertify.success("Se quitó el producto");
        });
      }
    });
  }
</script>


<style>
  /* Estilos personalizados */
  .btn-custom {
    background-color: #f0ad4e;
    color: #fff;
    padding: 8px 16px;
    border: none;
    border-bottom: 4px solid #4298b5;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }

  /* Efectos al pasar el cursor sobre el botón */
  .btn-custom:hover {
    transform: translateY(2px);
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
    border-bottom: 2px solid #4298b5;
  }
</style>