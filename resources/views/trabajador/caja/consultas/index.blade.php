@extends('layout.plan_cajero')
@section('contenido')
    <div class="card">
        <div class="card-header">
            <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
                Consultas de recibos</font>
        </div>
        <div class="card-body">
            {{-- <a href="{{ route('recibos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-square"></i> Emitir Recibo</a><br> --}}
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
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nº Recibo</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Cliente</th>
                                    <th class="text-right">Efectivo</th>
                                    <th class="text-right">Tarjeta</th>
                                    <th class="text-right">Total</th>
                                    <th scope="col" class="text-center">¿Detalles?</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recibos_x_t as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->nrorecibo }}</td>
                                        <td>{{ $item->fecha->format('d-m-Y') }}</td>
                                        <td>{{ $item->fecha->format('h:i a') }}</td>
                                        <td>{{ $item->Cliente->Persona->nombres_apellidos() }}</td>
                                        <td class="text-right">{{ number_format($item->efectivo, 2) }}</td>
                                        <td class="text-right">{{ number_format($item->tarjeta, 2) }}</td>
                                        <td class="text-right">{{ number_format($item->total, 2) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('recibos.detallesRecibo', $item->idrecibo) }}"
                                                class="btn btn-sm btn-success"><i class="fas fa-list"></i> Detalles</a>
                                            <a href="{{ route('imprimirRecibo', $item->idrecibo) }}" target="_blank"
                                                class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $recibos_x_t->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
