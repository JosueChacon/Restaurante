$(document).ready(function () {
    $("#tablaProductos").DataTable({
        language: {
            url: "/js/datatables/Spanish.json",
        },
        columnDefs: [
            {
                className: "text-center",
                targets: 5,
            },
        ],
    });
});

function pasar(idproducto, nombre, pcosto, pventa, stock) {
    $("#producto").val(nombre);
    $("#idproducto").val(idproducto);
    $("#p_costo").val(pcosto);
    $("#p_venta").val(pventa);
    $("#stock").val(stock);
    $("#p_costo_nuevo").val(pcosto);
}

var IDProducto = [];
var importeTotal = [];
function agregar() {
    var idproducto = $("#idproducto").val();
    if (idproducto == "") {
        alert("Seleccione un producto, porfavor.");
        return;
    }

    var index = IDProducto.indexOf(idproducto);
    if (index != -1) {
        alert("Producto ya ha sido agregado");
        return;
    }

    var fila = construirHTML();
    $("#detallenota").append(fila);
    IDProducto.push(idproducto);
    sumar();
}

function construirHTML() {
    var idproducto = $("#idproducto").val();
    var cantidad = $("#cantidad").val();
    var producto = $("#producto").val();
    var p_costo = $("#p_costo_nuevo").val();
    var importe = cantidad * p_costo;
    importeTotal.push(importe);
    var contenido =
        '<tr id="detalle' +
        idproducto +
        '">' +
        '<td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="quitar(' +
        idproducto +
        ')"><i class="fas fa-trash"></i></button></td>' +
        "<td>" +
        cantidad +
        "</td>" +
        "<td>" +
        producto +
        "</td>" +
        '<td class="text-right">' +
        p_costo +
        "</td>" +
        '<td class="text-right">' +
        importe +
        "</td>" +
        '<td hidden><input type="text" name="idsproducto[]" value="' +
        idproducto +
        '"></td>' +
        '<td hidden><input type="text" name="cantidades[]" value="' +
        cantidad +
        '" hidden></td>' +
        '<td hidden><input type="text" name="precios[]" value="' +
        p_costo +
        '" hidden></td>' +
        "</tr>";
    return contenido;
}

function quitar(idproducto) {
    $("#detalle" + idproducto).remove();
    var index = IDProducto.indexOf(idproducto);
    IDProducto.splice(index, 1);
    importeTotal.splice(index, 1)
    sumar()
}

function grabar() {
    if (IDProducto.length == 0) {
        alert("Debe añadir detalles, Porfavor");
        return;
    } else document.forms["frmNota"].submit();
}

function sumar() {
    var total = 0;
    for (var i = 0; i < importeTotal.length; i++) {
        total += importeTotal[i];
    }
    $("#total").val(total);
}
