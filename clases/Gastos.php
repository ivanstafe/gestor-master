<?php 
	class gastos{
        public function insertaGasto($datos) {
            $con = new Conectar();
            $conexion = $con->conexion();
            
            $fechaCaptura = date('Y-m-d');
            
            $sql = "INSERT INTO gastos (id_categoria,
                                        id_usuario,
                                        nombre,
                                        descripcion,
                                        cantidad,
                                        precio,
                                        fecha_gasto,
                                        metodo_pago,
                                        numero_factura,
                                        fecha_captura,
                                        estado_pago) 
                    VALUES ('$datos[0]',
                            '$datos[1]',
                            '$datos[2]',
                            '$datos[3]',
                            '$datos[4]',
                            '$datos[5]',
                            '$datos[6]',
                            '$datos[7]',
                            '$datos[8]',
                            '$fechaCaptura',
                            '$datos[9]')";
                    
            return mysqli_query($conexion, $sql);
        }
        

		public function obtenerDatosGasto($idGas) {
            $con = new Conectar();
            $conexion = $con->conexion();
        
            $sql = "SELECT id_gasto, 
                           id_categoria, 
                           nombre,
                           descripcion,
                           cantidad,
                           precio,
                           fecha_gasto,
                           metodo_pago,
                           numero_factura,
                           estado_pago
                    FROM gastos
                    WHERE id_gasto='$idGas'";
            $result = mysqli_query($conexion, $sql);
        
            $ver = mysqli_fetch_assoc($result);
        
            $datos = array(
                "id_gasto" => $ver['id_gasto'],
                "id_categoria" => $ver['id_categoria'],
                "nombre" => $ver['nombre'],
                "descripcion" => $ver['descripcion'],
                "cantidad" => $ver['cantidad'],
                "precio" => $ver['precio'],
                "fecha_gasto" => $ver['fecha_gasto'],
                "metodoDePago" => $ver['metodo_pago'],
                "numeroDeFactura" => $ver['numero_factura'],
                "estadoPago" => $ver['estado_pago'] 
            );
        
            return $datos;
        }
        

        public function actualizaGasto($datos) {
            $con = new Conectar();
            $conexion = $con->conexion();
        
            $sql = "UPDATE gastos SET 
                        id_categoria='$datos[1]', 
                        nombre='$datos[2]',
                        descripcion='$datos[3]',
                        cantidad='$datos[4]',
                        precio='$datos[5]',
                        fecha_gasto='$datos[6]',
                        metodo_pago='$datos[7]',
                        numero_factura='$datos[8]',
                        estado_pago='$datos[9]' 
                    WHERE id_gasto='$datos[0]'";
        
            return mysqli_query($conexion, $sql);
        }
        


		public function eliminaGasto($idGasto){
			
			
			$con=new conectar();
			$conexion=$con->conexion();

		

			$sql="DELETE from gastos
					where id_gasto='$idGasto'";
			$result=mysqli_query($conexion,$sql);
            if($result){
         
                    return 1;
             
            }
    
					}
		
		

	

	}

 ?>