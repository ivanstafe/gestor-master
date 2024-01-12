<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Gastos.php";

	$obj= new gastos();


	$idGas=$_POST['idGas'];

	echo json_encode($obj->obtenerDatosGasto($idGas));

 ?>