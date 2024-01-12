$(document).ready(function(){

    $('#cargaTablaClientes').load("../vistas/clientes/tabla.php");

    $('#btnAgregarCliente').click(function(){

        vacios=validarFormVacio('formClientes');

        if(vacios > 0){
            alertify.alert("Completa todos los campos.");
            return false;
        }

        datos=$('#formClientes').serialize();

        $.ajax({
            type:"POST",
            data:datos,
            url:"../acciones/clientes/agregarCliente.php",
            success:function(r){

                if(r==1){
                    $('#formClientes')[0].reset();
                    $('#cargaTablaClientes').load("../vistas/clientes/tabla.php");
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




		function actualizarDatosCliente(idcliente){

			$.ajax({
				type:"POST",
				data:"idcliente=" + idcliente,
				url:"../acciones/clientes/obtenerDatosCliente.php",
				success:function(r){
					dato=jQuery.parseJSON(r);
					$('#idclienteEditar').val(dato['id_cliente']);
					$('#nombreEditar').val(dato['nombre']);
					$('#apellidosEditar').val(dato['apellido']);
					$('#direccionEditar').val(dato['direccion']);
					$('#cuitEditar').val(dato['cuit']);
					$('#emailEditar').val(dato['email']);
					$('#telefonoEditar').val(dato['telefono']);
					$('#telefono2Editar').val(dato['telefono2']);

				}
			});
		}

		function eliminarCliente(idcliente){
			alertify.confirm('¿Desea eliminar este cliente?', function(){ 
				$.ajax({
					type:"POST",
					data:"idcliente=" + idcliente,
					url:"../acciones/clientes/eliminarCliente.php",
					success:function(r){
						if(r==1){
							$('#cargaTablaClientes').load("../vistas/clientes/tabla.php");
							alertify.success("Eliminado con exito.");
						}else{
							alertify.error("No se pudo eliminar.");
						}
					}
				});
			}, function(){ 
				alertify.error('Cancelado.')
			});
		}
	
		

		$(document).ready(function(){
			$('#btnActualizarCliente').click(function(event){
				var formulario = 'formClientesEditar';
				var camposVacios = validarFormVacio(formulario);
		
				if (camposVacios > 0) {
					alertify.alert('Complete todos los campos.');
		
					
					event.preventDefault();
					var cerrarModal = false;
		
					
					alertify.alert().setting({
						'onok': function(){
							cerrarModal = true;
						}
					});
		
					
					return cerrarModal;
				} else {
					datos=$('#' + formulario).serialize();
					$.ajax({
						type:"POST",
						data:datos,
						url:"../acciones/clientes/actualizarCliente.php",
						success:function(r){
							if(r==1){
								$('#formClientes')[0].reset();
								$('#cargaTablaClientes').load("../vistas/clientes/tabla.php");
								alertify.success("Actualizado con éxito.");
							} else {
								alertify.error("Error al actualizar.");
							}
						}
					});
				}
			});
		});
		

