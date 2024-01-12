function ajustarProducto(idproducto) {
  $.ajax({
    type: "POST",
    data: "idproducto=" + idproducto,
    url: "../acciones/ajusteProductos/obtenerDatosProducto.php",
    success: function(r) {
      dato = jQuery.parseJSON(r);
      $('#idProductoEditar').val(dato['id_producto']);
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
  $('#cargaTablaAjustes').load("../vistas/ajusteProductos/tabla.php");

  $('#btnActualizarAjusteProducto').click(function() {
    var datos = $('#formAjusteProductoEditar').serialize();
    var vacios = validarFormVacio('formAjusteProductoEditar');
    
    if (vacios > 0) {
      alertify.alert("Completa todos los campos.");
      return false;
    }

    $.ajax({
      type: "POST",
      data: datos,
      url: "../acciones/ajusteProductos/insertarAjusteProducto.php",
      success: function(r) {
        if (r == 1) {
          $('#formAjusteProductoEditar')[0].reset();
          $('#cargaTablaAjustes').load("../vistas/ajusteProductos/tabla.php");
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
$('#tabla-productos').on('click', '.btn-primary', function() {
  var idProducto = $(this).closest('tr').attr('id');
  var estadoActual = $(this).text().trim() === 'Desactivar' ? true : false;
  cambiarEstado(idProducto, estadoActual);
});

// Aquí ahora está la función cambiarEstado fuera del document.ready
function cambiarEstado(idProducto, estadoActual) {
  var nuevoEstado = !estadoActual;

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      console.log("Estado actual:", estadoActual);
      var nuevoEstado = !estadoActual;
      console.log("Nuevo estado:", nuevoEstado);
      
      $('#cargaTablaAjustes').load("../vistas/ajusteProductos/tabla.php");
    }
  };
  xhttp.open("POST", "../acciones/ajusteProductos/actualizarEstado.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("id_producto=" + idProducto + "&nuevo_estado=" + nuevoEstado);
}
