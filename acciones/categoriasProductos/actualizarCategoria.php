<?php 
	require_once "../../clases/Conexion.php";
	require_once "../../clases/CategoriasProductos.php";

	

	$datos=array(
		$_POST['idcategoria'],
		$_POST['categoriaEditar']
			);

	$obj= new categoriasProductos();

	echo $obj->actualizarCategoria($datos);

 ?>