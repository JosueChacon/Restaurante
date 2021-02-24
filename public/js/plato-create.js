
$(document).ready(function(){
    $('#grabar').click(function(){
        validar();
    });
});

function validar(){
    nombre = $('#nombre').val().trim();    
    if (nombre == ''){
        alert('Ingrese nombre de plato, Porfavor');
        return;
    }
    pcosto = $('#p_costo').val();
    if (pcosto==''){
        alert('Ingrese precio de costo');
        return;
    }
    let precio_costo = parseFloat($('#p_costo').val());
    if (precio_costo == 0){
        alert('El precio de costo debe ser mayor a 0');
        return;
    }
    pventa = $('#p_venta').val();
    if (pventa==''){
        alert('Ingrese precio de venta');
        return;
    }
    let precio_venta = parseFloat($('#p_venta').val());
    if (precio_venta == 0){
        alert('El precio de venta debe ser mayor a 0');
        return;
    }
    document.forms['frmPlato'].submit();
}