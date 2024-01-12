function ajustarInsumo(idInsumo) {
  $.ajax({
      type: "POST",
      data: "idInsumo=" + idInsumo,
      url: "../acciones/ajusteInsumos/obtenerDatosInsumo.php",
      success: function(r) {
          dato = jQuery.parseJSON(r);
          $('#idInsumoEditar').val(dato['id_insumo']);
          $('#cantidadEditar').val(dato['cantidad']);
          $('#precioEditar').val(dato['precio']);
      },
      error: function(xhr, status, error) {
          console.log("Error en la solicitud AJAX:", error);
      }
  });
}

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

  $(document).ready(function() {
    $('#cargaTablaAjustes').load("../vistas/ajusteInsumos/tabla.php");

    $('#btnActualizarAjusteInsumo').click(function() {
        vacios = validarFormVacio('formAjusteInsumoEditar');
        var datos = $('#formAjusteInsumoEditar').serialize(); // Reordenado para asegurar la captura de datos
        console.log("Datos a enviar:", datos);
        if (vacios > 0) {
            alertify.alert("Completa todos los campos.");
            return false;
        }

        $.ajax({
            type: "POST",
            data: datos,
            url: "../acciones/ajusteInsumos/insertarAjusteInsumo.php",
            success: function(r) {
                if (r == 1) {
                    $('#formAjusteInsumoEditar')[0].reset();
                    $('#cargaTablaAjustes').load("../vistas/ajusteInsumos/tabla.php");
                    alertify.success("Agregado con éxito.");
                } else {
                    alertify.error("No se pudo agregar.");
                }
            }
        });
    });


  
  $('#accionCantidad').change(function() {
    var seleccion = $(this).val();
    var cantidadInput = $('#cantidadEditar');

    if (seleccion === 'disminuir') {
      var cantidad = cantidadInput.val();
      if (parseFloat(cantidad) > 0) {
        cantidadInput.val('-' + cantidad);
      }
      $('#accionSeleccionada').val(seleccion);
    } else {
      $('#accionSeleccionada').val(seleccion);
    }
  });


});


// Función para cambiar el estado al hacer clic en los botones de activar/desactivar
$('#tabla-insumos').on('click', '.btn-primary', function() {
    var idInsumo = $(this).closest('tr').attr('id');
    var estadoActual = $(this).text().trim() === 'Desactivar' ? true : false;
    cambiarEstado(idInsumo, estadoActual);
  });
  
  // Aquí ahora está la función cambiarEstado fuera del document.ready
  function cambiarEstado(idInsumo, estadoActual) {
    var nuevoEstado = !estadoActual;
  
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        console.log("Estado actual:", estadoActual);
        var nuevoEstado = !estadoActual;
        console.log("Nuevo estado:", nuevoEstado);
        
        $('#cargaTablaAjustes').load("../vistas/ajusteInsumos/tabla.php");
      }
    };
    xhttp.open("POST", "../acciones/ajusteInsumos/actualizarEstado.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id_insumo=" + idInsumo + "&nuevo_estado=" + nuevoEstado);
  }
  

