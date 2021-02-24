<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Platos Disponibles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        @foreach ($platos as $f)
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <img src="{{ asset($f->getRutaFoto()) }}" width="300" class="img-fluid"
                                        alt="Responsive image"><br>
                                    <strong>Nombre : </strong>{{ $f->nombre }}<br>
                                    <strong>Tipo Plato : </strong> {{ $f->tipoplato->descripcion }} <br>
                                    <strong>P. Compra : </strong>S/. {{ $f->p_costo }}<br>
                                    <strong>P. Venta : </strong>S/. {{ $f->p_venta }}<br>
                                    <button type="button" class="btn btn-warning"
                                        onclick="return pasar('{{ $f->id }}', '{{ $f->nombre }}','{{ $f->tipoplato->descripcion }}','{{ $f->p_venta }}','{{ $f->p_costo }}')"
                                        data-dismiss="modal"><i class="fas fa-check"></i>
                                        Seleccionar</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
