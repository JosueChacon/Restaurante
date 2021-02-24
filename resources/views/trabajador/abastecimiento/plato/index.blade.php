@extends('layout.plantilla_admin')
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h4><strong>PLATOS</strong></h4>
        </div>
        <div class="card-body">
            <h5 class="card-title"><u>.::Listado de Platos</u></h5>
            <p class="card-text">
                @if (session('datos'))
                    <div class="alert alert-warning alert-dissmissible fade show mt-3" role="alert">
                        {{ session('datos') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            <form>
                <div class="row">
                    <div class="col-sm-2 col-12">
                        <a href="{{ route('plato.create') }}" class="form-control btn btn-primary">
                            <i class="fas fa-plus-square"></i> Agregar Plato </a><br>
                    </div>
                    <div class="col-sm-4 col-0"></div>
                    <div class="col-sm-4 col-8">
                        <input name="buscarpor" class="form-control" type="search" placeholder="Por nombre de plato"
                            value="{{ $buscarpor }}">
                    </div>
                    <div class="col-sm-2 col-4">
                        <button class="btn btn-success form-control" type="submit"><i class="fas fa-search"></i> Buscar</button>
                    </div>
                </div>
            </form>
            <strong>
                <h4>"Resultados: <u>{{ $platos->count() }}</u>"</h4>
            </strong>

            <div class="form-group">
                <div class="row">
                    @foreach ($platos as $f)
                        <div class="col-sm-4">
                            <div class="form-group">
                                <img src="{{ asset($f->getRutaFoto()) }}" width="400" class="img-fluid img-thumbnail"
                                    alt="Responsive image">
                                <strong>Nombre : </strong>{{ $f->nombre }}<br>
                                <strong>Tipo Plato : </strong> {{ $f->tipoplato->descripcion }} <br>
                                <strong>P. Costo : </strong>S/. {{ $f->p_costo }}<br>
                                <strong>P. Venta : </strong>S/. {{ $f->p_venta }}<br>
                                <a href="{{ route('plato.edit', $f->id) }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Editar</a>
                                <a href="{{ route('plato.confirmar', $f->id) }}" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Quitar</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            </p>
        </div>
    </div>
@endsection
