@extends('layout.plan_cajero')
@section('contenido')
    <br>
    <div class="card border shadow">
        <div class="card-header">
            <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
                Ventas diarias, {{ date('d-m-Y') }}</font>
            <a class="btn btn-sm btn-primary float-right" target="_blank" href="{{ route('imprimirtVentasDiarias') }}">
                <i class="fas fa-print"></i> Imprimir PDF</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nº Recibo</th>
                            <th scope="col">Hora</th>
                            <th scope="col">Cliente</th>
                            <th class="text-right">Efectivo</th>
                            <th class="text-right">Tarjeta</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recibos_x_t as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nrorecibo }}</td>
                                <td>{{ $item->fecha->format('h:i a') }}</td>
                                <td>{{ $item->Cliente->Persona->nombres_apellidos() }}</td>
                                <td class="text-right">{{ number_format($item->efectivo, 2) }}</td>
                                <td class="text-right">{{ number_format($item->tarjeta, 2) }}</td>
                                <td class="text-right">{{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $recibos_x_t->links() }}
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="">Monto total Efectivo:</label>
                    <input type="text" name="" id="" value="{{ number_format($efectivo, 2) }}" 
                    class="form-control border shadow bg-success text-center"
                        disabled>
                </div>  
                <div class="col-md-4">
                    <label for="">Monto total Tarjeta:</label>
                    <input type="text" name="" id="" value="{{ number_format($tarjeta, 2) }}" 
                    class="form-control border shadow bg-success text-center"
                        disabled>
                </div>  
                <div class="col-md-4">
                    <label for="">Monto total Ventas:</label>
                    <input type="text" name="" id="" value="{{ number_format($total, 2) }}" 
                    class="form-control border shadow bg-success text-center"
                        disabled>
                </div>                
            </div>
        </div>
    </div>
@endsection
