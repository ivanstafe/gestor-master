

$(document).ready(function(){
    $('#ventaProductosBtn').click(function(){
        hide();
        $('#venderP').load('../vistas/ventas/venderProducto.php');
        $('#venderP').show();
    });
    $('#ventasHechasBtn').click(function(){
        hide(); 
        $('#ventasR').load('../vistas/ventas/ventasRealizadas.php'); 
        $('#ventasR').show();  
    });
});

function hide(){
    $('#venderP').hide();
    $('#ventasR').hide();
}

