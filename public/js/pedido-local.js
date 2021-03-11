var cont = 0;
var total = 0;
var detallepedido = [];
var subtotal = [];
var controlplato = [];
var control_ntabla = [];

var nombre_tabla = "";

function btnplatos() {
    nombre_tabla = "platos";
}

function btnproductos() {
    nombre_tabla = "producto";
}

$(document).ready(function () {
    $("#btnagregar").click(function () {
        agregarDetalle();
    });
    $("#btnRegistrar").click(function () {
        registrarPedido();
    });
});

function registrarPedido() {
    idcliente = $("#idcliente").val();
    if (idcliente == null) {
        alert("Seleccione cliente, Porfavor");
        return;
    }
    if (controlplato.length == 0) {
        alert("Ingrese detalles de pedido, Porfavor");
        return;
    }

    //Agregado
    $("#modalConfirmar").modal("show");
    // document.forms["frmPedido"].submit();
}

var c = 1;

function confirmarClave() {
    var clave = $("#clave").val();
    $.ajax({
        type: "GET",
        url: RUTA_API + "VerificarPassword/" + clave,
        dataType: "JSON",
        success: function (data) {
            if (data.status == "ok") {
                $("#idtrabajador").val(data.idtrabajador);
                document.forms["frmPedido"].submit();
            } else if (data.status == "usuario_no_valido") {
                $("#msj").addClass("text-red");
                $("#msj").html("Mensaje " + c + ": La clave debe ser de un mesero");
                c++;
            } else {
                $("#msj").addClass("text-red");
                $("#msj").html("Mensaje " + c + ": Clave no válida, revisar tecla: Bloq Mayús");
                c++;
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function pasar(idplato, nombre, tipo, stock, p_venta) {
    document.getElementById("idplato").value = idplato;
    document.getElementById("nombre").value = nombre;
    document.getElementById("tipo").value = tipo;
    document.getElementById("stock").value = stock;
    document.getElementById("p_venta").value = p_venta;
}

function agregarDetalle() {
    idplato = $("#idplato").val();
    if (idplato == "") {
        alert("Seleccione un plato o producto, Porfavor");
        return;
    }
    cant = $("#cantidad").val();
    if (cant == "") {
        alert("Ingrese cantidad, porfavor.");
        return;
    }
    let cantidad = parseFloat($("#cantidad").val());
    if (cantidad == 0) {
        alert("Cantidad debe ser mayor a 0, Porfavor");
        return;
    }

    let stock = parseFloat($("#stock").val());
    if (cantidad > stock) {
        alert("La cantidad debe ser menor a stock, Porfavor");
        return;
    }

    var i = 0;
    var encontrado = false;
    while (i < cont) {
        if (controlplato[i] == idplato && control_ntabla[i] == nombre_tabla) {
            encontrado = true;
        }
        i = i + 1;
    }
    if (encontrado) {
        alert("El plato o producto ya está en la lista");
        return;
    }

    nombre = $("#nombre").val();
    p_venta = $("#p_venta").val();
    subtotal[cont] = cantidad * p_venta;
    controlplato[cont] = idplato;
    control_ntabla[cont] = nombre_tabla;
    total = total + subtotal[cont];

    var fila =
        '<tr class="selected" id="fila' +
        cont +
        '">' +
        '<td class="text-center"><button type="button" style="margin-top: -7px"  onclick="quitar(' +
        idplato +
        "," +
        cont +
        ');" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>' +
        "<td>" +
        (cont + 1) +
        "</td>" +
        "<td>" +
        nombre +
        "</td>" +
        '<td class="text-right">S/.  ' +
        number_format(p_venta, 2) +
        "</td>" +
        '<td class="text-right">' +
        cantidad +
        "</td>" +
        '<td class="text-right">S/.  ' +
        number_format(subtotal[cont], 2) +
        "</td>" +
        '<td hidden><input type="text" name="idplato[]" value="' +
        idplato +
        '"></td>' +
        '<td hidden><input type="text" name="p_venta[]" value="' +
        p_venta +
        '"></td>' +
        '<td hidden><input type="text" name="cantidad[]" value="' +
        cantidad +
        '"></td>' +
        '<td hidden><input type="text" name="nombre_tabla[]" value="' +
        nombre_tabla +
        '"></td>' +
        "</tr>";
    $("#detalles").append(fila);
    detallepedido.push({
        idplato: idplato,
        p_venta: p_venta,
        cantidad: cantidad,
        nombre_tabla: nombre_tabla,
    });
    cont++;
    $("#total").val("S/.  " + number_format(total, 2));
    limpiar();
}

function limpiar() {
    $("#idplato").val("");
    $("#nombre").val("");
    $("#tipo").val("");
    $("#stock").val("");
    $("#p_venta").val("");
    $("#cantidad").val("1");
}

function quitar(idplato, index) {
    total = total - subtotal[index];
    tam = detallepedido.length;
    var i = 0;
    var pos;
    while (i < tam) {
        if (
            detallepedido[i].idplato == idplato &&
            detallepedido[i].nombre_tabla == control_ntabla[i]
        ) {
            pos = i;
            break;
        }
        i = i + 1;
    }
    detallepedido.splice(pos, 1);
    $("#fila" + index).remove();
    controlplato[index] = "";
    control_ntabla[index] = "";
    $("#total").val("S/.  " + number_format(total, 2));
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
