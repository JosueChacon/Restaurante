$(document).ready(function () {
    $("#tablaPlatos").DataTable({
        language: {
            url: "/js/datatables/Spanish.json",
        },
        columnDefs: [{
                className: "text-right",
                targets: [3, 4],
            },
            {
                className: "text-center",
                targets: 5,
            },
        ],
    });
    $("#tablaProductos").DataTable({
        language: {
            url: "/js/datatables/Spanish.json",
        },
    });
});

function AgregarProducto() {
    $("#modalProductos").modal("show");
}

function AgregarPlato() {
    $("#modalPlatos").modal("show");
}

function Seleccionar(id, nombre, tip_cat, pventa, nombre_tabla, stock, estado) {
    let cantidad = parseInt($("#cant" + id + nombre_tabla).val())
    let sumatoriaIzquierda = sumatoriaStock(id, nombre_tabla)
    let sumatoriaDerecha = sumatoriaStockEliminado(id, nombre_tabla)
    let nStock = parseInt(stock) + sumatoriaDerecha

    if ((cantidad + sumatoriaIzquierda) > (nStock)) {
        if (sumatoriaIzquierda != 0) {
            msj = 'Ya ha agregado: ' + (sumatoriaIzquierda) + ' platos/productos' +
                '\nCon ' + cantidad + ' platos/productos más, supera el Stock real disponible' +
                '\nStock real disponible: ' + (nStock)
            alert(msj)
        } else {
            alert('Con ' + cantidad + ' platos/productos más, supera el Stock real disponible' +
                '\nStock real disponible: ' + (nStock))
        }
        return
    }

    var fila = html(id, nombre, tip_cat, pventa, cantidad, nombre_tabla, 'pendiente');
    $("#TablaDetalles").append(fila);
    if (nombre_tabla == 'producto') $('#modalProductos').modal('hide')
    else $('#modalPlatos').modal('hide')
    let total = sumarTotal()
    $('#total_pedido').val('S/. ' + total.toFixed(2))
}


function sumatoriaStock(id, nombre_tabla) {
    var buscado = id + '_' + nombre_tabla + '_0'
    let sumatoria = 0
    var table = document.getElementById('TablaDetalles');
    for (i = 0; i < table.rows.length; i++) {
        if (buscado == table.rows[i].cells[0].innerText) {
            sumatoria += parseInt(table.rows[i].cells[6].innerText)
        }
    }
    return sumatoria
}

function sumatoriaStockEliminado(id, nombre_tabla) {
    var buscado = id + '_' + nombre_tabla + '_10'
    let sumatoria = 0
    var table = document.getElementById('TablaDetalles');
    for (i = 0; i < table.rows.length; i++) {
        if (buscado == table.rows[i].cells[0].innerText) {
            sumatoria += parseInt(table.rows[i].cells[6].innerText)
        }
    }
    return sumatoria
}

function html(id, nombre, tip_cat, pventa, cantidad, nombre_tabla, estado) {
    var contenido = '<tr>' +
        '<td hidden>' + id + '_' + nombre_tabla + '_0' + '</td>' +
        '<td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="quitar(' + "'" + id + "'" + ', ' + "'" + nombre_tabla + "'" + ', this, 0)"><i class="fas fa-trash"></i></button></td>' +
        '<td class="text-center">' + '<font style="font-size: 18pt">' + '<i class="fas fa-spinner text-primary"></i>' + "</font>" +
        "</td>" +
        "<td>" + nombre + "</td>" + "<td>" + tip_cat + "</td>" +
        '<td class="text-right">' + parseFloat(pventa).toFixed(2) + "</td>" +
        '<td class="text-right">' + cantidad + "</td>" +
        '<td class="text-right">' + parseFloat(pventa * cantidad).toFixed(2) + "</td>" +
        '<td hidden><input type="text" name="ids[]" value="' + id + '" ></td>' +
        '<td hidden><input type="text" name="pventa[]" value="' + pventa + '"  ></td>' +
        '<td hidden><input type="text" name="cantidades[]" value="' + cantidad + '" ></td>' +
        '<td hidden><input type="text" name="estados[]" value="' + estado + '" ></td>' +
        '<td hidden><input type="text" name="nombres_tabla[]" value="' + nombre_tabla + '"  ></td>' +
        "</tr>";
    return contenido;
}

function quitar(id, nombre_tabla, t, ta) {
    var pos = t.parentNode.parentNode.rowIndex;
    if (ta == 0) {
        document.getElementById('TablaDetalles').deleteRow(pos)
    } else {
        var table = document.getElementById('TablaDetalles');
        table.rows[pos].style.display = 'none'
        table.rows[pos].cells[0].innerText = id + '_' + nombre_tabla + '_10'
        table.rows[pos].cells[8].innerText = ''
        table.rows[pos].cells[9].innerText = ''
        table.rows[pos].cells[10].innerText = ''
        table.rows[pos].cells[11].innerText = ''
        table.rows[pos].cells[12].innerText = ''
    }
    let total = sumarTotal()
    $('#total_pedido').val('S/. ' + total.toFixed(2))
}


function validar() {
    var table = document.getElementById('TablaDetalles');
    var cuenta = 0;
    for (i = 0; i < table.rows.length; i++) {
        if (table.rows[i].style.display != 'none') cuenta++
    }

    if (cuenta == 1)
        alert('Debe añadir detalles, Porfavor');
    else
        document.forms['frmPedido'].submit();
}

function sumarTotal() {
    let sumatoria = 0
    var table = document.getElementById('TablaDetalles');
    for (i = 1; i < table.rows.length; i++) {
        if (table.rows[i].style.display != 'none')
            sumatoria += parseFloat(table.rows[i].cells[7].innerText)
    }
    return sumatoria
}
