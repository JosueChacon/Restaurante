@extends('layout.plantilla_admin')
@section('contenido')
<div class="card">
    <div class="card-header">
        <h4><strong>PLATOS</strong></h4>
    </div>
    <div class="card-body">
        <h5 class="card-title"><u>.::Eliminar Plato</u></h5>
        <p class="card-text">
            <p class="card-text">
                <strong>Código: </strong> {{$plato->id}} <br>
                <strong>Nombre: </strong> {{$plato->nombre}}
            </p>
            <h5 class="card-title">¿Desea eliminar?</h5><br>
            <form action="{{route('plato.destroy', $plato->id)}}" method="POST">
                @method('DELETE')
                @csrf
                <div class="mx-auto">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-check-square"></i>
                        Si
                    </button>
                    <a href="{{route('plato.index')}}" class="btn btn-sm btn-primary">
                        <i class="fas fa-times-circle"></i>
                        No
                    </a>
                </div>
            </form>
        </p>
    </div>
</div>
@endsection