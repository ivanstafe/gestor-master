<?php 


require_once "../../clases/Conexion.php";
require_once "../../clases/Productos.php";
$idPro=$_POST['idProducto'];

	$obj=new productos();

	echo $obj->eliminarProducto($idPro);

 ?>