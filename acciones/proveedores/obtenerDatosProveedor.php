<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Proveedores.php";

	$obj= new proveedores();

	echo json_encode($obj->obtenerDatosProveedor($_POST['idproveedor']));

 ?>