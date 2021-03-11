@extends($plantilla)
@section('contenido')
    <div class="card">
       
        <div class="card-header">
            <i class="fas fa-list text-success"></i>
            <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
                Pedido de MESA {{ $pedido->Reserva->Mesa['nromesa'] }}
            </font>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <label for="">Nº Pedido</label>
                    <input disabled class="form-control" type="text" value="{{ $pedido->formato($pedido->idpedido) }}"
                        style="text-align: center">
                </div>
                <div class="col-md-3">
                    <label>Fecha y Hora</label>
                    <input disabled class="form-control" type="text" value="{{ $pedido->fecha->format('d-m-Y  h:i a') }}">
                </div>
                <div class="col-md-2">
                    <label>Mesa</label>
                    <input disabled class="form-control" type="text" value="MESA {{ $pedido->Reserva->Mesa['nromesa'] }}"
                        style="text-align: center">
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
            <div class="row pt-2">
                <div class="col-md-12">
                    <label for="">Observaciones:</label>
                    <textarea rows="3" class="form-control" readonly>{{ $pedido->GetObservacion() }}</textarea>
                </div>
            </div>
            <i class="fas fa-task text-primary"></i>
            <font style="font-family: times new roman; font-size: 14pt">Detalles de pedido</font>
            <div class="row pt-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table" id="tabla">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Tipo/Cat</th>
                                    <th scope="col" class="text-right">P. Venta</th>
                                    <th scope="col" class="text-right">Cantidad</th>
                                    <th scope="col" class="text-right">SubTotal</th>
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
            <br>
            <a href="{{ route('consultas.pedidos') }}" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
                Volver
            </a>
        </div>
    </div>
@endsection
