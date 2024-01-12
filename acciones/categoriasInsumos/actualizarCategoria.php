<?php 
	require_once "../../clases/Conexion.php";
	require_once "../../clases/CategoriasInsumos.php";

	

	$datos=array(
		$_POST['idcategoria'],
		$_POST['categoriaEditar']
			);

	$obj= new categoriasInsumos();

	echo $obj->actualizaCategoria($datos);

 ?>