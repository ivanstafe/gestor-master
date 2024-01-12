$(document).ready(function(){

    $('#cargaTablaProveedores').load("../vistas/proveedores/tabla.php");

    $('#btnAgregarProveedor').click(function(){

        vacios=validarFormVacio('formProveedores');

        if(vacios > 0){
            alertify.alert("Completa todos los campos.");
            return false;
        }

        datos=$('#formProveedores').serialize();

        $.ajax({
            type:"POST",
            data:datos,
            url:"../acciones/proveedores/agregarProveedor.php",
            success:function(r){

                if(r==1){
                    $('#formProveedores')[0].reset();
                    $('#cargaTablaProveedores').load("../vistas/proveedores/tabla.php");
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




		function actualizarDatosProveedor(idproveedor){

			$.ajax({
				type:"POST",
				data:"idproveedor=" + idproveedor,
				url:"../acciones/proveedores/obtenerDatosProveedor.php",
				success:function(r){
					dato=jQuery.parseJSON(r);
					$('#idproveedorEditar').val(dato['id_proveedor']);
					$('#nombreEditar').val(dato['razon_social']);
					$('#direccionEditar').val(dato['direccion']);
					$('#cuitEditar').val(dato['cuit']);
					$('#emailEditar').val(dato['email']);
					$('#telefono1Editar').val(dato['telefono']);
					$('#telefono2Editar').val(dato['telefono2']);
				
				

				}
			});
		}

		function eliminarProveedor(idproveedor){
			alertify.confirm('¿Desea eliminar este proveedor?', function(){ 
				$.ajax({
					type:"POST",
					data:"idproveedor=" + idproveedor,
					url:"../acciones/proveedores/eliminarProveedor.php",
					success:function(r){
						if(r==1){
							$('#cargaTablaProveedores').load("../vistas/proveedores/tabla.php");
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
	
		

		$(document).ready(function() {
			var cerrarModal = true;
		
			$('#btnActualizarProveedor').click(function() {
				var formulario = 'formProveedoresEditar';
				var camposVacios = validarFormVacio(formulario);
		
				if (camposVacios > 0) {
					cerrarModal = false;
					alertify.alert('Por favor, complete todos los campos.', function() {
						cerrarModal = true; 
					}).show();
				} else {
					var datos = $('#' + formulario).serialize();
		
					$.ajax({
						type: "POST",
						data: datos,
						url: "../acciones/proveedores/actualizarProveedor.php",
						success: function(r) {
							if (r == 1) {
								$('#formProveedores')[0].reset();
								$('#cargaTablaProveedores').load("../vistas/proveedores/tabla.php");
								alertify.success("Actualizado con éxito.");
							} else {
								alertify.error("Error al actualizar.");
							}
						}
					}).done(function() {
						cerrarModal = true; 
					});
				}
		
				// Evitar que se cierre el modal
				return cerrarModal;
			});
		});
		
		

		
		
		