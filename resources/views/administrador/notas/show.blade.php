@extends('layout.plantilla_admin')
@section('estilos')
    <link rel="stylesheet" href="/js/datatables/jquery.dataTables.min.css">
@endsection
@section('contenido')
    <i class="fas fa-plus-square text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Nota de ingreso
    </font>
    <div class="card">
        <div class="card-body border shadow">
            <div class="row">
                <div class="col-md-2">
                    <label>Código:</label>
                    <input disabled class="form-control" type="text" placeholder="Ingrese costo"
                        value="{{ $nota->idnota }}" style="text-align: center">
                </div>
                <div class="col-md-2">
                    <label>Fecha:</label>
                    <input disabled class="form-control" type="text" placeholder="Ingrese costo"
                        value="{{ $nota->fecha->format('d/m/Y') }}">
                </div>
                <div class="col-md-2">
                    <label>Hora:</label>
                    <input disabled class="form-control" type="text" placeholder="Ingrese costo"
                        value="{{ $nota->fecha->format('h:i a') }}">
                </div>
                <div class="col-md-6">
                    <label>Responsable:</label>
                    <input disabled class="form-control" type="text" placeholder="Ingrese costo"
                        value="{{ $nota->Trabajador->Persona->nombres_apellidos() }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-2">
                        <div class="card-header border shadow">
                            <span>.::Detalle de Nota</span>
                        </div>
                        <div class="card-body border shadow">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="detallenota">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th style="width: 50pt">#</th>
                                                    <th scope="col" style="width: 80pt">Cantidad</th>
                                                    <th scope="col" style="width: 350">Bebida</th>
                                                    <th scope="col" class="text-right">Precio</th>
                                                    <th scope="col" class="text-right">Importe</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($nota->DNota as $c => $item)
                                                    <tr>
                                                        <td>{{ $c + 1 }}</td>
                                                        <td>{{ $item->cantidad }}</td>
                                                        <td>{{ $item->Producto->nombre }}</td>
                                                        <td class="text-right">{{ $item->p_costo }}</td>
                                                        <td class="text-right">{{ $item->cantidad * $item->p_costo }}</td>                                          
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                </div>
                                <div class="col-md-2 text-right" style="padding-top: 5px">
                                    <label for="">Importe total:</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control text-right" name="total" id="total"
                                        readonly="readonly" value="{{ number_format($nota->total, 2) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <a href="{{ route('NotaIngreso.index') }}" class="btn btn-danger form-control"><i
                            class="fas fa-arrow-left"></i>
                        Cancelar</a>
                </div>                
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="/js/datatables/jquery.dataTables.min.js"></script>
@endsection
