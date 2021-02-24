@extends('layout.plantilla_trabajador')
@section('contenido')
<br>
<div class="card">
    <div class="card-header">
        <h4><strong>MESAS</strong></h4>
    </div>
    <div class="card-body">
        <h5 class="card-title"><u>.::Eliminar Mesa</u></h5>
        <p class="card-text">
            <p class="card-text">
                <strong>Código: </strong> {{$mesa->mesa_id}} <br>
                <strong>Nro Mesa: </strong> M-{{$mesa->nromesa}}
            </p>
            <h5 class="card-title">¿Desea eliminar?</h5><br>
            <form action="{{route('mesas.destroy', $mesa->mesa_id)}}" method="POST">
                @method('DELETE')
                @csrf
                <div class="mx-auto">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-check-square"></i>
                        Si
                    </button>
                    <a href="{{route('mesas.index')}}" class="btn btn-sm btn-primary">
                        <i class="fas fa-times-circle"></i>
                        NO
                    </a>
                </div>
            </form>
        </p>
    </div>
</div>
@endsection