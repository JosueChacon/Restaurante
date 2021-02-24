@extends('layout.plantilla_admin')
@section('contenido')
<div class="card">
    <div class="card-header">
        <h4><strong>PROGRAMACIONES</strong></h4>
    </div>
    <div class="card-body">
        <h5 class="card-title"><u>.::Eliminar Programación</u></h5>
        <p class="card-text">
            <p class="card-text">
                <strong>Código: </strong> {{$prog->idprogramacion}} <br>
                <strong>Fecha: </strong> {{$prog->fecha}}
            </p>
            <h5 class="card-title">¿Desea eliminar?</h5><br>
            <form action="{{route('programacion.destroy', $prog->idprogramacion)}}" method="POST">
                @method('DELETE')
                @csrf
                <div class="mx-auto">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-check-square"></i>
                        Si
                    </button>
                    <a href="{{route('programacion.index')}}" class="btn btn-sm btn-primary">
                        <i class="fas fa-times-circle"></i>
                        NO
                    </a>
                </div>
            </form>
        </p>
    </div>
</div>
@endsection