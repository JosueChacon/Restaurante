@extends('layout.plantilla_admin')
@section('estilos')
    <link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
    <link rel="stylesheet" href="/js/datatables/jquery.dataTables.min.css">
@endsection
@section('contenido')
    <i class="fas fa-tasks text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Ventas Generales</font>
    <div class="card">
        <div class="card-body border shadow">
            <form action="">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <label for="">Desde:</label>
                        <div class="input-group date form_date" data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input readonly type="text" class="form-control" name="desde" id="desde"
                                data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask=""
                                im-insert="false" value="{{ $desde }}" placeholder="dd/mm/yyyy">
                            <div class="input-group-btn">
                                <button class="btn btn-primary date-set" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="">Hasta:</label>
                        <div class="input-group date form_date" data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input readonly type="text" class="form-control" name="hasta" id="hasta"
                                data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy"
                                data-mask="dd/mm/yyyy" im-insert="false" value="{{ $hasta }}"
                                placeholder="dd/mm/yyyy">
                            <div class="input-group-btn">
                                <button class="btn btn-primary date-set" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <label for="" class="d-none d-sm-block">&nbsp;</label>
                        <button type="submit" class=" form-control btn btn-primary">
                            <i class="fas fa-search"></i> Listar Recibos </button>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-4">
                        <label for="">Cliente:</label>
                        <input type="text" name="idcliente" id="idcliente"
                            value="{{ $cliente == null ? '' : $cliente->idcliente }}" hidden>
                        <i class="fas fa-search text-primary" onclick="mClientes()" style="cursor: pointer"></i>
                        <input type="text" id="nombres_apellidos"
                            value="{{ $cliente == null ? '' : $cliente->Persona->nombres_apellidos() }}"
                            class="form-control" disabled>
                    </div>
                    <div class="col-6">
                        <label for="">Dirección:</label>
                        <input type="text" id="direccion"
                            value="{{ $cliente == null ? '' : $cliente->Persona->direccion }}" class="form-control"
                            disabled>
                    </div>
                    <div class="col-2">
                        <label for="">Teléfono:</label>
                        <input type="text" id="celular" value="{{ $cliente == null ? '' : $cliente->Persona->celular }}"
                            class="form-control" disabled>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body border shadow">
            @if (session('good'))
                <div class="alert alert-success alert-dissmissible fade show mt-3" role="alert">
                    {{ session('good') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" style="width: 100pt">Acción</th>
                            <th scope="col">Nº Recibo</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Cajero</th>
                            <th>Pago</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recibos as $key => $item)
                            <tr>
                                <td class="text-center">
                                    <abbr title="Imprimir Recibo">
                                        <a href="{{ route('imprimirRecibo', $item->idrecibo) }}" target="_blank"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-print"></i>
                                            Imprimir
                                        </a>
                                    </abbr>
                                </td>
                                <td>{{ $item->nrorecibo }}</td>
                                <td>{{ $item->fecha->format('d-m-Y h:i a') }}</td>
                                <td>{{ $item->Cliente->Persona->nombres_apellidos() }}</td>
                                <td>{{ $item->Cliente->Persona->celular }}</td>
                                <td>{{ $item->Trabajador->Persona->nombres }}</td>
                                <td>{{ $item->TipoPago->descripcion }}</td>
                                <td class="text-right">S/.&nbsp; {{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $recibos->links() }}
            </div>
            <div class="row">
                <div class="col-md-8">
                </div>
                <div class="col-md-2 text-right" style="padding-top: 5px">
                    <label for="">Importe total:</label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control text-right" readonly="readonly"
                        value="S/.&nbsp; {{ number_format($total, 2) }}">
                </div>
            </div>
        </div>
    </div>
    <br>
    @include('administrador.recibo.modalBuscarCliente')
@endsection
@section('script')
    <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
    <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
    <script src="/js/datatables/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablaClientes').DataTable({
                language: {
                    "url": "/js/datatables/Spanish.json",
                },
            })
        })

        function mClientes() {
            $('#modalClientes').modal('show')
        }

        function seleccionar(cliente, direccion, telefono, idcliente) {
            $('#nombres_apellidos').val(cliente)
            $('#direccion').val(direccion)
            $('#celular').val(telefono)
            $('#idcliente').val(idcliente)
            $('#modalClientes').modal('hide')
        }

    </script>
@endsection
