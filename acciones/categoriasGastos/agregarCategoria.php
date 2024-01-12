<?php 
	session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/CategoriasGastos.php";
	$fecha=date("Y-m-d");
	$idusuario=$_SESSION['iduser'];
	$categoria=$_POST['categoria'];

	$datos=array(
		$idusuario,
		$categoria,
		$fecha
				);

	$obj= new categoriasGastos();

	echo $obj->agregaCategoria($datos);


 ?>