<div class="modal fade" id="modalProductos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-search text-primary"></i>
                    Eligiendo bebida...
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablaProductos">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nombre</th> 
                                        <th>Categoría</th>
                                        <th>P. Venta</th>
                                        <th>Stock</th>
                                        <th style="width: 80pt">Cantidad</th>
                                        <th style="width: 100pt" class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $f)
                                        <tr>
                                            <td>{{ $f->nombre }}</td>
                                            <td>{{ $f->Categoria->descripcion }}</td>
                                            <td>S/. {{ $f->p_venta }}</td>
                                            <td>{{ $f->stock }}</td>
                                            <td>
                                                <input type="number" id="cant{{ $f->id }}producto" min="1"
                                                    value="1" step="1" class="form-control">
                                            </td>
                                            <td>
                                                <button type="button" id="btnpasar"
                                                    class="btn btn-sm btn-warning form-control"
                                                    onclick="Seleccionar('{{ $f->id }}', '{{ $f->nombre }}','{{ $f->Categoria->descripcion }}','{{ $f->p_venta }}', 'producto', '{{ $f->stock }}')"><i
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
