
	
	$(document).ready(function(){
		$('#entrarSistema').click(function(){

		vacios=validarFormVacio('formLogin');

			if(vacios > 0){
				alert("Completa todos los campos.");
				return false;
			}

		datos=$('#formLogin').serialize();
		$.ajax({
			type:"POST",
			data:datos,
			url:"acciones/registro/login.php",
			success:function(r){

				if(r==1){
					window.location="vistas/inicio.php";
				}else{
					alert("No se pudo acceder");
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
