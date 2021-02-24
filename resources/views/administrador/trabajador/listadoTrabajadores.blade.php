@extends('layout.plantilla_admin')
@section('contenido')
    <i class="fas fa-users text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Perfil de trabajador</font>
    <div class="card">
        <div class="card-body border shadow">
            <div class="form-group">
                <div class="row">
                    @foreach ($trabajadores as $item)
                        <div class="col-sm-4">
                            <div class="form-group">
                                <img src="{{ asset($item->Persona->User->getRutaFoto()) }}" width="250px" height="290px"
                                    alt="Responsive image" class="img-thumbnail"><br>
                                <strong>Cargo: </strong> {{ $item->Cargo->descripcion }} <br>
                                <strong>Trabajador : </strong>{{ $item->Persona->nombrecompleto($item->Persona) }}<br>
                                <strong>Teléfono : </strong> {{ $item->Persona->celular }} <br>
                                <strong>Dirección : </strong> {{ $item->Persona->direccion }} <br>
                                @if ($item->estado == 1)
                                    <span>Activo <i class="fas fa-check text-success"></i></span>
                                @else
                                    <span>Eliminado <i class="fas fa-times text-danger"></i></span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
