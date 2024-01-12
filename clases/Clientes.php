<?php 

	class clientes{

		public function agregaCliente($datos){
			$con= new conectar();
			$conexion=$con->conexion();

			$idusuario=$_SESSION['iduser'];

			$sql="INSERT into clientes (id_usuario,
										nombre,
										apellido,
										direccion,
										cuit,
										email,
										telefono,
										telefono2)
									
							values ('$idusuario',
									'$datos[0]',
									'$datos[1]',
									'$datos[2]',
									'$datos[3]',
									'$datos[4]',
									'$datos[5]',
									'$datos[6]')";
			return mysqli_query($conexion,$sql);	
		}

		public function obtenerDatosCliente($idcliente){
			$con= new conectar();
			$conexion=$con->conexion();

			$sql="SELECT id_cliente, 
							nombre,
							apellido,
							direccion,
							cuit,
							email,
							telefono,
							telefono2
							
				from clientes";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
					'id_cliente' => $ver[0], 
					'nombre' => $ver[1],
					'apellido' => $ver[2],
					'direccion' => $ver[3],
					'cuit' => $ver[4],
					'email' => $ver[5],
					'telefono' => $ver[6],
					'telefono2' => $ver[7]
				
						);
			return $datos;
		}

		public function actualizaCliente($datos){
			$con= new conectar();
			$conexion=$con->conexion();
			$sql="UPDATE clientes set nombre='$datos[1]',
										apellido='$datos[2]',
										direccion='$datos[3]',
										cuit='$datos[4]',
										email='$datos[5]',
										telefono='$datos[6]',
										telefono2='$datos[7]'
									
								where id_cliente='$datos[0]'";
			return mysqli_query($conexion,$sql);
		}

		

		public function eliminaCliente($idcliente){
			$con= new conectar();
			$conexion=$con->conexion();

			$sql="DELETE from clientes where id_cliente='$idcliente'";

			return mysqli_query($conexion,$sql);
		}
	}

 ?>