function actualizarDatosGasto(idGasto) {
    $.ajax({
        type: "POST",
        data: "idGas=" + idGasto,
        url: "../acciones/gastos/obtenerDatosGasto.php",
        success: function(r) {
            dato = jQuery.parseJSON(r);
            $('#idGasto').val(dato['id_gasto']);
            $('#categoriaSelectEditar').val(dato['id_categoria']); 
            $('#nombreEditar').val(dato['nombre']);
            $('#descripcionEditar').val(dato['descripcion']);
            $('#cantidadEditar').val(dato['cantidad']);
            $('#precioEditar').val(dato['precio']);
            $('#fechaPagoEditar').val(dato['fecha_gasto']); 
            $('#metodoDePagoEditar').val(dato['metodoDePago']); 
            $('#numeroDeFacturaEditar').val(dato['numeroDeFactura']); 
            $('#estadoPagoEditar').val(dato['estadoPago']); 
        }
    });
}



function eliminarGasto(idGasto){
    
    
    alertify.confirm('¿Desea eliminar este gasto?', function(){ 
        $.ajax({
            type:"POST",
            data:"idGasto=" + idGasto,
            url:"../acciones/gastos/eliminarGasto.php",
            success:function(r){
                if(r==1){
                    $('#cargaTablaGastos').load("../vistas/gastos/tabla.php");
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
    $('#btnActualizarGasto').click(function(event){
        var formulario = 'formGastosEditar';
        var camposVacios = validarFormVacio(formulario);

        if (camposVacios > 0) {
            alertify.alert('Por favor, complete todos los campos.');
            
            // Evitar que se cierre el modal
            event.preventDefault();
            var cerrarModal = false;

            // Hacer algo después de la alerta
            alertify.alert().setting({
                'onok': function(){
                    cerrarModal = true;
                }
            });
        } else {
            datos=$('#' + formulario).serialize();
            $.ajax({
                type:"POST",
                data:datos,
                url:"../acciones/gastos/actualizarGasto.php",
                success:function(r){
                    if(r==1){
                        $('#cargaTablaGastos').load("../vistas/gastos/tabla.php");
                        alertify.success("Actualizado con éxito.");
                    } else {
                        alertify.error("Error al actualizar.");
                    }
                }
            });
        }

        // Retornar el valor para cerrar o no el modal
        return cerrarModal;
    });
});


$(document).ready(function(){
    $('#cargaTablaGastos').load("../vistas/gastos/tabla.php");

    $('#btnAgregarGastos').click(function(){

        vacios=validarFormVacio('formGastos');

        if(vacios > 0){
            alertify.alert("Completa todos los campos.");
            return false;
        }

        var formData = new FormData(document.getElementById("formGastos"));

        $.ajax({
            url: "../acciones/gastos/agregarGasto.php",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            success:function(r){
                
                if(r == 1){
                    $('#formGastos')[0].reset();
                    $('#cargaTablaGastos').load("../vistas/gastos/tabla.php");
                    alertify.success("Agregado con exito.");
                }else{
                    alertify.error("Error al agregar.");
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
	
