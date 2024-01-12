<?php 

	class usuarios{
		public function registroUsuario($datos){
			$con=new conectar();
			$conexion=$con->conexion();

			$fecha=date('Y-m-d');

			$sql="INSERT into usuarios (nombre,
								apellido,
								tipo,
								password,
								fechaCaptura)
						values ('$datos[0]',
								'$datos[1]',
								'$datos[2]',
								'$datos[3]',
								'$fecha')";
			return mysqli_query($conexion,$sql);
		}

		public function registroUsuarioAdmin($datos){
			$con=new conectar();
			$conexion=$con->conexion();

			$fecha=date('Y-m-d');

			$sql="INSERT into usuarios (nombre,
								apellido,
								tipo,
								password,
								fechaCaptura)
						values ('$datos[0]',
								'$datos[1]',
								'$datos[2]',
								'$datos[3]',
								'$fecha')";
			return mysqli_query($conexion,$sql);
		}


		public function loginUser($datos){
			$con=new conectar();

		// 	  $archivo = 'datos_enviados.txt';
		//  $contenido = print_r($datos, true);
		//  file_put_contents($archivo, $contenido);


			$conexion=$con->conexion();
			$password=sha1($datos[1]);

			$_SESSION['nombre']=$datos[0];
			$_SESSION['iduser']=self::traeID($datos);

			$sql="SELECT * 
					from usuarios 
				where nombre='$datos[0]'
				and password='$password'";
			$result=mysqli_query($conexion,$sql);

			if(mysqli_num_rows($result) > 0){
				return 1;
			}else{
				return 0;
			}
		}
		public function traeID($datos){
			$con=new conectar();
			$conexion=$con->conexion();

			$password=sha1($datos[1]);

			$sql="SELECT id_usuario 
					from usuarios 
					where nombre='$datos[0]'
					and password='$password'"; 
			$result=mysqli_query($conexion,$sql);

			return mysqli_fetch_row($result)[0];
		}

		public function obtenerDatosUsuario($idusuario){

			$c=new conectar();
			$conexion=$c->conexion();

			$sql="SELECT id_usuario,
							nombre,
							apellido,
							tipo,
							password
					from usuarios 
					where id_usuario='$idusuario'";
			$result=mysqli_query($conexion,$sql);

			$ver=mysqli_fetch_row($result);

			$datos=array(
						'id_usuario' => $ver[0],
							'nombre' => $ver[1],
							'apellido' => $ver[2],
							'tipo' => $ver[3],
							'password' => $ver[4]

						);

			return $datos;
		}

		public function actualizaUsuario($datos){
			$c=new conectar();
			$conexion=$c->conexion();

		    $archivo = 'datos_enviados.txt';
		    $contenido = print_r($datos, true);
		    file_put_contents($archivo, $contenido);


			$sql="UPDATE usuarios set nombre='$datos[1]',
									apellido='$datos[2]',
									tipo='$datos[3]',
									password='$datos[4]'
						where id_usuario='$datos[0]'";
			return mysqli_query($conexion,$sql);	
		}

		public function eliminaUsuario($idusuario){
			$c=new conectar();
			$conexion=$c->conexion();

			$sql="DELETE from usuarios 
					where id_usuario='$idusuario'";
			return mysqli_query($conexion,$sql);
		}
	}

 ?>