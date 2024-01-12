<?php
session_start();
if (isset($_SESSION['nombre'])) {

?>


	<!DOCTYPE html>
	<html>

	<head>
		<title>Proveedores</title>
		<?php require_once "menu.php"; ?>
	</head>

	<body>

		<div class="container">

			<div class="row">
				<div class="col-sm-4">
					<div style="margin-top: 35px;"></div>
					<form id="formProveedores">
						<label>Razon Social</label>
						<input type="text" class="form-control input-sm" id="nombre" name="nombre">
						<label>Direccion</label>
						<input type="text" class="form-control input-sm" id="direccion" name="direccion">
						<label>CUIT</label>
						<input type="text" class="form-control input-sm" id="cuit" name="cuit">
						<label>Email</label>
						<input type="email" class="form-control input-sm" id="email" name="email">
						<label>Tel. 1</label>
						<input type="text" class="form-control input-sm" id="telefono1" name="telefono1">
						<label>Tel. 2</label>
						<input type="text" class="form-control input-sm" id="telefono2" name="telefono2">
						<p></p>
						<a class="btn btn-success btn-custom-agregar" id="btnAgregarProveedor">Agregar</a>
					</form>
				</div>
				<div class="col-sm-8">
					<div id="cargaTablaProveedores"></div>
				</div>
			</div>
		</div>



		<!-- Modal -->
		<div class="modal fade" id="actualizarProveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Actualizar proveedor</h4>
					</div>
					<div class="modal-body">
						<form id="formProveedoresEditar" enctype="multipart/form-data">
							<input type="text" hidden="" id="idproveedorEditar" name="idproveedorEditar">
							<label>Razon Social</label>
							<input type="text" class="form-control input-sm" id="nombreEditar" name="nombreEditar">
							<label>Direccion</label>
							<input type="text" class="form-control input-sm" id="direccionEditar" name="direccionEditar">
							<label>CUIT</label>
							<input type="text" class="form-control input-sm" id="cuitEditar" name="cuitEditar">
							<label>Email</label>
							<input type="email" class="form-control input-sm" id="emailEditar" name="emailEditar">
							<label>Tel. 1</label>
							<input type="text" class="form-control input-sm" id="telefono1Editar" name="telefono1Editar">
							<label>Tel. 2</label>
							<input type="text" class="form-control input-sm" id="telefono2Editar" name="telefono2Editar">
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnActualizarProveedor" type="button" class="btn btn-success btn-custom-agregar" data-dismiss="modal">Actualizar</button>

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

		<script type="text/javascript" src="../js/proveedores.js"></script>
	</body>

	</html>



<?php
} else {
	header("location:../index.php");
}
?>