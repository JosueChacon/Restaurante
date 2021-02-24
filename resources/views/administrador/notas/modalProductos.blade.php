<div class="modal fade" id="modalProductos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-search text-primary"></i>
                    Eligiendo Bebida...
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
                                        <th class="text-right">P. Costo</th>
                                        <th class="text-right">P. Venta</th>
                                        <th>Stock</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $f)
                                        <tr>
                                            <td>{{ $f->nombre }}</td>
                                            <td>{{ $f->Categoria->descripcion }}</td>
                                            <td class="text-right">{{ number_format($f->p_costo, 2) }}</td>
                                            <td class="text-right">{{ number_format($f->p_venta, 2) }}</td>
                                            <td>{{ $f->stock }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    onclick="pasar('{{ $f->id }}', '{{ $f->nombre }}','{{ $f->p_costo }}',{{ $f->p_venta }},'{{ $f->stock }}',)"
                                                    data-dismiss="modal"><i class="fas fa-check"></i>
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
