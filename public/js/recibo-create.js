var cont = 0;
var total = 0;
var detallerecibo = [];
var subtotal = [];
var arrayIDpedido = [];
var arrayIDReserva = [];
$(document).ready(function () {
    $("#tipo_id").change(function () {
        mostrarTipo();
    });
    $("#idcliente").change(function () {
        mostrarCliente();
    });
    $("#btnagregar").click(function () {
        agregarDetalle();
    });
    $("#btnRegistrar").click(function () {
        registrarRecibo();
    });
});

function registrarRecibo() {
    idcliente = $("#idcliente").val();
    if (idcliente == "0") {
        alert("Seleccione cliente, Porfavor");
        return;
    }
    if (arrayIDpedido.length == 0) {
        alert("Ingrese detalles de recibo, Porfavor");
        return;
    }
    document.forms["frmRecibo"].submit();
}

function mostrarTipo() {
    tipo_id = $("#tipo_id").val();
    $.get("/BuscarTipo/" + tipo_id, function (data) {
        $("input[name=nrorecibo]").val(data.serie + "-" + data.numeracion);
    });
}

function mostrarCliente() {
    datosCliente = document.getElementById("idcliente").value.split("_");
    $("#celular").val(datosCliente[1]);
    $("#direccion").val(datosCliente[2]);
}

function pasarDatos(idpedido, cliente, celular, direccion, fecha, monto, reserva_id) {
    $("input[name=idpedido]").val(idpedido);
    $("input[name=dcliente]").val(cliente);
    $("input[name=dcelular]").val(celular);
    $("input[name=ddireccion]").val(direccion);
    $("input[name=dfecha]").val(fecha);
    $("input[name=dmonto]").val(monto);
    $("input[name=reserva_id]").val(reserva_id);
}

function agregarDetalle() {
    idpedido = $("#idpedido").val();
    if (idpedido == "") {
        alert("Seleccione un pedido atendido, Porfavor");
        return;
    }

    var i = 0;
    var encontrado = false;
    while (i < cont) {
        if (arrayIDpedido[i] == idpedido) {
            encontrado = true;
        }
        i = i + 1;
    }
    if (encontrado) {
        alert("El pedido ya está en la lista");
        return;
    }

    cliente = $("#dcliente").val();
    celular = $("#dcelular").val();
    fecha = $("#dfecha").val();
    let monto = parseFloat($("#dmonto").val());

    subtotal[cont] = monto;
    arrayIDpedido[cont] = idpedido;
    arrayIDReserva[cont] = $('#reserva_id').val();

    total = total + subtotal[cont];

    var fila =
        '<tr class="selected" id="fila' +
        cont +
        '">' +
        '<td class="text-center"><button type="button" style="margin-top: -7px" onclick="quitar(' +
        idpedido +
        "," +
        cont +
        ');" class="btn-sm btn btn-danger"><i class="fas fa-trash"></i></button></td>' +
        "<td>" +
        (cont + 1) +
        "</td>" +
        "<td>" +
        cliente +
        "</td>" +
        "<td>" +
        celular +
        "</td>" +
        "<td>" +
        fecha +
        "</td>" +
        '<td class="text-right">S/.  ' + number_format(monto, 2) + "</td>" +
        '<td hidden><input type="text" name="idpedido[]" value="' + idpedido + '"></td>' +
        '<td hidden><input type="text" name="monto[]" value="' + monto + '"></td>' +
        '<td hidden><input type="text" name="reserva[]" value="' + $('#reserva_id').val() + '"></td>' +
        "</tr>";
    $("#detalles").append(fila);

    cont++;
    $("#total").val("S/.  " + number_format(total, 2));
    $("#total_env").val(number_format(total, 2));
    limpiar();
}

function limpiar() {
    $("#idpedido").val("");
    $("#dcliente").val("");
    $("#dcelular").val("");
    $("#ddireccion").val("");
    $("#dfecha").val("");
    $("#dmonto").val("");
}

function quitar(idpedido, index) {
    total = total - subtotal[index];
    tam = arrayIDpedido.length;
    var i = 0;
    var pos;
    while (i < tam) {
        if (arrayIDpedido[i] == idpedido) {
            pos = i;
            break;
        }
        i = i + 1;
    }
    arrayIDpedido.splice(pos, 1);
    arrayIDReserva.splice(pos, 1);
    $("#fila" + index).remove();
    $("#total").val("S/.  " + number_format(total, 2));
    $("#total_env").val(number_format(total, 2));
}

function number_format(amount, decimals) {
    amount += ""; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.] /g, "")); // elimino cualquier cosa que no sea numero o punto
    decimals = decimals || 0; // por si la variable no fue fue pasada
    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) return parseFloat(0).toFixed(decimals);
    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = "" + amount.toFixed(decimals);
    var amount_parts = amount.split("."),
        regexp = /(\d+)(\d{3})/;
    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, "$1" + "," + "$2");
    return amount_parts.join(".");
}
