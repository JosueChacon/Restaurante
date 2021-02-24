<div class="modal fade" id="modalClientes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-search text-primary"></i>
                    Eligiendo cliente...
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaClientes">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 11pt">
                                    @foreach ($clientes as $c => $item)
                                        <tr>
                                            <td>{{ $c + 1 }}</td>
                                            <td>{{ $item->Persona->nombres_apellidos() }}</td>
                                            <td>{{ $item->Persona->direccion }}</td>
                                            <td>{{ $item->Persona->celular }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn-sm btn btn-success"
                                                    onclick="seleccionar('{{ $item->Persona->nombres_apellidos() }}',
                                                    '{{ $item->Persona->direccion }}',
                                                    '{{ $item->Persona->celular }}',
                                                    '{{ $item->idcliente }}')">
                                                    <i class="fas fa-bolt"></i>
                                                    Seleccionar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
