@extends('layout.plan_cocinero')
@section('contenido')
<br>
    <div class="row">
        <div class="col-md-12">
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
            <div class="card">
                <div class="card-header">
                    <font style="font-family: times new roman; font-size: 16pt">Pedidos confirmados,
                        <strong>{{ date('d-m-Y') }}</strong>
                    </font>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        @if (session('datos'))
                            <div class="alert alert-success alert-dissmissible fade show mt-3" role="alert">
                                {{ session('datos') }}
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
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Mesa</th>
                                <th scope="col">Nº Pedido</th>
                                <th scope="col">Hora</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Total</th>
                                <th scope="col" class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><strong>MESA {{ $item->Reserva->Mesa['nromesa'] }}</strong></td>
                                    <td>{{ $item->formato($item->idpedido) }}</td>
                                    <td>{{ $item->fecha->format('h:i a') }}</td>
                                    <td>{{ $item->Cliente->Persona->nombres . ' ' . $item->Cliente->Persona->apellidos }}
                                    </td>
                                    <td>{{ $item->estado }}</td>
                                    <td>S/. {{ $item->Total($item->DPedido) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('home.mostrarPedido', $item->idpedido) }}"
                                            style="margin-top: -7px" class="btn btn-sm btn-info"><i
                                                class="fas fa-check-circle"></i> Revisar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $pedidos->links() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
