<?php

require_once "../../clases/Conexion.php";
$con = new conectar();
$conexion = $con->conexion();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>

<body>

	<div class="row">
		<div class="col-sm-4">
			<!-- <p id="mensajeIdProducto"></p> -->
			<form id="formVentasProductos">


				<label>Seleciona Cliente</label>
				<!--agregado para mostrar variables js-->
				<!-- <div id="cantidadSesionInt"></div>
			<div id="cantidadInputValue"></div>
			<div id="cantidadBDValue"></div> -->

				<select class="form-control input-sm" id="clienteVenta" name="clienteVenta">
					<option value="A">Selecciona</option>
					<option value="0">Sin cliente</option>
					<?php
					$sql = "SELECT id_cliente,nombre,apellido 
				from clientes";
					$result = mysqli_query($conexion, $sql);
					while ($cliente = mysqli_fetch_row($result)) :
					?>
						<option value="<?php echo $cliente[0] ?>"><?php echo $cliente[2] . " " . $cliente[1] ?></option>
					<?php endwhile; ?>
				</select>
				<label>Producto</label>
				<select class="form-control input-sm" id="productoVenta" name="productoVenta">
					<option value="A">Selecciona</option>
					<?php
					$sql = "SELECT id_producto,
				nombre
				from productos";
					$result = mysqli_query($conexion, $sql);

					while ($producto = mysqli_fetch_row($result)) :
					?>
						<option value="<?php echo $producto[0] ?>"><?php echo $producto[1] ?></option>
					<?php endwhile; ?>
				</select>
				<label>Descripcion</label>
				<textarea readonly="" id="descripcionV" name="descripcionV" class="form-control input-sm"></textarea>
				<label>Cantidad</label>
				<input type="number" class="form-control input-sm" id="cantidadV" name="cantidadV">
				<label>Precio</label>
				<input readonly="" type="text" class="form-control input-sm" id="precioV" name="precioV">
				<label>Descuento</label>
				<input type="number" class="form-control input-sm" id="descuentoV" name="decuentoV" placeholder="Ingrese el descuento">
				<p></p>
				<span class="btn btn-success btn-custom-agregar" id="btnAgregaVenta">Agregar</span>
				<span class="btn btn-danger btn-custom-limpiar" id="btnVaciarVentas">Limpiar</span>
			</form>
			<br>
		</div>
		<div class="col-sm-3">
			<!-- <div id="imgProducto"></div> -->
		</div>
		<div class="col-sm-4">
			<div id="tablaVentasTempLoad"></div>
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
      

		/* Estilos personalizados para el botón de Limpiar */
		.btn-custom-limpiar {
			background-color: #d9534f;
			/* Rojo */
			color: #fff;
			/* Color de texto blanco */
			padding: 8px 16px;
			border: none;
			border-bottom: 4px solid #c82333;
			/* Borde más oscuro */
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			transition: all 0.3s ease;
		}

		.btn-custom-limpiar:hover {
			transform: translateY(2px);
			box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
			border-bottom: 2px solid #c82333;
		
		}
	</style>

	<script type="text/javascript" src="../js/venderProducto.js"></script>
</body>

</html>