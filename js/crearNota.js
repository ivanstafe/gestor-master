$(document).ready(function(){
    $('#clienteVenta').select2();
    $('#productoVenta').select2();

});


	$(document).ready(function(){

		$('#tablaNotasTempLoad').load("notasCredito/tablaNotasTemp.php");

		$('#productoVenta').change(function(){
			$.ajax({
				type:"POST",
				data:"idproducto=" + $('#productoVenta').val(),
				url:"../acciones/notasCredito/llenarFormProducto.php",
				success:function(r){
					dato=jQuery.parseJSON(r);

					$('#descripcionV').val(dato['descripcion']);
					$('#cantidadV').val(dato['cantidad']);
					$('#precioV').val(dato['precio']);

					$('#imgProducto').prepend('<img class="img-thumbnail" id="imgp" src="' + dato['ruta'] + '" />');
				}
			});
		});

        $('#btnAgregaVenta').click(function(){
            vacios = validarFormVacio('formVentasProductos');
        
            if (vacios > 0) {
                alertify.alert("Debes llenar todos los campos!!");
                return false;
            }
        
            var cantidadInput = parseInt($('#cantidadV').val()); // Cantidad ingresada en el input
        
            if (cantidadInput <= 0) {
                alertify.alert("La cantidad ingresada debe ser mayor que cero");
                return false;
            }
        
            obtenerCantidadDisponible(function(cantidadBD) {
                if (cantidadInput > cantidadBD) {
                    alertify.alert("La cantidad ingresada es mayor que la disponible en inventario");
                    return false;
                }
        
                var datos = $('#formVentasProductos').serialize();
        
                var descuento = $('#descuentoV').val(); 
                datos += '&descuentoV=' + descuento;

                $.ajax({
                    type: "POST",
                    data: datos,
                    url: "../acciones/notasCredito/agregaProductoTemp.php",
                    success: function(r){
                        $('#tablaNotasTempLoad').load("notasCredito/tablaNotasTemp.php", function() {
                            var idProducto = $('#productoVenta').val();
        
                            obtenerCantidadSesion(function(cantidadSesion) {
                              
        
                                var cantidadSesionInt = parseInt(cantidadSesion);
                                var cantidadRestante = cantidadBD - cantidadSesionInt;
        
                                $('#cantidadV').val(cantidadRestante);
        
                          
                       
                                //para mostrar en el html
                                // $('#cantidadSesionInt').text(cantidadSesionInt)
                                // $('#cantidadInputValue').text(cantidadInput);
                                // $('#cantidadBDValue').text(cantidadBD);
                              
                            });
                        });
                    }
                });
            });
        });
        
        function obtenerCantidadDisponible(callback) {
            var idProducto = $('#productoVenta').val();
        
            $.ajax({
                type: "POST",
                url: "../acciones/notasCredito/obtenerCantidadDisponible.php",
                data: { idproducto: idProducto }, 
                success: function(response) {
                    var cantidad = parseInt(response);
                    callback(cantidad);
                }
            });
        }
        
        function obtenerCantidadSesion(callback) {
            var idProducto = $('#productoVenta').val();
        
            $.ajax({
                type: "POST",
                url: "../acciones/notasCredito/obtenerCantidadSesion.php",
                data: { idProducto: idProducto },
                success: function(response) {
                    callback(response);
                }
            });
        }
        function validarFormVacio(formulario){
            var datos = $('#' + formulario).serializeArray();
            var vacios = 0;
        
            // Recorrer todos los campos excepto el último
            for (var i = 0; i < datos.length - 1; i++) {
                // Verificar si el valor del campo está vacío o es "A"
                if (datos[i].value === "A" || datos[i].value === ""){
                    vacios++;
                }
            }
        
            return vacios;
        }
        

        $('#btnVaciarVentas').click(function(){
            $('#formVentasProductos')[0].reset();
        });
        

	});



    function crearNota() {
        var idCliente = $("#clienteVenta").val();
        var descuento = $("#descuento").val(); 

        
        console.log("ID Cliente: " + idCliente);
        console.log("Descuento: " + descuento);
        
        $.ajax({
            url: "../acciones/notasCredito/crearNota.php",
            method: "POST",
            data: { 
                clienteVenta: idCliente, 
                descuento: descuento
            },
            success: function(r) {
                if (r > 0) {
                    $('#tablaNotasTempLoad').load("notasCredito/tablaNotasTemp.php");
                    $('#formVentasProductos')[0].reset();
                    alertify.alert("Nota de crédito creada con éxito");
                } else if (r == 0) {
                    alertify.alert("No hay lista de nota de crédito.");
                } else {
                    alertify.error("No se pudo crear la nota de crédito");
                }
            }
        });
    }
    
	
