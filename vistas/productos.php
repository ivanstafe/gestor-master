<?php
session_start();
if (isset($_SESSION['nombre'])) {

?>


    <!DOCTYPE html>
    <html>

    <head>
        <title>Productos</title>
        <?php require_once "menu.php"; ?>
        <?php require_once "../clases/Conexion.php";
        $con = new conectar();
        $conexion = $con->conexion();
        $sql = "SELECT id_categoria,nombre
		from categoriasProductos";
        $result = mysqli_query($conexion, $sql);
        ?>

    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div style="margin-top: 35px;"></div>
                    <form id="formProductos" enctype="multipart/form-data">
                        <div class="form-row">
                            <label for="categoriasSelect">Categoria</label>
                            <div class="input-wrapper">
                                <select class="form-control input-sm" id="categoriasSelect" name="categoriasSelect">
                                    <option value="A">Selecciona una Categoria</option>
                                    <?php while ($ver = mysqli_fetch_row($result)) : ?>
                                        <option value="<?php echo $ver[0] ?>"><?php echo $ver[1]; ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <a href="categoriasProductos.php" class="btn btn-primary btn-sm btn-small btn-custom-V2">Agregar Categoría</a>
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
                            <input type="number" step="0.01" class="form-control input-sm" id="precio" name="precio">
                        </div>
                        <div class="form-row">
                            <label>Imagen</label>
                            <input type="file" id="imagen" name="imagen">
                        </div>
                        <p></p>
                        <span id="btnAgregarProducto" class="btn btn-success btn-custom-agregar">Agregar</span>
                    </form>
                </div>
                <div class="col-sm-8">
                    <div id="cargaTablaProductos"></div>
                </div>
            </div>
        </div>

        <style>
            .form-row {
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
                margin-right: 10px;
            }
        </style>


    

        <!-- Modal -->

        <div class="modal fade" id="actualizarProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Actualizar Producto</h4>
                    </div>
                    <div class="modal-body">
                        <form id="formProductosEditar" enctype="multipart/form-data">
                            <input type="text" id="idProducto" hidden="" name="idProducto">
                            <label for="toggleCantidad">Habilitar Edición</label>

                            <select class="form-control input-sm" id="toggleCantidad" name="toggleCantidad">
                                <option value="deshabilitado" selected>Deshabilitado</option>
                                <option value="habilitado">Habilitado</option>
                            </select>
                            <label>Nombre</label>
                            <input type="text" class="form-control input-sm" id="nombreEditar" name="nombreEditar">
                            <label>Descripcion</label>
                            <input type="text" class="form-control input-sm" id="descripcionEditar" name="descripcionEditar">
                            <label>Ingresar Stock</label>
                            <input type="text" class="form-control input-sm" id="cantidadEditar" name="cantidadEditar" placeholder="Ingrese la cantidad"> <label>Precio</label>
                            <input input type="number" step="0.01" class="form-control input-sm" id="precioEditar" name="precioEditar">

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btnActualizarProducto" type="button" class="btn btn-success btn-custom-agregar" data-dismiss="modal">Actualizar</button>

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



        <script type="text/javascript" src="../js/productos.js"></script>

    </body>

    </html>


<?php
} else {
    header("location:../index.php");
}



?>