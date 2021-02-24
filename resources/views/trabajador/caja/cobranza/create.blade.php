@extends('layout.plan_cajero')
@section('estilos')
    <link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
    <link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection
@section('contenido')
    <i class="fas fa-dollar-sign text-warning"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Registro de recibos
    </font>
    <div class="card">
        <div class="card-body border shadow">
            <form id="frmRecibo" method="POST" action="{{ route('recibos.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-1">
                        <label for="" style="padding-top: 5pt">Fecha: </label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="fechita" id="fechita"
                            value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" style="text-align:center;"
                            readonly="readonly">
                    </div>

                    <div class="col-sm-1"></div>
                    <div class="col-md-4 text-center">
                        <h4 class="d-none d-sm-block">RECIBO</h4>
                    </div>
                    <div class="col-md-1">
                        <label for="" style="padding-top: 5pt">Número: </label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="nrorecibo" id="nrorecibo"
                            value="{{ $parametro->serie . '-' . $parametro->numeracion }}" readonly="readonly">
                    </div>
                </div>
                <div class="row pt-2">
                    {{-- <div class="col-md-1">
                        <label for="" style="padding-top: 5pt">Mesa: </label>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control select2 select2-hidden-accessible selectpicker" style="width: 100%;"
                            data-select2-id="1" tabindex="-1" aria-hidden="true" id="reserva_id" name="reserva_id"
                            data-live-search="true">
                            <option value="0" selected>- Seleccione Mesa - </option>
                            @foreach ($reservas as $item)
                                <option value="{{ $item->reserva_id }}_{{ $item->mesa_id }}_{{ $item->idcliente }}">
                                    {{ 'MESA ' . $item->Mesa['nromesa'] }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="col-sm-1" style="padding-top: 5px">
                        <label>Cliente: </label>
                    </div>
                    <div class="col-sm-3">
                        <select name="idcliente" id="idcliente" class="form-control">
                            @foreach ($clientes as $item)
                                <option value="{{ $item->idcliente }}">
                                    {{ $item->Persona->nombres . ' ' . $item->Persona->apellidos }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-12">
                        <button type="button" class="btn btn-info form-control" data-toggle="modal"
                            data-target="#exampleModal"><i class="fas fa-search"></i>
                            Pedidos Atendidos
                        </button>
                    </div>
                    <div class="col-sm-2 text-right" style="padding-top: 5px">
                        <label for="">Tipo Pago:</label>
                    </div>
                    <div class="col-md-3">
                        <select name="idtipopago" id="idtipopago" class="form-control">
                            @foreach ($tipopago as $item)
                                <option value="{{ $item->idtipopago }}">
                                    {{ $item->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header border shadow">
                        Detalle de recibo
                    </div>
                    <div class="card-body border shadow">
                        <div class="row">
                            <div class="col-md-1" style="padding-top: 5pt">
                                <label for="">Cliente: </label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="idpedido" id="idpedido" hidden>
                                <input type="text" name="reserva_id" id="reserva_id" hidden>
                                <input type="text" class="form-control" name="dcliente" id="dcliente" readonly="readonly">
                            </div>
                            <div class="col-md-1" style="padding-top: 5pt">
                                <label for="">Celular: </label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="dcelular" id="dcelular" readonly="readonly">
                            </div>
                            <div class="col-md-1" style="padding-top: 5pt">
                                <label for="">Dirección: </label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="ddireccion" id="ddireccion"
                                    readonly="readonly">
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-md-1" style="padding-top: 5pt">
                                <label for="">Fecha: </label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="dfecha" id="dfecha" readonly="readonly">
                            </div>
                            <div class="col-md-1" style="padding-top: 5pt">
                                <label for="">Monto: </label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="dmonto" id="dmonto" readonly="readonly">
                            </div>

                            <div class="col-md-2">
                                <button type="button" id="btnagregar" class="form-control btn btn-success"><i
                                        class="fas fa-arrow-down"></i>
                                    Agregar</button>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="detalles" class="table table-bordered" style='background-color: white'>
                                        <thead class="thead-default" style="background-color: blue; color: white;">
                                            <th width="10">¿Quitar?</th>
                                            <th>#</th>
                                            <th>Cliente</th>
                                            <th>Celular</th>
                                            <th>Fecha</th>
                                            <th class="text-right">Monto</th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="">Total : </label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control text-right" name="total" id="total"
                                            readonly="readonly">
                                        <input type="text" name="total_env" id="total_env" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <div id="guardar">
                        <div class="form-group">
                            <a href="{{ route('consultas.recibos') }}" class='btn btn-danger'>
                                <i class='fas fa-arrow-left'></i>
                                Cancelar</a>
                            <button type="button" id="btnRegistrar" class="btn btn-primary"
                                data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando">
                                <i class='fas fa-save'></i> Registrar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModal">
                        Pedidos atendidos, {{ date('d-m-Y') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="table-responsive">
                                <table id="pedidos" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <th>Mesa</th>
                                        <th>Nº Pedido</th>
                                        <th>Hora</th>
                                        <th>Cliente</th>
                                        <th>Estado</th>
                                        <th>Total</th>
                                        <th>Acción</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($pedidos_atendidos as $key => $item)
                                            <tr>
                                                <td>MESA {{ $item->Reserva->Mesa['nromesa'] }}</td>
                                                <td>{{ $item->formato($item->idpedido) }}</td>
                                                <td>{{ $item->fecha->format('h:i a') }}</td>
                                                <td>
                                                    {{ $item->Cliente->nombrecompleto($item->Cliente) }}
                                                </td>
                                                <td>{{ $item->estado }}</td>
                                                <td>S/. {{ $item->total($item->DPedido) }}</td>
                                                <td>
                                                    <button type="button"
                                                        onclick="pasarDatos('{{ $item->idpedido }}',
                                                                                                '{{ $item->Cliente->nombrecompleto($item->Cliente) }}',
                                                                                               '{{ $item->Cliente->Persona->celular }}','{{ $item->Cliente->Persona->direccion }}','{{ $item->fecha->format('d/m/Y h:i a') }}',
                                                                                                     '{{ $item->total($item->DPedido) }}',
                                                                                                     '{{ $item->Reserva->reserva_id }}')"
                                                        class="btn btn-info" data-dismiss="modal"><i
                                                            class="fas fa-check"></i>
                                                        Seleccionar</button>
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
        </div>
    </div>
@endsection
@section('script')
    <script src="/select2/bootstrap-select.min.js"></script>
    <script src="/js/recibo-create.js"></script>
@endsection
