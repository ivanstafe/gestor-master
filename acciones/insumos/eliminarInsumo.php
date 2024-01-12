<?php 


require_once "../../clases/Conexion.php";
require_once "../../clases/Insumos.php";

 $idInsumo=$_POST['idInsumo'];

	$obj=new insumos();

	 echo $obj->eliminaInsumo($idInsumo);

 ?>