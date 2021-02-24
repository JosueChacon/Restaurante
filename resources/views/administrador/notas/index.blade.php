@extends('layout.plantilla_admin')
@section('contenido')
    <i class="fas fa-clipboard text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Notas de ingreso
    </font>
    <div class="card">
        <div class="card-header border shadow">
            <div class="row">
                <div class="col-md-12">
                    <a class="form-control btn btn-primary" href="{{ route('NotaIngreso.create') }}"><i
                            class="fas fa-plus-square"></i> Registrar Nota de Ingreso</a>
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
                                    <th class="text-right">Total S/</th>
                                    <th scope="col" class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notas as $c => $item)
                                    <tr>
                                        <td>{{ $c + 1 }}</td>
                                        <td>{{ $item->fecha->format('d/m/Y') }}</td>
                                        <td>{{ $item->fecha->format('h:i a') }}</td>
                                        <td>{{ $item->Trabajador->Persona->nombres_apellidos() }}</td>
                                        <td class="text-right">{{ number_format($item->total,2) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('NotaIngreso.show', $item['idnota']) }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-list"></i> Detalles</a>
                                            {{-- <a href="{{ route('NotaIngreso.destroy', $item['idnota']) }}"
                                                class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Quitar</a> --}}
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
