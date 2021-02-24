@extends('layout.plan_cocinero')
@section('contenido')
    <br>
    <div class="card">
        <div class="card-header">
            <font style="font-family: times new roman; font-size: 18pt">Atendiendo Pedido
            </font>
        </div>
        <form action="{{ route('home.mostrarPedido', $pedido->idpedido) }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <label for="">Nº Pedido</label>
                        <input disabled class="form-control" type="text" value="{{ $pedido->formato($pedido->idpedido) }}"
                            style="text-align: center">
                    </div>
                    <div class="col-md-3">
                        <label>Fecha y Hora</label>
                        <input disabled class="form-control" type="text"
                            value="{{ $pedido->fecha->format('d-m-Y  h:i a') }}">
                    </div>
                    <div class="col-md-2">
                        <label>Mesa</label>
                        <input disabled class="form-control" type="text"
                            value="MESA {{ $pedido->Reserva->Mesa['nromesa'] }}" style="text-align: center">
                    </div>
                    <div class="col-md-3">
                        <label>Cliente</label>
                        <input disabled class="form-control" type="text"
                            value="{{ $pedido->Cliente->Persona->nombres . ' ' . $pedido->Cliente->Persona->apellidos }}">
                    </div>
                    <div class="col-sm-2">
                        <label>Estado</label>
                        <input disabled class="form-control" type="text" value="{{ $pedido->estado }}">
                    </div>
                </div>
                <i class="fas fa-task text-primary"></i>
                <font style="font-family: times new roman; font-size: 14pt">Detalles de pedido</font>
                <div class="row pt-2">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <span><i class="fas fa-spinner text-primary"></i> Pendiente</span>&nbsp;&nbsp;&nbsp;
                            <span><i class="fas fa-check text-success"></i> Atendido</span>
                            <table class="table table-bordered" id="tabla">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Tipo/Cat</th>
                                        <th scope="col" class="text-right">P. Venta</th>
                                        <th scope="col" class="text-right">Cantidad</th>
                                        <th scope="col" class="text-right">SubTotal</th>
                                        <th class="text-center">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pedido->DPedido as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->Plato_Prod->nombre }}</td>
                                            <td>{{ $item->TipoCat() }}</td>
                                            <td class="text-right">S/. {{ $item->p_venta }}</td>
                                            <td class="text-right">{{ $item->cantidad }}</td>
                                            <td class="text-right">S/. {{ $item->cantidad * $item->p_venta }}</td>
                                            <td class="text-center">
                                                @if ($item['estado'] == 'pendiente')
                                                <font style="font-size: 18pt">
                                                    <i class="fas fa-spinner text-primary"></i>
                                                </font>                                                    
                                                @else
                                                <font style="font-size: 18pt">
                                                    <i class="fas fa-check text-success"></i>
                                                </font>                                                
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-sm-9"></div>
                    <div class="col-sm-1" style="padding-top: 7px">
                        <label>Total</label>
                    </div>
                    <div class="col-sm-2">
                        <input disabled class="form-control text-right" type="text"
                            value="S/. {{ $pedido->Total($pedido->DPedido) }}">
                    </div>
                </div>

                <a href="{{ route('home') }}" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
                    Volver</a>
                {{-- <button type="submit" class="btn btn-info"><i class="fas fa-check-circle"></i> Atender pedido
                </button> --}}
                </p>
            </div>
        </form>
    </div>
@endsection
