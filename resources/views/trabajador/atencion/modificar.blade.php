@extends('layout.plantilla_trabajador')
@section('estilos')
    <link rel="stylesheet" href="/js/datatables/jquery.dataTables.min.css">
@endsection
@section('contenido')
    <i class="fas fa-edit text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Editando pedido, {{ date('d-m-Y') }}
    </font>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('ModificarPedido', $pedido->idpedido) }}" method="POST" id="frmPedido">
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
                <div class="row pt-2">
                    <div class="col-md-12">
                        <label for="">Observaciones:</label>
                        <textarea rows="3" class="form-control" readonly>{{ $pedido->GetObservacion() }}</textarea>
                    </div>
                </div> 
                <br>
                <i class="fas fa-task text-primary"></i>
                <font style="font-family: times new roman; font-size: 14pt">Detalles de pedido</font>
                <span class="float-right">
                    <a href="javascript:;" onclick="AgregarProducto()">
                        <i class="fas fa-plus text-primary"></i> Bebida</a>
                </span>
                <span class="float-right">&nbsp;&nbsp;&nbsp;</span>
                <span class="float-right"><a href="javascript:;" onclick="AgregarPlato()">
                        <i class="fas fa-plus text-primary"></i> Plato</a>
                </span>
                <div class="row pt-2">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="TablaDetalles">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center">Acción</th>
                                        <th class="text-center">Estado</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col" class="text-right">P. Venta</th>
                                        <th scope="col" class="text-right" style="width: 70pt">Cantidad</th>
                                        <th scope="col" class="text-right">SubTotal</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pedido->DPedido as $key => $item)
                                        <tr>
                                            <td hidden>{{ $item->idplato . '_' . $item->nombre_tabla . '_1' }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="quitar('{{ $item->idplato }}', '{{ $item->nombre_tabla }}', this, 1)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <font style="font-size: 18pt">
                                                    <i @if ($item['estado'] == 'pendiente') class="fas fa-spinner text-primary"
                                                        @else class="fas fa-check text-success" @endif>
                                                    </i>
                                                </font>
                                            </td>
                                            <td>{{ $item->Plato_Prod->nombre }}</td>
                                            <td>{{ $item->TipoCat() }}</td>
                                            <td class="text-right">{{ number_format($item->p_venta, 2) }}</td>
                                            <td class="text-right">{{ $item->cantidad }} </td>
                                            <td class="text-right">
                                                {{ number_format($item->cantidad * $item->p_venta, 2) }}
                                            </td>
                                            <td hidden><input type="text" name="ids[]" id=""
                                                    value="{{ $item->idplato }}"></td>
                                            <td hidden><input type="text" name="nombres_tabla[]" id=""
                                                    value="{{ $item->nombre_tabla }}"></td>
                                            <td hidden><input type="text" name="pventa[]" id=""
                                                    value="{{ $item->p_venta }}"></td>
                                            <td hidden><input type="text" name="cantidades[]" id=""
                                                    value="{{ $item->cantidad }}"></td>
                                            <td hidden><input type="text" name="estados[]" id=""
                                                    value="{{ $item->estado }}"></td>

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
                        <input disabled class="form-control text-right" type="text" id="total_pedido"
                            value="S/. {{ number_format($pedido->Total($pedido->DPedido), 2) }}">
                    </div>
                </div>

                @if (session('fuente') == 'HOME')
                    <a href="{{ route('home') }}" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
                        Volver</a>
                @else
                    <a href="{{ route('ModificarPedidos') }}" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
                        Volver</a>
                @endif

                <button type="button" onclick="validar()" class="btn btn-primary"><i class="fas fa-save"></i> Guardar
                    Cambios
                </button>
            </form>
        </div>
    </div>
    @include('trabajador.atencion.bProducto')
    @include('trabajador.atencion.bPlato')
@endsection
@section('script')
    <script src="/js/datatables/jquery.dataTables.min.js"></script>
    <script src="/js/modificar-pedido.js"></script>
@endsection
