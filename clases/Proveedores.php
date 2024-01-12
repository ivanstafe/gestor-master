<?php 

	class proveedores{

		public function agregaProveedor($datos){
			$con= new conectar();
			$conexion=$con->conexion();

			// $idusuario=$_SESSION['iduser'];

			$sql="INSERT into proveedores (
										razon_social,
										direccion,
										cuit,
										email,
										telefono,
										telefono2)
									
							values (
									'$datos[0]',
									'$datos[1]',
									'$datos[2]',
									'$datos[3]',
									'$datos[4]',
									'$datos[5]'
									)";
			return mysqli_query($conexion,$sql);	
		}

		public function obtenerDatosProveedor($idproveedor){
			$con= new conectar();
			$conexion=$con->conexion();

			$sql="SELECT id_proveedor, 
							razon_social,
							direccion,
							cuit,
							email,
							telefono,
							telefono2
							
				from proveedores where id_proveedor='$idproveedor'";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
					'id_proveedor' => $ver[0], 
					'razon_social' => $ver[1],
					'direccion' => $ver[2],
					'cuit' => $ver[3],
					'email' => $ver[4],
					'telefono' => $ver[5],
					'telefono2'=>$ver[6]
					
				
						);
			return $datos;
		}

		public function actualizaProveedor($datos){
			$con= new conectar();
			$conexion=$con->conexion();
			$sql="UPDATE proveedores set razon_social='$datos[1]',
										direccion='$datos[2]',
										cuit='$datos[3]',
										email='$datos[4]',
										telefono='$datos[5]',
										telefono2='$datos[6]'
									
								where id_proveedor='$datos[0]'";
			return mysqli_query($conexion,$sql);
		}

		

		public function eliminaProveedor($idproveedor){
			$con= new conectar();
			$conexion=$con->conexion();

			$sql="DELETE from proveedores where id_proveedor='$idproveedor'";

			return mysqli_query($conexion,$sql);
		}
	}

 ?>