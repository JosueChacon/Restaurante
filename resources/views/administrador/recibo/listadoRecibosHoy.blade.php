@extends('layout.plantilla_admin')
@section('contenido')
    <i class="fas fa-tasks text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Ventas del día, {{ date('d-m-Y') }}</font>
    <a class="btn btn-sm btn-primary float-right" target="_blank" href="{{ route('imprimirVentasTotalesDiarias') }}">
        <i class="fas fa-print"></i> Imprimir</a>
    <div class="card mt-2">
        <div class="card-body border shadow">
            <form action="">
                <div class="row">
                    <div class="col-md-5">
                        <label for="">Cajero:</label>
                        <select name="idcaja" class="form-control">
                            <option value="0">--- Todas los cajeros ---</option>
                            @foreach ($cajas as $item)
                                <option value="{{ $item->idcaja }}" {{ $item->idcaja == $idcaja ? 'selected' : '' }}>
                                    Caja
                                    {{ $item->idcaja . ': ' . $item->Usuario->Persona->nombres_apellidos() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="">&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control"><i class="fas fa-search"></i>
                            Listar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body border shadow">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" style="width: 40pt">#</th>
                            <th scope="col">Nº Recibo</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Cliente</th>
                            {{-- <th scope="col">Teléfono</th> --}}
                            <th scope="col">Cajero</th>
                            <th>Pago</th>
                            <th class="text-right">Total S/.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recibos as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $item->nrorecibo }}</td>
                                <td>{{ $item->fecha->format('d-m-Y  h:i a') }}</td>
                                <td>{{ $item->Cliente->Persona->nombres_apellidos() }}</td>
                                {{-- <td>{{ $item->Cliente->Persona->celular }}</td> --}}
                                <td>{{ $item->Trabajador->Persona->nombres_apellidos() }}</td>
                                <td>{{ $item->TipoPago->descripcion }}</td>
                                <td class="text-right">{{ number_format($item->total, 2) }}</td>
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
                    <label for="">Importe total S/.</label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control text-right" readonly="readonly"
                        value="{{ number_format($total, 2) }}">
                </div>
            </div>
        </div>
    </div>
    <br>
@endsection
