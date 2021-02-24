@extends($plantilla)
@section('contenido')
    <form action="{{ route('cerrarcaja') }}" method="POST">
        @csrf
        <i class="fas fa-lock text-primary"></i>
        <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
            Cierre de caja, {{ date('d-m-Y') }}</font>
        @if (session('error'))
            <div class="alert alert-danger alert-dissmissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('good'))
            <div class="alert alert-success alert-dissmissible fade show mt-3" role="alert">
                {{ session('good') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card mt-2">
            <div class="card-header">
                .::Cajas activas
            </div>
            <div class="card-body border shadow">
                <div class="row">
                    <div class="col-md-5 col-sm-8 col-12">
                        <label> Seleccione caja </label>
                        <select name="idmovimiento" id="idmovimiento" class="form-control" onchange="cboCaja()">
                            @if (count($data) == 0)
                                <option value="">--- No hay cajas para cerrar ---</option>
                            @endif

                            @foreach ($data as $item)
                                <option value="{{ $item['idmovimiento'] }}">
                                    {{ $item['cboCaja'] }}
                                </option>
                            @endforeach
                        </select>
                        @if (count($data) == 0)
                            <span style="color: red">*Debe aperturar una caja.</span>
                            <span><a href="{{ route('aperturarcaja') }}">Aperturar?</a></span>
                        @else
                            <span>
                                <font style="font-size: 10pt">
                                    <font style="color: red">*</font>Si cierra una caja, no puede volver a aperturarla según
                                    fecha.
                                </font>
                            </span>
                        @endif
                    </div>
                    @if (count($data) > 0)
                        <div class="col-md-3 col-sm-6 col-12">
                            <label for="">&nbsp;</label>
                            <button type="submit" class="btn btn-primary form-control">
                                <i class="fas fa-lock"></i> Cerrar caja
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>

    <div class="card mt-2">
        <div class="card-header">
            .::Cajas aperturadas/cerradas
        </div>
        <div class="card-body border shadow">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Caja</th>
                                    <th class="text-center">Estado</th>
                                    <th>Hora apertura</th>
                                    <th>Hora cierre</th>
                                    <th class="text-right">Monto inicio</th>
                                    <th class="text-right">Efectivo</th>
                                    <th class="text-right">Tarjeta</th>
                                    <th class="text-right">Monto cierre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $ca)
                                    <tr>
                                        <td>{{ $ca['caja'] }}</td>
                                        @if ($ca['estado'] == 'CERRADA')
                                            <td>
                                                <i class="fas fa-lock text-danger"></i> {{ $ca['estado'] }}
                                            </td>
                                        @else
                                            <td>
                                                <i class="fas fa-lock-open text-primary"></i>
                                                {{ $ca['estado'] }}
                                            </td>
                                        @endif
                                        <td>{{ $ca['fecha_inicio'] }}</td>
                                        <td>{{ $ca['fecha_cierre'] }}</td>
                                        <td class="text-right">{{ $ca['monto_inicio'] }}</td>
                                        <td class="text-right">{{ number_format($ca['efectivo_hoy'], 2) }}
                                        </td>
                                        <td class="text-right">{{ number_format($ca['tarjeta_hoy'], 2) }}
                                        </td>
                                        <td class="text-right">{{ $ca['monto_cierre'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-2" style="padding-top: 5px">
                            <label for="">Total cierre S/. </label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control text-right" readonly="readonly"
                                value="{{ number_format($total_cerrado, 2) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
