
<?php 

	class categoriasInsumos{

		public function agregaCategoria($datos){
			$con= new conectar();
			$conexion=$con->conexion();

			$sql="INSERT into categoriasInsumos(id_usuario,
										nombre,
										fechaCaptura)
						values ('$datos[0]',
								'$datos[1]',
								'$datos[2]')";

			return mysqli_query($conexion,$sql);
		}

		public function actualizaCategoria($datos){
			$con= new conectar();
			$conexion=$con->conexion();

			$sql="UPDATE categoriasInsumos set nombre='$datos[1]'
								where id_categoria='$datos[0]'";
			echo mysqli_query($conexion,$sql);
		}

		public function eliminaCategoria($idcategoria){
			$con= new conectar();
			$conexion=$con->conexion();
			$sql="DELETE from categoriasInsumos 
					where id_categoria='$idcategoria'";
			return mysqli_query($conexion,$sql);
		}

	}

 ?>