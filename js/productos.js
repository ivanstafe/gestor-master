$(document).ready(function(){
    $('#cargaTablaProductos').load("../vistas/productos/tabla.php");  

    $('#btnAgregarProducto').click(function(){          

        vacios=validarFormVacio('formProductos');          

        if(vacios > 0){
            alertify.alert("Completa todos los campos.");
            return false;
        }

        var formData = new FormData(document.getElementById("formProductos"));

        $.ajax({
            url: "../acciones/productos/agregarProductos.php",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            success:function(r){
                
                if(r == 1){
                    $('#formProductos')[0].reset();   
					$('#cargaTablaProductos').load("../vistas/productos/tabla.php");
                    alertify.success("Agregado con exito.");
                }else{
                    alertify.error("Error al Agregar.");
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


// Deshabilitar todos los campos al inicio excepto la cantidad
$('#categoriaSelectEditar, #nombreEditar, #descripcionEditar, #precioEditar').prop('readonly', true);
$('#cantidadEditar, #precioEditar').prop('readonly', false);

$('#toggleCantidad').change(function() {
    var valorSeleccionado = $(this).val();
    if (valorSeleccionado === 'habilitado') {
        // Habilitar los campos excepto la cantidad
        $('#categoriaSelectEditar, #nombreEditar, #descripcionEditar').prop('readonly', false);
        $('#cantidadEditar').prop('readonly', true); // Deshabilitar la cantidad
    } else {
        // Deshabilitar todos los campos excepto la cantidad
        $('#categoriaSelectEditar, #nombreEditar, #descripcionEditar, #precioEditar').prop('readonly', true);
        $('#cantidadEditar, #precioEditar').prop('readonly', false); // Habilitar la cantidad
    }
});


        
        
        function actualizarDatosProducto(idProducto){   
			$.ajax({                                     
				type:"POST",                              
				data:"idPro=" + idProducto,
				url:"../acciones/productos/obtenerDatosProducto.php",
				success:function(r){
					
					dato=jQuery.parseJSON(r);
					$('#idProducto').val(dato['id_producto']);
					$('#categoriaSelectEditar').val(dato['id_categoria']);
					$('#nombreEditar').val(dato['nombre']);
					$('#descripcionEditar').val(dato['descripcion']);
					// $('#cantidadEditar').val(dato['total_cantidad']);
					// $('#cantidadEditar').val(dato['']);
					$('#precioEditar').val(dato['precio']);

				}
			});
		}


		$(document).ready(function() {
            $('#btnActualizarProducto').click(function() {
                var valorSeleccionado = $('#toggleCantidad').val();
                var camposHabilitados;
        
                if (valorSeleccionado === 'habilitado') {
                    camposHabilitados = ['nombreEditar', 'descripcionEditar', 'precioEditar'];
                } else {
                    camposHabilitados = ['cantidadEditar', 'precioEditar'];
                }
        
                var camposVacios = camposHabilitados.filter(function(campo) {
                    return $('#' + campo).val().trim() === '';
                });
        
                if (camposVacios.length > 0) {
                    alertify.alert("Complete todos los campos.", function(){
                
                    });
                    return false; 
                }
        
                
                var datos = $('#formProductosEditar').serialize();
                $.ajax({
                    type: "POST",
                    data: datos,
                    url: "../acciones/productos/actualizarProducto.php",
                    success: function(r) {
                        if (r == 1) {
                            $('#cargaTablaProductos').load("../vistas/productos/tabla.php");
                            alertify.success("Actualizado con éxito.");
                        } else {
                            alertify.error("Error al actualizar.");
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
        
		


		
		

		

