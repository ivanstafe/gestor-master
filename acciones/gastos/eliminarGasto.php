<?php 


require_once "../../clases/Conexion.php";
require_once "../../clases/Gastos.php";

 $idGasto=$_POST['idGasto'];

	$obj=new gastos();

	 echo $obj->eliminaGasto($idGasto);

 ?>