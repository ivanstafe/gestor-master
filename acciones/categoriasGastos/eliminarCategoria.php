<?php 
	require_once "../../clases/Conexion.php";
	require_once "../../clases/CategoriasGastos.php";
	$id=$_POST['idcategoria'];

	$obj= new categoriasGastos();
	echo $obj->eliminaCategoria($id);

 ?>