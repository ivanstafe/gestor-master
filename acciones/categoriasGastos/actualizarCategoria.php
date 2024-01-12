<?php 
	require_once "../../clases/Conexion.php";
	require_once "../../clases/CategoriasGastos.php";

	

	$datos=array(
		$_POST['idcategoria'],
		$_POST['categoriaEditar']
			);

	$obj= new categoriasGastos();

	echo $obj->actualizaCategoria($datos);

 ?>