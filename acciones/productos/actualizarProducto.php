<?php 

require_once "../../clases/Conexion.php";
require_once "../../clases/Productos.php";

$obj= new productos();

$datos=array(
		$_POST['idProducto'],
	
	    $_POST['nombreEditar'],
	    $_POST['descripcionEditar'],
	    $_POST['cantidadEditar'],
	    $_POST['precioEditar']
			);

    echo $obj->actualizarProducto($datos);

 ?>