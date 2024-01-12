<?php 
	session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/CategoriasProductos.php";
	$fecha=date("Y-m-d");
	$idusuario=$_SESSION['iduser'];
	$categoria=$_POST['categoria'];

	$datos=array(
		$idusuario,
		$categoria,
		$fecha
				);

	$obj= new categoriasProductos();

	echo $obj->agregaCategoria($datos);


 ?>