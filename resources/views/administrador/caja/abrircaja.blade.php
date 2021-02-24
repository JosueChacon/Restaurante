@extends($plantilla)
@section('contenido')
    <form action="{{ route('aperturarcaja') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <i class="fas fa-lock-open text-primary"></i>
                <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
                    Apertura de caja, {{ date('d-m-Y') }}</font>
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
                        .::Listado de caja
                    </div>
                    <div class="card-body border shadow">
                        <div class="row">
                            <div class="col-md-5 col-sm-8 col-12">
                                <label> Seleccione caja </label>
                                <select name="idcaja" id="idcaja" class="form-control" onchange="cboCaja()">
                                    @if (count($cajas) == 0)
                                        <option value="">--- No hay cajas disponibles ---</option>
                                    @endif
                                    @foreach ($cajas as $item)
                                        <option value="{{ $item->idcaja }}">Caja {{ $item->idcaja }}:
                                            {{ $item->Usuario->Persona->nombres_apellidos() }}
                                        </option>
                                    @endforeach
                                </select>
                                @if (count($cajas) == 0)
                                    <span style="color: red">*No hay cajeros registrados</span>
                                @else
                                    <span>
                                        <font style="font-size: 10pt">
                                            <font style="color: red">*</font>El monto inicial de caja no será
                                            editable
                                        </font>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2 col-sm-4 col-12">
                                <label for="">Monto inicial</label>
                                <input type="number" name="monto_inicial" id="monto_inicial" min=".1" step=".1"
                                    value="{{ old('monto_inicial') }}"
                                    class="form-control @error('monto_inicial') is-invalid @enderror" @if (count($cajas) == 0) disabled @endif>
                                @error('monto_inicial')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if (count($cajas) > 0)
                            <div class="row pt-2">
                                <div class="col-md-3 col-sm-6 col-12">
                                    <button type="submit" class="btn btn-primary form-control"><i class="fas fa-bolt"></i>
                                        Aperturar caja</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        .::Cajas aperturadas
                    </div>
                    <div class="card-body border shadow">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Caja</th>
                                                <th>Responsable</th>
                                                <th>Aperturador</th>
                                                <th>Hora</th>
                                                <th class="text-right">Monto inicial S/.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cajas_aperturadas as $ca)
                                                <tr>
                                                    <td>Caja {{ $ca->idcaja }}</td>
                                                    <td>{{ $ca->Caja->Usuario->Persona->nombres_apellidos() }}
                                                    </td>
                                                    <td>{{ $ca->Usuario->Persona->nombres_apellidos() }}</td>
                                                    <td>{{ $ca->fecha_inicio->format('h:i a') }}</td>
                                                    <td class="text-right">
                                                        {{ number_format($ca->monto_inicio, 2) }}
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
                                        <label for="">Total aperturado S/. </label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control text-right" readonly="readonly"
                                            value="{{ number_format($total_aperturado, 2) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        function cboCaja() {
            $('#monto_inicial').focus();
        }

    </script>
@endsection
