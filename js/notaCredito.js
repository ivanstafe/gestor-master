

$(document).ready(function(){
    $('#crearNotaBtn').click(function(){
        hide();
        $('#notasP').load('../vistas/notasCredito/crearNotaCredito.php');
        $('#notasP').show();
    });
    $('#notasHechasBtn').click(function(){
        hide(); 
        $('#notasR').load('../vistas/notasCredito/notasCreditoRealizadas.php'); 
        $('#notasR').show();  
    });
});

function hide(){
    $('#notasP').hide();
    $('#notasR').hide();
}

