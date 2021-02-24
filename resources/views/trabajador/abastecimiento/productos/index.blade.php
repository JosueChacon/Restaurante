@extends('layout.plantilla_admin')
@section('contenido')
    <i class="fas fa-list text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Bebidas
    </font>
    <div class="card">
        <div class="card-header border shadow">
            <div class="row">
                <div class="col-md-12">
                    <a class="form-control btn btn-primary" href="{{ route('producto.create') }}"><i
                            class="fas fa-plus-square"></i> Registrar Bebida</a>
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
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th class="text-right">P. Costo</th>
                                    <th class="text-right">P. Venta</th>
                                    <th class="text-right">Stock</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $c => $item)
                                    <tr>
                                        <td>{{ $c + 1 }}</td>
                                        <td>{{ $item['nombre'] }}</td>
                                        <td>{{ $item['Categoria']['descripcion'] }}</td>
                                        <td class="text-right">{{ number_format($item['p_costo'], 2) }}</td>
                                        <td class="text-right">{{ number_format($item['p_venta'], 2) }}</td>
                                        <td class="text-right">{{ $item['stock'] }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('producto.edit', $item['id']) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i> Editar </a>
                                            <a href="{{ route('producto.confirmar', $item['id']) }}"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Quitar </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $productos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
