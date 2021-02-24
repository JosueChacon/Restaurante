@extends('layout.plantilla_trabajador')
@section('contenido')
    <i class="fas fa-people-carry text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Datos de Cliente</font>
    <form action="{{ route('clientes.update', $cliente->idcliente) }}" method="POST">
        @method('put')
        @csrf
        <div class="card">
            <div class="card-body border shadow">
                <div class="row">
                    <div class="col-md-2">
                        <label for="">Dni:</label>
                        <input class="form-control" id="dni" name="dni" type="text" maxlength="8" minlength="8"
                            placeholder="Ingrese dni" pattern="[0-9]{1,8}" title="Formato de dni no válido"
                            value="{{ $cliente->Persona->dni }}">
                    </div>
                    <div class="col-md-4">
                        <label for="">Nombres:</label>
                        <input class="form-control" id="nombres" name="nombres" type="text" maxlength="50"
                            placeholder="Ingrese nombres" value="{{ $cliente->Persona->nombres }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="">Apellidos:</label>
                        <input class="form-control" id="apellidos" name="apellidos" type="text" maxlength="50"
                            placeholder="Ingrese apellidos" value="{{ $cliente->Persona->apellidos }}" required>
                    </div>
                    <div class="col-md-2">
                        <label for="">Teléfono:</label>
                        <input class="form-control" id="celular" name="celular" type="text" maxlength="9"
                            placeholder="Ingrese teléfono" value="{{ $cliente->Persona->celular }}" required>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-md-4">
                        <label for="">Dirección:</label>
                        <input class="form-control" id="direccion" name="direccion" type="text" maxlength="150"
                            placeholder="Ingrese dirección" value="{{ $cliente->Persona->direccion }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="">E-mail:</label>
                        <input class="form-control" id="email" name="email" type="email" maxlength="255"
                            placeholder="Ingrese E-mail" value="{{ $cliente->Persona->email }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-2">
            <div class="col-sm-2">
                <div class="form-group">
                    <a href="{{ route('consultas.clientes') }}" class="btn btn-danger btn-block"><i
                            class="fas fa-arrow-left">
                        </i> Volver</a>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"> </i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
