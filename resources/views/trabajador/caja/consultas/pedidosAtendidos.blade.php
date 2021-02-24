@extends('layout.plantilla_trabajador')
@section('contenido')
    <br>
    <div class="card">
        <div class="card-header">
            <font style="font-family: times new roman; font-size: 16pt">
                Pedidos por delivery (confirmados)
            </font>
        </div>
        <div class="card-body">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nº pedido</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Total</th>
                        <th scope="col">¿Detalles?</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $key => $item)
                        <tr>
                            <td>{{ $item->formato($item->idpedido) }}</td>
                            <td>{{ $item->fecha->format('d-m-Y') }}</td>
                            <td>{{ $item->fecha->format('h:i a') }}</td>
                            <td>{{ $item->Cliente->Persona->nombres . ' ' . $item->Cliente->Persona->apellidos }}</td>
                            <td>{{ $item->Cliente->Persona->celular }}</td>
                            <td>{{ $item->estado }}</td>
                            <td>S/. {{ $item->Total($item->DPedido) }}</td>
                            <td>
                                <a href="{{ route('consultas.pedidos.detalles', $item->idpedido) }}"
                                    style="margin-top: -7px" class="btn btn-sm btn-success"><i class="fas fa-list-alt"></i>
                                    Detalles</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
