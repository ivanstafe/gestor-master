<?php 

session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Proveedores.php";

	$obj= new proveedores();


	$datos=array(
			$_POST['nombre'],
			$_POST['direccion'],
			$_POST['cuit'],
			$_POST['email'],
			$_POST['telefono1'],
			$_POST['telefono2']
		
				);

	echo $obj->agregaProveedor($datos);

	
	
 ?>