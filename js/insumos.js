
$('#cargaTablaInsumos').load("../vistas/insumos/tabla.php");

$('#btnAgregarInsumos').click(function () {
    vacios = validarFormVacio('formInsumos');

    if (vacios > 0) {
        alertify.alert("Completa todos los campos.");
        return false;
    }

    var formData = new FormData(document.getElementById("formInsumos"));

    $.ajax({
        url: "../acciones/insumos/agregarInsumos.php",
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (r) {
            if (r == 1) {
                $('#formInsumos')[0].reset();
                $('#cargaTablaInsumos').load("../vistas/insumos/tabla.php");
                alertify.success("Agregado con éxito.");
            } else {
                alertify.error("Error al agregar.");
            }
        }
    });
});


function validarFormVacio(formulario) {
    datos = $('#' + formulario).serialize();
    d = datos.split('&');
    vacios = 0;
    for (i = 0; i < d.length; i++) {
        controles = d[i].split("=");
        if (controles[1] == "A" || controles[1] == "") {
            vacios++;
        }
    }
    return vacios;
}



$('#nombreEditar, #descripcionEditar').prop('readonly', true);

$(document).ready(function() {
    $('#toggleCantidad').change(function() {
        var valorSeleccionado = $(this).val();
        if (valorSeleccionado === 'habilitado') {
            // Inhabilitar y vaciar campos excepto precio, descripcion y nombre
            $('#precioEditar, #metodoPagoEditar, #numeroFacturaEditar, #fechaPagoEditar, #estadoPagoEditar, #cantidadEditar').val('').prop('disabled', true).val;
            $('#nombreEditar, #descripcionEditar').prop('readonly', false);
        } else {
            // Habilitar todos los campos
            $('#nombreEditar, #descripcionEditar').prop('readonly', true);

            $('#precioEditar, #metodoPagoEditar, #numeroFacturaEditar, #fechaPagoEditar, #estadoPagoEditar, #cantidadEditar').prop('disabled', false);
        }
    });

    $('#accionCantidad').change(function () {
        var seleccion = $(this).val();

        if (seleccion === 'incrementar') {
            // Campos que se vacían pero siguen habilitados
            $('cantidadEditar, #metodoPagoEditar, #numeroFacturaEditar, #fechaPagoEditar, #estadoPagoEditar, #precioEditar',).val('').prop('disabled', false);
            
            $('#nombreEditar, #descripcionEditar').prop('readonly', true);
            $('#cantidadEditar').prop('disabled', false).val('');

        

            $('#accionSeleccionada').val(seleccion);
        } else if (seleccion === 'disminuir') {
            // No hay cambios para el caso de disminuir
            // Campos que se habilitan
            $('#cantidadEditar').prop('disabled', false).val('1');
            var cantidadInput = $('#cantidadEditar');
            var cantidad = cantidadInput.val();
            if (parseFloat(cantidad) > 0) {
                cantidadInput.val('-' + cantidad);
            }

            // Campos que se desactivan y se vacían
            $('#precioEditar, #metodoPagoEditar, #numeroFacturaEditar, #fechaPagoEditar, #estadoPagoEditar').prop('disabled', true).val('');

            $('#accionSeleccionada').val('habilitado');
        }
    });
});



function actualizarDatosInsumo(idInsumo) {
    $.ajax({
        type: "POST",
        data: { idIns: idInsumo },
        url: "../acciones/insumos/obtenerDatosInsumo.php",
        success: function (r) {
            dato = jQuery.parseJSON(r);
            $('#idInsumo').val(dato['id_insumo']);
            $('#categoriaSelectEditar').val(dato['id_categoria']);
            $('#nombreEditar').val(dato['nombre']);
            $('#descripcionEditar').val(dato['descripcion']);
            $('#precioEditar').val(dato['precio']);
            $('#accionCantidad').val(dato['accion_cantidad']);
            $('#cantidadEditar').val(dato['cantidad_total']);
            $('#proveedorSelectEditar').val(dato['id_proveedor']);
            $('#metodoPagoEditar').val(dato['metodo_pago']);
            $('#numeroFacturaEditar').val(dato['numero_factura']);
            $('#fechaPagoEditar').val(dato['fecha_pago']);
            $('#estadoPagoEditar').val(dato['estado_pago']);
        }
    });
}



function eliminarInsumo(idInsumo) {
    alertify.confirm('¿Desea eliminar este insumo?', function () {
        $.ajax({
            type: "POST",
            data: "idInsumo=" + idInsumo,
            url: "../acciones/insumos/eliminarInsumo.php",
            success: function (r) {
                if (r == 1) {
                    $('#cargaTablaInsumos').load("../vistas/insumos/tabla.php");
                    alertify.success("Eliminado con éxito.");
                } else {
                    alertify.error("No se pudo eliminar.");
                }
            }
        });
    }, function () {
        alertify.error('Cancelado.')
    });
}






$(document).ready(function() {
    $('#btnActualizarInsumo').click(function() {
        var valorSeleccionado = $('#toggleCantidad').val();
        var accionSeleccionada = $('#accionCantidad').val();
        console.log('Valor Seleccionado:', valorSeleccionado);
        console.log('Accion Seleccionada:', accionSeleccionada);

        var camposHabilitados = [];
        var camposVacios = [];

        if (valorSeleccionado === 'habilitado') {
            if ($('#nombreEditar').val().trim() === '' || $('#descripcionEditar').val().trim() === '') {
                alertify.alert('Complete los campos de Nombre y Descripción.');
                return false; 
            }
        }

        if (valorSeleccionado === 'deshabilitado' && (accionSeleccionada !== 'disminuir' && accionSeleccionada !== 'incrementar')) {
            alertify.alert('Seleccione un tipo de ingreso: "disminuir" o "incrementar".');
            return false; 
        }

        if (valorSeleccionado === 'deshabilitado' && (accionSeleccionada === 'disminuir' || accionSeleccionada === 'incrementar')) {
            camposHabilitados = ['metodoPagoEditar', 'numeroFacturaEditar', 'fechaPagoEditar', 'estadoPagoEditar'];
        }

        if (accionSeleccionada === 'disminuir') {
            if ($('#cantidadEditar').val().trim() === '') {
                alertify.alert('Complete el campo "Cantidad".');
                return false;
            }
            camposHabilitados = ['cantidadEditar'];
        }

        if (accionSeleccionada === 'incrementar') {
            camposHabilitados = ['precioEditar', 'metodoPagoEditar', 'numeroFacturaEditar', 'fechaPagoEditar', 'estadoPagoEditar'];
        }

        camposVacios = camposHabilitados.filter(function(campo) {
            var valorCampo = $('#' + campo).val();
            return valorCampo === null || valorCampo.trim() === '';
        });

        if (camposVacios.length > 0) {
            alertify.alert('Complete todos los campos.');
            return false; 
        }

        var datos = $('#formInsumosEditar').serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "../acciones/insumos/actualizarInsumo.php",
            success: function(r) {
                if (r == 1) {
                    $('#cargaTablaInsumos').load("../vistas/insumos/tabla.php");
                    alertify.success("Actualizado con éxito.");
                } else {
                    $('#cargaTablaInsumos').load("../vistas/insumos/tabla.php");
                    
                    // alertify.error("Error al actualizar.");
                    alertify.success("Actualizado con éxito.");

                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
});

