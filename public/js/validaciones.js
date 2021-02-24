
function validar_plato(){
    nombre = document.getElementById("nombre").value;
    costo = document.getElementById("p_costo").value;
    venta = document.getElementById("p_venta").value;
    if (nombre.length == 0 || /^\s+$/.test(nombre)){
        alert('Ingrese el nombre de Producto');         
        return false;
    }
    else if (nombre.length>50){
        alert('Máximo de caracteres excedido en Nombre');         
        return false;
    }
    else if (costo.length == 0 || /^\s+$/.test(costo)){
        alert('¿Precio de Costo?');         
        return false;
    }
    else if (venta.length == 0 || /^\s+$/.test(venta)){
        alert('¿Precio de Venta?');         
        return false;
    }

    return true;
}