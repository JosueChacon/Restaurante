@extends('layout.plantilla_admin')
@section('contenido')
    <form action="{{ route('MiGente.store') }}" method="POST">
        @csrf
        <i class="fas fa-people-carry text-primary"></i>
        <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
            Datos de trabajador</font>
        <div class="card">
            <div class="card-body border shadow">
                <div class="row">
                    <div class="col-md-2">
                        <label for="">Dni:</label>
                        <input class="form-control" id="dni" name="dni" type="text" maxlength="8" minlength="8"
                            placeholder="Ingrese dni" pattern="[0-9]{1,8}" title="Formato de dni no válido"
                            value="{{ old('dni') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="">Nombres:</label>
                        <input class="form-control" id="nombres" name="nombres" type="text" maxlength="50"
                            placeholder="Ingrese nombres" value="{{ old('nombres') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="">Apellidos:</label>
                        <input class="form-control" id="apellidos" name="apellidos" type="text" maxlength="50"
                            placeholder="Ingrese apellidos" value="{{ old('apellidos') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="">Teléfono:</label>
                        <input class="form-control" id="celular" name="celular" type="text" maxlength="9"
                            placeholder="Ingrese teléfono" value="{{ old('celular') }}" required>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-md-4">
                        <label for="">Dirección:</label>
                        <input class="form-control" id="direccion" name="direccion" type="text" maxlength="150"
                            placeholder="Ingrese dirección" value="{{ old('direccion') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="">E-mail:</label>
                        <input class="form-control" id="email" name="email" type="email" maxlength="255"
                            placeholder="Ingrese E-mail" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="">Cargo:</label>
                        <select name="idcargo" id="idcargo" class="form-control">
                            @foreach ($cargos as $item)
                                <option value="{{ $item->idcargo }}">
                                    {{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                        <span>
                            <font style="font-size: 10pt">
                                <font style="color: red">*</font>Este campo no será editable
                            </font>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <i class="fas fa-user text-primary"></i>
        <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
            Datos de inicio de sesión</font>
        <div class="card">
            <div class="card-body order shadow">
                <div class="row">
                    <div class="col-md-4">
                        <label>Usuario:</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text"
                            maxlength="50" placeholder="Ingrese usuario" value="{{ old('name') }}" required>
                        <span>
                            <font style="font-size: 10pt">
                                <font style="color: red">*</font>Este campo no será editable
                            </font>
                        </span>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label>Clave: </label>
                        <input class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                            type="password" maxlength="50" placeholder="Ingrese clave" value="{{ old('password') }}"
                            required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label>Repita Clave: </label>
                        <input class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation" type="password" maxlength="50"
                            placeholder="Repita clave" value="{{ old('password_confirmation') }}" required>
                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-2">
            <div class="col-sm-2">
                <a href="{{ route('MiGente.index') }}" class="form-control btn btn-danger"><i
                        class="fas fa-arrow-left"></i>
                    Cancelar</a>
            </div>
            <div class="col-sm-2">
                <button type="submit" id="grabar" class="form-control btn btn-primary"><i class="fas fa-save"></i>
                    Guardar</button>
            </div>
        </div>
    </form>
@endsection
@section('script')

@endsection
