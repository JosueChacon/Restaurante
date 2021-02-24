@extends('layout.plantilla_admin')
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h4><strong>BEBIDAS</strong></h4>
        </div>
        <div class="card-body">
            <h5 class="card-title"><u>.::Eliminar Bebida</u></h5>
            <p class="card-text">
            <h3><label for="">Información</label></h3>
            <label for="">Código: </label> {{ $producto->id }}<br>
            <label for="">Nombre: </label> {{ $producto->nombre }}<br>
            <label for="">Categoría: </label> {{ $producto->Categoria->descripcion }}<br>
            ¿Desea eliminar?
            <form action="{{ route('producto.destroy', $producto->id) }}" method="POST">
                @method('DELETE')
                @csrf
                <div class="mx-auto">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-check-square"></i>
                        Si
                    </button>
                    <a href="{{ route('producto.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-times-circle"></i>
                        No
                    </a>
                </div>
            </form>
            </p>
        </div>
    </div>
@endsection
