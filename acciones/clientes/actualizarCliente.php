<?php 

session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Clientes.php";

	$obj= new clientes();


	$datos=array(
			$_POST['idclienteEditar'],
			$_POST['nombreEditar'],
			$_POST['apellidosEditar'],
			$_POST['direccionEditar'],
			$_POST['cuitEditar'],
			$_POST['emailEditar'],
			$_POST['telefonoEditar'],
			$_POST['telefono2Editar']
			);

	echo $obj->actualizaCliente($datos);

	
	
 ?>