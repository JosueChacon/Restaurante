@extends('layout.plantilla_admin')
@section('contenido')
<br>
<div class="card">
    <div class="card-header">
        <h4><strong>TIPO DE PLATO</strong></h4>
    </div>
    <div class="card-body">
        <h5 class="card-title"><u>.::Eliminar Tipo de Plato</u></h5>
        <p class="card-text">
            <h3><label for="">Información</label></h3>
            <label for="">Código: </label> {{$tipoplato->id}}<br>
            <label for="">descripcion: </label> {{$tipoplato->descripcion}}<br>
            ¿Desea eliminar?
            <form action="{{route('tipoplato.destroy', $tipoplato->id)}}" method="POST">
                @method('DELETE')
                @csrf
                <div class="mx-auto">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-check-square"></i>
                        Si
                    </button>
                    <a href="{{route('tipoplato.index')}}" class="btn btn-sm btn-primary">
                        <i class="fas fa-times-circle"></i>
                        No
                    </a>
                </div>
            </form>
        </p>
    </div>
</div>
@endsection