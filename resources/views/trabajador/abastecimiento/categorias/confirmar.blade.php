@extends($plantilla)
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h4><strong>CATEGORÍAS</strong></h4>
        </div>
        <div class="card-body">
            <h5 class="card-title"><u>.::Eliminar Categoría</u></h5>
            <p class="card-text">
            <h3><label for="">Información</label></h3>
            <label for="">Código: </label> {{ $categoria->idcategoria }}<br>
            <label for="">descripcion: </label> {{ $categoria->descripcion }}<br>
            ¿Desea eliminar?
            <form action="{{ route('categoria.destroy', $categoria->idcategoria) }}" method="POST">
                @method('DELETE')
                @csrf
                <div class="mx-auto">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-check-square"></i>
                        Si
                    </button>
                    <a href="{{ route('categoria.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-times-circle"></i>
                        No
                    </a>
                </div>
            </form>
            </p>
        </div>
    </div>
@endsection
