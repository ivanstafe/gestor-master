<?php
session_start();
if (isset($_SESSION['nombre'])) {
?>

  <!DOCTYPE html>
  <html>

  <head>
    <title>Ventas</title>
    <?php require_once "menu.php"; ?>

    <!-- Agrega los estilos CSS para la tabla y los botones -->
    <style>
      /* Estilos de la tabla */
      .table-bordered-hover tr:hover {
        background-color: #f0f0f0;
      }

      .table-bordered-hover td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
        position: relative;
        /* Agregamos posición relativa para alinear el mensaje */
      }

      /* Estilos para los botones en la tabla */
      .table-bordered-hover .btn-container {
        position: relative;
      }

      .table-bordered-hover .btn {
        padding: 8px 16px;
        font-size: 16px;
        background-color: #f0ad4e;
        color: #fff;
        margin-left: 350px;

        /* Estilos para sombra y borde que simulan profundidad */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Sombra */
        border: none;
        border-bottom: 4px solid #4298b5;
        /* Borde inferior */
        transition: all 0.3s ease;
        /* Efecto de transición suave */
      }

      /* Al pasar el cursor por encima */
      .table-bordered-hover .btn:hover {
        transform: translateY(2px);
        /* Efecto de elevación */
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        /* Sombra más pronunciada */
        border-bottom: 2px solid #4298b5;
        /* Reducción del borde al pasar el cursor */
      }


      /* Estilos para el mensaje */
      .table-bordered-hover .message {
        position: absolute;
        left: 0;
        /* Ajustamos la posición del mensaje a la izquierda del botón */
        top: 50%;
        transform: translateY(-50%);
        /* Centramos verticalmente el mensaje */
        font-size: 12px;
        color: black;
        /* Color del texto del mensaje */
        padding-left: 5px;
        /* Ajustamos el padding izquierdo para separar el texto del botón */
      }
    </style>
    
  </head>

  <body>

    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <table class="table table-bordered-hover">
            <tbody>
              <tr>
                <td>
                  <div class="btn-container">
                    <span class="btn" id="ventaProductosBtn">Vender</span>
                    <div class="message">Realizar una nueva venta de productos</div>
                  </div>
                </td>
                <td>
                  <div class="btn-container">
                    <span class="btn" id="ventasHechasBtn">Consultar</span>
                    <div class="message">Consultar las ventas realizadas / generar remito</div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div id="venderP"></div>
          <div id="ventasR"></div>
        </div>
      </div>
    </div>

    <script type="text/javascript" src="../js/ventas.js"></script>
  </body>

  </html>

<?php
} else {
  header("location:../index.php");
}
?>