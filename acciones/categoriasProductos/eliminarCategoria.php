<?php 
	require_once "../../clases/Conexion.php";
	require_once "../../clases/CategoriasProductos.php";
	$id=$_POST['idcategoria'];

	$obj= new categoriasProductos();
	echo $obj->eliminaCategoria($id);

 ?>