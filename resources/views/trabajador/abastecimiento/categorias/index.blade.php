@extends($plantilla)
@section('contenido')
    <i class="fas fa-list text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Categorías
    </font>
    <div class="card">
        <div class="card-header border shadow">
            <div class="row">
                <div class="col-md-12">
                    <a class="form-control btn btn-primary" href="{{ route('categoria.create') }}"><i
                            class="fas fa-plus-square"></i> Registrar Categoría</a>
                </div>
            </div>
        </div>
        <div class="card-body border shadow">
            @if (session('good'))
                <div class="alert alert-success alert-dissmissible fade show mt-3" role="alert">
                    {{ session('good') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Descripción</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categorias as $c => $item)
                                    <tr>
                                        <td>{{ $c + 1 }}</td>
                                        <td>{{ $item['descripcion'] }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('categoria.edit', $item['idcategoria']) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i> Editar </a>
                                            <a href="{{ route('categoria.confirmar', $item['idcategoria']) }}"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Quitar </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
