$(document).ready(function(){
    $('#registro').click(function(){
        var vacios = validarFormVacio('formRegistro');
        var password = $("#password").val();

        if (vacios > 0) {
            alert("Completa todos los campos.");
            return false;
        }

        if (password.length < 6) {
            alert("La contraseña debe tener al menos 6 caracteres.");
            return false;
        }

        var datos = $('#formRegistro').serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "acciones/registro/registroUsuario.php",
            success: function(r){
                alert(r);

                if (r == 1) {
                    alert("Agregado con éxito.");
                } else {
                    alert("Fallo al agregar.");
                }
            }
        });
    });
});

function validarFormVacio(formulario) {
    var datos = $('#' + formulario).serialize();
    var d = datos.split('&');
    var vacios = 0;
    
    for (var i = 0; i < d.length; i++) {
        var controles = d[i].split("=");
        if (controles[1] == "" || controles[1].trim() === "") {
            vacios++;
        }
    }
    
    return vacios;
}

$(document).ready(function() {
    $("#formRegistro").submit(function() {
        var password = $("#password").val();
        if (password.length < 6) {
            alert("La contraseña debe tener al menos 6 caracteres.");
            return false; // Evita el envío del formulario
        }
    });
});
