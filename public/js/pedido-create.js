var pos=0;
$(document).ready(function () {
    $('#grabar').click(function () {
        validar();
    });
});

function validar() {
    var table = document.getElementById('data-table');
    var c = table.rows.length;
    if (c == 1)
        alert('Debe añadir detalles, Porfavor');
    else
        document.forms['frmPedido'].submit();
}

function pasar(idplato, nombre, tipo, stock, p_venta) {
    document.getElementById("idplato").value = idplato;
    document.getElementById("nombre").value = nombre;
    document.getElementById("tipo").value = tipo;
    document.getElementById("stock").value = stock;
    document.getElementById("p_venta").value = p_venta;
}

function agregar() {
    var idplato = $('#idplato').val();
    if (idplato == '') {
        alert('Seleccione un plato, Porfavor');
        return;
    }
    var cant = $('#cantidad').val();
    if (cant == '') {
        alert('Ingrese cantidad, Porfavor');
        return;
    }
    let cantidad = parseFloat($('#cantidad').val());
    if (cantidad == 0) {
        alert('La cantidad debe ser mayor a 0, Porfavor');
        return;
    }

    var dt = document.getElementById('data-table');
    var existe = false;
    for (i = 0; i < dt.rows.length; i++) {
        if (idplato == dt.rows[i].cells[0].innerText) {
            existe = true;
            break;
        }
    }

    if (existe) {
        alert('El plato ya está en lista');
        return;
    }

    var nombre = $('#nombre').val();
    var tipo = $('#tipo').val();
    var p_venta = $('#p_venta').val();
    var subtotal = p_venta * cantidad;
    var fila = '<tr>' +
        '<td><a href="#" style="margin-top: -5pt" onclick="deleteRow(this); return false;" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Quitar</a></td>' +
        '<td>' + (pos+1) + '</td>' +
        '<td>' + nombre + '</td>' +
        '<td>' + tipo + '</td>' +
        '<td class="text-right">S/. &nbsp;' + p_venta + '</td>' +
        '<td class="text-right">' + cantidad + '</td>' +
        '<td class="text-right">S/. &nbsp;' + number_format(subtotal, 2) + '</td>' +
        '</tr>';
    $('#detalles').append(fila);

    var f = '<tr>' +
        '<td>' + idplato + '</td>' +
        '<td><input class="form-control" type="text" name="idplato[]" value="' + idplato + '" readonly></td>' +
        '<td><input class="form-control" type="text" name="cantidad[]" value="' + cantidad + '" readonly></td>' +
        '<td><input class="form-control" type="text" name="p_venta[]" value="' + p_venta + '" readonly></td>' +
        '<td>'+subtotal+'</td>'+
        '</tr>';
    $('#data-table').append(f);

    document.getElementById("idplato").value = "";
    document.getElementById("nombre").value = "";
    document.getElementById("tipo").value = "";
    document.getElementById("stock").value = "";
    document.getElementById("p_venta").value = "";
    document.getElementById("cantidad").value = "1";
    calcular_total();
    pos++;
}

function deleteRow(t) {
    var pos = t.parentNode.parentNode.rowIndex;
    document.getElementById('detalles').deleteRow(pos);
    document.getElementById('data-table').deleteRow(pos);
    calcular_total();
}

function calcular_total() {
    var table = document.getElementById('data-table');
    var total = 0;

    for (i = 1; i < table.rows.length; i++) {
        total += parseFloat(table.rows[i].cells[4].innerText)
    }
    document.getElementById('total').value = 'S/.  ' + number_format(total, 2);
}

function number_format(amount, decimals) {
    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.] /g, '')); // elimino cualquier cosa que no sea numero o punto
    decimals = decimals || 0; // por si la variable no fue fue pasada
    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0)
        return parseFloat(0).toFixed(decimals);
    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);
    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;
    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
    return amount_parts.join('.');
}
