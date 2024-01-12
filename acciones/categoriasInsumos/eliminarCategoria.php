<?php 
	require_once "../../clases/Conexion.php";
	require_once "../../clases/CategoriasInsumos.php";
	$id=$_POST['idcategoria'];

	$obj= new categoriasInsumos();
	echo $obj->eliminaCategoria($id);

 ?>