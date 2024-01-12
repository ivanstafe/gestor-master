$(document).ready(function(){

    $('#cargaTablaUsuarios').load('../vistas/administrarUsuarios/tabla.php');

    $('#btnAgregarUsuario').click(function(){

        vacios=validarFormVacio('formUsuarios');

        if(vacios > 0){
            alertify.alert("Completa todos los campos.");
            return false;
        }

        var password = $('#password').val();
        if (password.length < 6) {
            alertify.alert("La contraseña debe tener al menos 6 caracteres.");
            return false;
        }

        datos=$('#formUsuarios').serialize();
        $.ajax({
            type:"POST",
            data:datos,
            url:"../acciones/administrarUsuarios/agregarUsuario.php",
            success:function(r){
                //alert(r);

                if(r==1){
                    $('#formUsuarios')[0].reset();
                    $('#cargaTablaUsuarios').load('../vistas/administrarUsuarios/tabla.php');
                    alertify.success("Agregado con éxito.");
                }else{
                    alertify.error("Fallo al agregar.");
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


function actualizarDatosUsuario(idusuario) {
    $.ajax({
        type: "POST",
        data: "idusuario=" + idusuario,
        url: "../acciones/administrarUsuarios/obtenerDatosUsuario.php",
        success: function (r) {
            dato = jQuery.parseJSON(r);

            $('#idUsuario').val(dato['id_usuario']);
            $('#nombreEditar').val(dato['nombre']);
            $('#apellidoEditar').val(dato['apellido']);
            $('#tipoEditar').val(dato['tipo']);
            $('#passwordEditar').val(dato['password']);

            // Validación de contraseña al cargar datos
            if (dato['password'].length < 6) {
                alertify.error("La contraseña debe tener al menos 6 caracteres");
            }
        }
    });
}

function eliminarUsuario(idusuario) {
    alertify.confirm('¿Desea eliminar este usuario?', function () {
        $.ajax({
            type: "POST",
            data: "idusuario=" + idusuario,
            url: "../acciones/administrarUsuarios/eliminarUsuario.php",
            success: function (r) {
                if (r == 1) {
                    $('#cargaTablaUsuarios').load('../vistas/administrarUsuarios/tabla.php');
                    alertify.success("Eliminado con exito.");
                } else {
                    alertify.error("No se pudo eliminar.");
                }
            }
        });
    }, function () {
        alertify.error('Cancelo !')
    });
}

$(document).ready(function () {
    var cerrarModal = true;

    $('#btnActualizarUsuario').click(function () {
        var formulario = 'formUsuariosEditar';
        var camposVacios = validarFormVacio(formulario);

        if (camposVacios > 0) {
            cerrarModal = false;
            alertify.alert('Por favor, complete todos los campos.', function () {
                cerrarModal = true;
            }).show();
        } else {
            var datos = $('#' + formulario).serialize();

            // Validación de contraseña antes de actualizar
            var passwordValue = $('#passwordEditar').val();
            if (passwordValue.length < 6) {
                alertify.error("La contraseña debe tener al menos 6 caracteres");
                return; // Se detiene el envío del formulario
            }

            $.ajax({
                type: "POST",
                data: datos,
                url: "../acciones/administrarUsuarios/actualizarUsuario.php",
                success: function (r) {
                    if (r == 1) {
                        $('#cargaTablaUsuarios').load('../vistas/administrarUsuarios/tabla.php');
                        alertify.success("Actualizado con éxito");
                    } else {
                        alertify.error("No se pudo actualizar");
                    }
                }
            }).done(function () {
                cerrarModal = true;
            });
        }

        // Evitar que se cierre el modal
        return cerrarModal;
    });
});
