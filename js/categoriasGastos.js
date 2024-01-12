
		$(document).ready(function(){

			$('#cargaTablaCategorias').load("../vistas/categoriasGastos/tabla.php");

			$('#btnAgregarCategoria').click(function(){

				vacios=validarFormVacio('formCategorias');

				if(vacios > 0){
					alertify.alert("Completa todos los campos.");
					return false;
				}

				datos=$('#formCategorias').serialize();
				$.ajax({
					type:"POST",
					data:datos,
					url:"../acciones/categoriasGastos/agregarCategoria.php",
					success:function(r){
						if(r==1){
				
					$('#formCategorias')[0].reset();

					$('#cargaTablaCategorias').load("../vistas/categoriasGastos/tabla.php");
					alertify.success("Agregado con exito.");
				}else{
					alertify.error("No se pudo agregar.");
				}
			}
		});
			});
		});



        
		function validarFormVacio(formulario){
            datos=$('#' + formulario).serialize();
            d=datos.split('&');
            vacios=0;
            for(i=0;i< d.length;i++){
                    controles=d[i].split("=");
                    if(controles[1]=="A" || controles[1]==""){
                        vacios++;
                    }
            }
            return vacios;
        }
		

		$(document).ready(function(){
			$('#btnActualizaCategoria').click(function(){
		
				// Validar campos antes de actualizar
				var vacios = validarFormVacio('formCategoriaEditar');
		
				if (vacios > 0) {
					alertify.alert("Completa todos los campos.");
					return false;
				}
		
				// Si todos los campos están completos, proceder con la actualización
				var datos = $('#formCategoriaEditar').serialize();
				$.ajax({
					type:"POST",
					data:datos,
					url:"../acciones/categoriasGastos/actualizarCategoria.php",
					success:function(r){
						if(r==1){
							$('#cargaTablaCategorias').load("../vistas/categoriasGastos/tabla.php");
							alertify.success("Actualizado con éxito.");
						}else{
							alertify.error("No se pudo actualizar.");
						}
					}
				});
			});
		});
		

	
		function editaCategoria(idCategoria,categoria){
			$('#idcategoria').val(idCategoria);
			$('#categoriaEditar').val(categoria);
		}

		function eliminaCategoria(idcategoria){
			alertify.confirm('¿Desea eliminar esta categoria?', function(){ 
				$.ajax({
					type:"POST",
					data:"idcategoria=" + idcategoria,
					url:"../acciones/categoriasGastos/eliminarCategoria.php",
					success:function(r){
						if(r==1){
							$('#cargaTablaCategorias').load("../vistas/categoriasGastos/tabla.php");
							alertify.success("Eliminado con exito.");
						}else{
							alertify.error("No se pudo eliminar.");
						}
					}
				});
			}, function(){ 
				alertify.error('Operación cancelada.')
			});
		}
