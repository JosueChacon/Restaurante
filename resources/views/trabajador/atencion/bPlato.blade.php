<div class="modal fade" id="modalPlatos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Platos programados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaPlatos">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nombre</th>
                                        <th>Tipo plato</th>
                                        <th class="text-right">P. Venta</th>
                                        <th class="text-right">Stock</th>
                                        <th style="width: 80pt">Cantidad</th>
                                        <th style="width: 100pt" class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prog->DProgramacion as $f)
                                        <tr>
                                            <td>
                                                <img src="{{ asset($f->Plato->getRutaFoto()) }}" width="50"
                                                    class="img-fluid" alt="Responsive image">
                                            </td>
                                            <td>{{ $f->Plato->nombre }}</td>
                                            <td>{{ $f->Plato->tipoplato->descripcion }}</td>
                                            <td>S/. {{ $f->Plato->p_venta }}</td>
                                            <td>{{ $f->stock }}</td>
                                            <td>
                                                <input type="number" id="cant{{ $f->Plato->id }}platos" min="1"
                                                    value="1" step="1" class="form-control">
                                            </td>
                                            <td>
                                                <button type="button" id="btnpasar" class="btn form-control btn-sm btn-warning"
                                                    onclick="Seleccionar('{{ $f->Plato->id }}', '{{ $f->Plato->nombre }}','{{ $f->Plato->tipoplato->descripcion }}','{{ $f->Plato->p_venta }}', 'platos', '{{ $f->stock }}')"><i
                                                        class="fas fa-check"></i>
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
