<?php
session_start();
if (isset($_SESSION['nombre'])) {
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Insumos</title>
        <?php require_once "menu.php"; ?>
        <?php require_once "../clases/Conexion.php";
        $con = new conectar();
        $conexion = $con->conexion();
        $sql = "SELECT id_categoria, nombre FROM categoriasInsumos";
        $result = mysqli_query($conexion, $sql);

        $sql_proveedores = "SELECT id_proveedor, razon_social FROM proveedores";
        $result_proveedores = mysqli_query($conexion, $sql_proveedores);
        ?>

        <style>
            ¿ .form-row {
                margin-bottom: 10px;
            }

            .form-row label {
                display: block;
            }

            .input-wrapper {
                display: flex;
                align-items: center;
            }

            .btn-small {
                font-size: 12px;
                padding: 5px 10px;
            }

            .input-wrapper select {
                flex: 1;
                /* Para ocupar el espacio restante */
                margin-right: 10px;
                /* Margen entre el select y el botón */
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div style="margin-top: 35px;"></div>
                    <form id="formInsumos" enctype="multipart/form-data">
                        <div class="form-row">
                            <label for="categoriasSelect">Categoria</label>
                            <div class="input-wrapper">
                                <select class="form-control input-sm" id="categoriasSelect" name="categoriasSelect">
                                    <option value="A">Selecciona Categoria</option>
                                    <?php while ($ver = mysqli_fetch_row($result)) : ?>
                                        <option value="<?php echo $ver[0] ?>"><?php echo $ver[1]; ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <a href="categoriasInsumos.php" class="btn btn-primary btn-sm btn-small btn-custom-V2">Agregar Categoría</a>
                            </div>
                        </div>
                        <div class="form-row">

                            <label for>Proveedor</label>
                            <div class="input-wrapper">
                                <select class="form-control input-sm" id="proveedoresSelect" name="proveedoresSelect">
                                    <option value="A">Selecciona Proveedor</option>
                                    <?php while ($row_proveedor = mysqli_fetch_row($result_proveedores)) : ?>
                                        <option value="<?php echo $row_proveedor[0] ?>"><?php echo $row_proveedor[1]; ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <a href="proveedores.php" class="btn btn-primary btn-sm btn-small btn-custom-V2">Agregar Proveedor</a>
                            </div>
                        </div>

                        <div class="form-row">
                            <label>Nombre</label>
                            <input type="text" class="form-control input-sm" id="nombre" name="nombre">
                        </div>
                        <div class="form-row">
                            <label>Descripcion</label>
                            <input type="text" class="form-control input-sm" id="descripcion" name="descripcion">
                        </div>
                        <div class="form-row">
                            <label>Cantidad</label>
                            <input type="number" class="form-control input-sm" id="cantidad" name="cantidad">
                        </div>
                        <div class="form-row">
                            <label>Precio</label>
                            <input input type="number" step="0.01" class="form-control input-sm" id="precio" name="precio">
                        </div>
                        <div class="form-row">
                            <label>Método de Pago</label>
                            <select class="form-control input-sm" id="metodoPago" name="metodoPago">
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="otros">Otros</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <label>Número de Factura</label>
                            <input type="text" class="form-control input-sm" id="numeroFactura" name="numeroFactura">
                        </div>
                        <div class="form-row">
                            <label>Fecha de Pago</label>
                            <input type="date" class="form-control input-sm" id="fechaPago" name="fechaPago">
                        </div>
                        <div class="form-row">
                            <label>Estado de Pago</label>
                            <select class="form-control input-sm" id="estadoPago" name="estadoPago">
                                <option value="pendiente">Pendiente</option>
                                <option value="pagado">Pagado</option>
                                <option value="parcialmente_pagado">Parcialmente Pagado</option>
                                <option value="otros">Otros</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <label>Imagen</label>
                            <input type="file" id="imagen" name="imagen">
                        </div>
                        <p></p>
                        <span id="btnAgregarInsumos" class="btn btn-success btn-custom-agregar">Agregar</span>
                    </form>
                    <br>
                </div>
                <div class="col-sm-8">
                    <div id="cargaTablaInsumos"></div>
                </div>
            </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="actualizarInsumo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Actualizar Insumo</h4>
                    </div>
                    <div class="modal-body">
                    <form id="formInsumosEditar" enctype="multipart/form-data">
    <input type="text" id="idInsumo" hidden="" name="idInsumo">
    <label for="toggleCantidad">Habilitar Edición</label>
    <select class="form-control input-sm" id="toggleCantidad" name="toggleCantidad">
        <option value="deshabilitado" selected>Deshabilitado</option>
        <option value="habilitado">Habilitado</option>
    </select>
    <label>Nombre</label>
    <input type="text" class="form-control input-sm" id="nombreEditar" name="nombreEditar">
    <!-- Campo de Categoria oculto -->
    <input type="hidden" id="categoriaSelectEditar" name="categoriaSelectEditar">
    <label>Descripcion</label>
    <input type="text" class="form-control input-sm" id="descripcionEditar" name="descripcionEditar">
    <!-- Campo de Proveedor oculto -->
    <input type="hidden" id="proveedorSelectEditar" name="proveedorSelectEditar">
    <label>Actualizar Cantidad</label>
    <select class="form-control input-sm" id="accionCantidad" name="accionCantidad">
        <option value="" disabled>Seleccione el tipo de ingreso</option>
        <option value="incrementar" selected>Incrementar</option>
        <option value="disminuir">Disminuir</option>
    </select>

    <input type="hidden" id="accionSeleccionada" name="accionSeleccionada">
    <label>Cantidad</label>
    <input type="number" class="form-control input-sm" id="cantidadEditar" name="cantidadEditar" placeholder="Ingrese la cantidad">

    <label>Precio</label>
    <input input type="number" step="0.01" class="form-control input-sm" id="precioEditar" name="precioEditar">
    <div class="form-row">
        <label>Método de Pago</label>
        <select class="form-control input-sm" id="metodoPagoEditar" name="metodoPagoEditar">
            <option value="efectivo">Efectivo</option>
            <option value="tarjeta">Tarjeta</option>
            <option value="transferencia">Transferencia</option>
            <option value="otros">Otros</option>
        </select>
    </div>
    <div class="form-row">
        <label>Número de Factura</label>
        <input type="text" class="form-control input-sm" id="numeroFacturaEditar" name="numeroFacturaEditar">
    </div>
    <div class="form-row">
        <label>Fecha de Pago</label>
        <input type="date" class="form-control input-sm" id="fechaPagoEditar" name="fechaPagoEditar">
    </div>
    <div class="form-row">
        <label>Estado de Pago</label>
        <select class="form-control input-sm" id="estadoPagoEditar" name="estadoPagoEditar">
            <option value="pendiente">Pendiente</option>
            <option value="pagado">Pagado</option>
            <option value="parcialmente_pagado">Parcialmente Pagado</option>
            <option value="otros">Otros</option>
        </select>
    </div>
</form>

                    </div>
                    <div class="modal-footer">
                        <button id="btnActualizarInsumo" type="button" class="btn btn-success btn-custom-agregar" data-dismiss="modal">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>



        <style>
            /* Estilos personalizados para el botón de Agregar */
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

        <style>
            .btn-custom-V2 {
                background-color: #55acee;
                /* Celeste */
                color: #fff;
                padding: 8px 16px;
                border: none;
                border-bottom: 4px solid #4d94c1;
                /* Borde celeste más claro */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }

            .btn-custom-agregar:hover {
                transform: translateY(2px);
                box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
                border-bottom: 2px solid #4d94c1;
                /* Borde celeste más claro al hacer hover */
            }
        </style>

        <script type="text/javascript" src="../js/insumos.js"></script>

    </body>

    </html>

<?php
} else {
    header("location:../index.php");
}
?>