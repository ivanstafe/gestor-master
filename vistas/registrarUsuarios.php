<?php
session_start();
if (isset($_SESSION['nombre'])) {
    require_once "menu.php";
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Registrar Usuario o Administrador</title>

    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div style="margin-top: 35px;"></div>
                    <form id="formUsuarios">
                        <label>Nombre</label>
                        <input type="text" class="form-control input-sm" id="nombre" name="nombre">
                        <label>Apellido</label>
                        <input type="text" class="form-control input-sm" id="apellido" name="apellido">
                        <label>Tipo</label>
                        <select class="form-control input-sm" id="tipo" name="tipo">
                            <option value="Administrador">Administrador</option>
                            <option value="Usuario">Usuario</option>
                        </select>
                        <label>Password</label>
                        <input type="password" class="form-control input-sm" id="password" name="password" minlength="6" required>
                        <p></p>
                        <a class="btn btn-success btn-custom-agregar" id="btnAgregarUsuario">Agregar Usuario</a>
                    </form>
                </div>
                <div class="col-sm-8">
                    <div id="cargaTablaUsuarios"></div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        
        <div class="modal fade" id="actualizarUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Actualizar Usuario</h4>
                    </div>
                    <div class="modal-body">
                        <form id="formUsuariosEditar">
                            <input type="text" hidden="" id="idUsuario" name="idUsuario">
                            <label>Nombre</label>
                            <input type="text" class="form-control input-sm" id="nombreEditar" name="nombreEditar">
                            <label>Apellido</label>
                            <input type="text" class="form-control input-sm" id="apellidoEditar" name="apellidoEditar">
                            <label>Tipo</label>
                            <select class="form-control input-sm" id="tipoEditar" name="tipoEditar">
                                <option value="Administrador">Administrador</option>
                                <option value="Usuario">Usuario</option>
                            </select>
                            <label>Password</label>
                            <input type="password" class="form-control input-sm" id="passwordEditar" name="passwordEditar">

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btnActualizarUsuario" type="button" class="btn btn-success btn-custom-agregar" data-dismiss="modal">Actualizar</button>
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
        <script type="text/javascript" src="../js/usuarios.js"></script>
    </body>

    </html>



<?php
} else {
    header("location:../index.php");
}
?>