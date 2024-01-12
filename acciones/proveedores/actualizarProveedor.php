<?php 

session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Proveedores.php";

	$obj= new proveedores();


	$datos=array(
			$_POST['idproveedorEditar'],
			$_POST['nombreEditar'],
			$_POST['direccionEditar'],
			$_POST['cuitEditar'],
			$_POST['emailEditar'],
			$_POST['telefono1Editar'],
			$_POST['telefono2Editar']
			);

	echo $obj->actualizaProveedor($datos);

	
	
 ?>