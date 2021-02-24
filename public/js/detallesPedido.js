function eval(idpedido) {
    $('#tblbody').html("");
    $.get('/BuscarPedido/' + idpedido, function (data) {
        let tam = data.length;
        for (var x = 0; x < tam; x++) {
            var fila = '<tr>' +
                '<td>' + (x + 1) + '</td>' +
                '<td>' + data[x].nombre + '</td>' +
                '<td>' + data[x].descripcion + '</td>' +
                '<td class="text-right">S/. ' + data[x].p_venta + '</td>' +
                '<td class="text-right">' + data[x].cantidad + '</td>' +
                '<td class="text-right">S/. ' + data[x].p_venta * data[x].cantidad + '</td>' +
                '</tr>';
            $('#detalles_tabla').append(fila);
        }
    });
    $('#exampleModal').modal('show');
}
