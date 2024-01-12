<?php
session_start();
if (isset($_SESSION['nombre'])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>
    <title>Ajuste de inventario de productos</title>
    <?php require_once "menu.php"; ?>

    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div id="cargaTablaAjustes"></div>
                </div>
            </div>
        </div>
    </body>

    </html>
    <!-- Modal -->
    <div class="modal fade" id="ajustarProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Actualizar ajuste de producto</h4>
                </div>
                <div class="modal-body">
                    <form id="formAjusteProductoEditar">
                        <label>Id Producto</label>
                        <input type="text" class="form-control input-sm" id="idProductoEditar" name="idProductoEditar">
                        <label>Actualizar Cantidad</label>
                        <select class="form-control input-sm" id="accionCantidad" name="accionCantidad">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="incrementar">Incrementar</option>
                            <option value="disminuir">Disminuir</option>
                        </select>


                        <input type="hidden" id="accionSeleccionada" name="accionSeleccionada">
                        <label>Cantidad</label>
                        <input type="number" class="form-control input-sm" id="cantidadEditar" name="cantidadEditar" placeholder="Ingrese la cantidad">
                        <label>Motivo</label>
                        <input type="text" class="form-control input-sm" id="motivoEditar" name="motivoSEditar">
                    </form>

                </div>
                <div class="modal-footer">
                    <button id="btnActualizarAjusteProducto" type="button" class="btn btn-primary btn-custom-agregar" data-dismiss="modal">Actualizar</button>
                </div>
            </div>
        </div>
    </div>



    <style>
			.btn-custom-agregar {
				background-color: #3ac358;
				color: #fff;
				padding: 8px 16px;
				border: none;
				border-bottom: 4px solid #218838;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
				transition: all 0.3s ease;
			}

			.btn-custom-agregar:hover {
				transform: translateY(2px);
				box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
				border-bottom: 2px solid #218838;


			}
		</style>
    <script type="text/javascript" src="../js/ajusteProductos.js"></script>
    </body>

    </html>



<?php
} else {
    header("location:../index.php");
}
?>