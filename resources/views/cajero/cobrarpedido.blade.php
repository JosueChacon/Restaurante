@extends($plantilla)
@section('estilos')
    <link rel="stylesheet" href="/js/datatables/jquery.dataTables.min.css">
@endsection
@section('contenido')
    <i class="fas fa-dollar-sign text-warning"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Cobrando pedido, {{ date('d-m-Y') }}
    </font>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('cobrarpedido', $pedido->idpedido) }}" method="POST" id="frmCobrar">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <label>Mesa</label>
                        <input disabled class="form-control" type="text"
                            value="MESA {{ $pedido->Reserva->Mesa['nromesa'] }}" style="text-align: center">
                    </div>
                    <div class="col-md-2">
                        <label for="">Nº Pedido</label>
                        <input disabled class="form-control" type="text"
                            value="{{ $pedido->formato($pedido->idpedido) }}">
                    </div>
                    <div class="col-md-2">
                        <label>Hora</label>
                        <input disabled class="form-control" type="text" value="{{ $pedido->fecha->format('h:i a') }}">
                    </div>
                    <div class="col-md-3">
                        <label>Mesero</label>
                        <input disabled class="form-control" type="text"
                            value="{{ $pedido->Trabajador->Persona->nombres_apellidos() }}">
                    </div>
                    <div class="col-md-3">
                        <label>Cliente</label>
                        <input disabled class="form-control" type="text"
                            value="{{ $pedido->Cliente->Persona->nombres_apellidos() }}">
                    </div>
                </div>
                <br>
                <i class="fas fa-task text-primary"></i>
                <font style="font-family: times new roman; font-size: 14pt">Detalles de pedido</font>
                <div class="row pt-2">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tabla">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th class="text-center">Estado</th>
                                        <th scope="col" class="text-center">Cantidad</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col" class="text-right">P. Venta</th>
                                        <th scope="col" class="text-right">SubTotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pedido->DPedido as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="text-center">
                                                <font style="font-size: 18pt">
                                                    <i @if ($item['estado'] == 'pendiente') class="fas fa-spinner text-primary"
                                                        @else class="fas fa-check text-success" @endif>
                                                    </i>
                                                </font>
                                            </td>
                                            <td class="text-center">{{ $item->cantidad }}</td>
                                            <td>{{ $item->Plato_Prod->nombre }}</td>
                                            <td>{{ $item->TipoCat() }}</td>
                                            <td class="text-right">S/. {{ $item->p_venta }}</td>

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
                    <div class="col-sm-8"></div>
                    <div class="col-sm-2" style="padding-top: 7px">
                        <label>Total a cobrar S/.</label>
                    </div>
                    <div class="col-sm-2">
                        <input disabled class="form-control text-right" type="text" id="total_pagar"
                            value="{{ number_format($pedido->Total($pedido->DPedido), 2) }}">
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-md-6">
                        <label for="">Monto con efectivo:</label>
                        <input type="number" name="efectivo" id="efectivo" class="form-control" value="0">
                    </div>
                    <div class="col-md-6">
                        <label for="">Monto con tarjeta:</label>
                        <input type="number" name="tarjeta" id="tarjeta" class="form-control" value="0">
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <a href="{{ route('home') }}" class="btn btn-danger form-control"><i
                                class="fas fa-arrow-left"></i>
                            Volver</a>
                    </div>
                    <div class="col-md-3">
                        <button type="button" onclick="validar()" class="btn btn-warning form-control"><i
                                class="fas fa-dollar-sign"></i> Cobrar
                        </button>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function validar() {
            var efectivo = parseFloat($('#efectivo').val());
            var tarjeta = parseFloat($('#tarjeta').val());
            var total_pagar = parseFloat($('#total_pagar').val());
            if (efectivo<0){
                alert('Monto de pago en efectivo no puede ser un negativo')
                return
            }
            if (tarjeta<0)
            {
                alert('Monto de pago con tarjeta no puede ser un negativo')
            }
            if (efectivo + tarjeta != total_pagar) {
                alert('La suma de montos no concuerda con el total a cobrar')
                return
            }

            document.forms['frmCobrar'].submit();
        }

    </script>
@endsection
