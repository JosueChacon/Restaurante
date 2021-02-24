@extends('layout.plantilla_admin')
@section('contenido')
    <i class="fas fa-list text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Tipos de plato
    </font>
    <div class="card">
        <div class="card-header border shadow">
            <div class="row">
                <div class="col-md-12">
                    <a class="form-control btn btn-primary" href="{{ route('tipoplato.create') }}"><i
                            class="fas fa-plus-square"></i> Registrar Tipo de plato</a>
                </div>
            </div>
        </div>
        <div class="card-body border shadow">
            <div class="row">
                @foreach ($tipos as $f)
                    <div class="col-sm-4">
                        <div class="form-group">
                            <img src="{{ asset($f->getRutaFoto()) }}" width="300" class="img-fluid img-thumbnail"
                                alt="Imagen Tipo de Plato">
                            <strong>Código : </strong>{{ $f->id }}<br>
                            <strong>Descripción : </strong>{{ $f->descripcion }}<br><br>
                            <a href="{{ route('tipoplato.edit', $f->id) }}" class="btn  btn-info">
                                <i class="fas fa-edit"></i> Editar</a>
                            <a href="{{ route('tipoplato.confirmar', $f->id) }}" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Quitar</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
