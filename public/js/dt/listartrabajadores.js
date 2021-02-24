$(document).ready(function () {
    $('#tbl_trabajadores').dataTable({
        processing: true,
        serverSide: true,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },
        ajax: {
            url: "ListaTrabajadores",
        },
        columns: [{
                data: 'idtrabajador',
                name: 'idtrabajador'
            },
            {
                data: 'nombrecompleto',
                name: 'nombrecompleto'
            },
            {
                data: 'direccion',
                name: 'direccion'
            },
            {
                data: 'celular',
                name: 'celular'
            },
            {
                data: 'usuario',
                name: 'usuario'
            },
            {
                data: 'cargo',
                name: 'cargo'
            },
            // {
            //     data: 'action',
            //     name: 'action',
            //     orderable: false
            // }
        ],
        // columnDefs: [{
        //     "className": "text-center",
        //     "targets": 4
        // }]
    });
});
