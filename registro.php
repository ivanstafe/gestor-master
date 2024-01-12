<?php

require_once "clases/Conexion.php";
$obj = new conectar();
$conexion = $obj->conexion();

$sql = "SELECT * FROM usuarios WHERE tipo='administrador'";
$result = mysqli_query($conexion, $sql);
$validar = mysqli_num_rows($result) > 0;

if ($validar) {
	header("location:index.php");
	exit();
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Registro</title>
	<link rel="stylesheet" type="text/css" href="libs/bootstrap/css/bootstrap.css">
	<script src="libs/jquery-3.2.1.min.js"></script>
</head>

<body style="background-color: grey">
	<br><br><br>
	<div class="container">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<div class="panel panel-danger">
					<div class="panel-heading">Registrar Administrador</div>
					<div class="panel-body">
						<form id="formRegistro">
							<label>Nombre</label>
							<input type="text" class="form-control input-sm" name="nombre" id="nombre">
							<label>Apellido</label>
							<input type="text" class="form-control input-sm" name="apellido" id="apellido">
							<label>Tipo</label>
							<select class="form-control input-sm" name="tipo" id="tipo">
							<option value="Administrador">Administrador</option>
							</select>
							<label>Password</label>
							<input type="password" class="form-control input-sm" name="password" id="password" minlength="6" required>
							
							<p></p>
							<span class="btn btn-danger" id="registro">Registrar Administrador</span>
							<a href="index.php" class="btn btn-default">Regresar</a>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>

	<script type="text/javascript" src="js/registro.js"></script>

</body>

</html>