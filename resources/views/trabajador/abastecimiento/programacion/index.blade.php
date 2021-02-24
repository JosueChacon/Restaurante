@extends('layout.plantilla_admin')
@section('contenido')
    <i class="fas fa-list text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Programación de platos
    </font>
    <div class="card">
        <div class="card-header border shadow">
            <div class="row">
                <div class="col-md-12">
                    <a class="form-control btn btn-primary" href="{{ route('programacion.create') }}"><i
                            class="fas fa-plus-square"></i> Registrar Programación</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if (session('good'))
                <div class="alert alert-success alert-dissmissible fade show mt-3" role="alert">
                    {{ session('good') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dissmissible fade show mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Responsable</th>
                                    <th scope="col" class="text-right">Nº Tipo plato</th>                                    
                                    <th scope="col" class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prog as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->fecha->format('d-m-Y') }}</td>
                                        <td>{{ $item->fecha->format('h:i a') }}</td>
                                        <td>{{ $item->Trabajador->Persona->nombres . ' ' . $item->Trabajador->Persona->apellidos }}
                                        </td>
                                        <td class="text-right">{{ $item->DProgramacion->count() }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('programacion.edit', $item->idprogramacion) }}"
                                                class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                            <a href="{{ route('programacion.confirmar', $item->idprogramacion) }}"
                                                class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Quitar</a>
                                            <a href="{{ route('programacion.detalles', $item->idprogramacion) }}"
                                                class="btn btn-success btn-sm"><i class="fas fa-list"></i> Detalles</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $prog->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection
