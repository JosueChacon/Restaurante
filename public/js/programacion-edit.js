
$(document).ready(function(){
    $('#grabar').click(function(){
        validar();
    });
});

function validar(){
    var table=document.getElementById('tabla');        
    var c = table.rows.length;
    if (c==1) 
        alert('Debe añadir detalles, Porfavor');
    else 
        document.forms['frmProgramacion'].submit();
}