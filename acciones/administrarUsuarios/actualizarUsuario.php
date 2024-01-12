<?php 

session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Usuarios.php";

	$obj= new usuarios();

	$pass=sha1($_POST['passwordEditar']);
	$datos=array(
			$_POST['idUsuario'],
			$_POST['nombreEditar'],
			$_POST['apellidoEditar'],
			$_POST['tipoEditar'],
			$pass
			);

	echo $obj->actualizaUsuario($datos);

	
	
 ?>