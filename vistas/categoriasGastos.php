<?php
session_start();
if (isset($_SESSION['nombre'])) {

?>


	<!DOCTYPE html>
	<html>

	<head>
		<title>Categorias de Gastos</title>
		<?php require_once "menu.php"; ?>
	</head>

	<body>

		<div class="container">

			<div class="row">
				<div class="col-sm-4">
					<div style="margin-top: 35px;"></div>
					<form id="formCategorias">
						<label>Categoria</label>
						<input type="text" class="form-control input-sm" name="categoria" id="categoria">
						<p></p>
						<span class="btn btn-success btn-custom-agregar" id="btnAgregarCategoria">Agregar</span>
					</form>
				</div>
				<div class="col-sm-6">
					<div id="cargaTablaCategorias"></div>
				</div>
			</div>
		</div>


		<!-- Modal -->
		<div class="modal fade" id="actualizaCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Editar categorias</h4>
					</div>
					<div class="modal-body">
						<form id="formCategoriaEditar">
							<input type="text" hidden="" id="idcategoria" name="idcategoria">
							<label>Categoria</label>
							<input type="text" id="categoriaEditar" name="categoriaEditar" class="form-control input-sm">
						</form>


					</div>
					<div class="modal-footer">
						<button type="button" id="btnActualizaCategoria" class="btn btn-success btn-custom-agregar" data-dismiss="modal">Guardar</button>

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
		<script type="text/javascript" src="../js/categoriasGastos.js"></script>

	</body>

	</html>

<?php
} else {
	header("location:../index.php");
}
?>