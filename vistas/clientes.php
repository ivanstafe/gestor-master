<?php
session_start();
if (isset($_SESSION['nombre'])) {

?>


	<!DOCTYPE html>
	<html>

	<head>
		<title>Clientes</title>
		<?php require_once "menu.php"; ?>
	</head>

	<body>
		<div class="container">

			<div class="row">
				<div class="col-sm-4">
					<div style="margin-top: 35px;"></div>
					<form id="formClientes">
						<label>Nombre</label>
						<input type="text" class="form-control input-sm" id="nombre" name="nombre">
						<label>Apellido</label>
						<input type="text" class="form-control input-sm" id="apellidos" name="apellidos">
						<label>Direccion</label>
						<input type="text" class="form-control input-sm" id="direccion" name="direccion">
						<label>CUIT</label>
						<input type="text" class="form-control input-sm" id="cuit" name="cuit">
						<label>Email</label>
						<input type="text" class="form-control input-sm" id="email" name="email">
						<label>Telefono 1</label>
						<input type="text" class="form-control input-sm" id="telefono" name="telefono">
						<label>Telefono 2</label>
						<input type="text" class="form-control input-sm" id="telefono2" name="telefono2">
						<p></p>
						<a class="btn btn-success btn-custom-agregar" id="btnAgregarCliente">Agregar</a>
					</form>
				</div>
				<div class="col-sm-8">
					<div id="cargaTablaClientes"></div>
				</div>
			</div>
		</div>


		<!-- Modal -->
		<div class="modal fade" id="actualizarCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Actualizar cliente</h4>
					</div>
					<div class="modal-body">
						<form id="formClientesEditar">
							<input type="text" hidden="" id="idclienteEditar" name="idclienteEditar">
							<label>Nombre</label>
							<input type="text" class="form-control input-sm" id="nombreEditar" name="nombreEditar">
							<label>Apellido</label>
							<input type="text" class="form-control input-sm" id="apellidosEditar" name="apellidosEditar">
							<label>Direccion</label>
							<input type="text" class="form-control input-sm" id="direccionEditar" name="direccionEditar">
							<label>CUIT</label>
							<input type="text" class="form-control input-sm" id="cuitEditar" name="cuitEditar">
							<label>Email</label>
							<input type="email" class="form-control input-sm" id="emailEditar" name="emailEditar">
							<label>Telefono 1</label>
							<input type="text" class="form-control input-sm" id="telefonoEditar" name="telefonoEditar">
							<label>Telefono 2</label>
							<input type="text" class="form-control input-sm" id="telefono2Editar" name="telefono2Editar">
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnActualizarCliente" type="button" class="btn btn-success btn-custom-agregar" data-dismiss="modal">Actualizar</button>

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


		<script type="text/javascript" src="../js/clientes.js"></script>
	</body>

	</html>



<?php
} else {
	header("location:../index.php");
}
?>