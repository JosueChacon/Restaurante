@extends('layout.plantilla_admin')
@section('contenido')
    <i class="fas fa-list text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Programación de platos
    </font>
    <div class="card">
        <div class="card-header border shadow">
            <div class="row">
                <div class="col-md-12">
                    <span>.::Detalles de programación</span>
                </div>
            </div>
        </div>
        <div class="card-body border shadow">
            <div class="row">
                <div class="col-md-2">
                    <label for="">Código:</label>
                    <input type="text" name="" id="" class="form-control" onkeypress="return false"
                        value="{{ $prog->idprogramacion }}">
                </div>
                <div class="col-md-2">
                    <label for="">Fecha:</label>
                    <input class="form-control" type="text" placeholder="Ingrese costo"
                        value="{{ $prog->fecha->format('d-m-Y') }}" onkeypress="return false">
                </div>
                <div class="col-md-2">
                    <label for="">Hora:</label>
                    <input class="form-control" type="text" placeholder="Ingrese costo"
                        value="{{ $prog->fecha->format('h:i a') }}" onkeypress="return false">
                </div>
                <div class="col-md-6">
                    <label for="">Responsable:</label>
                    <input type="text" name="" id="" class="form-control"
                        value="{{ $prog->Trabajador->Persona->nombres_apellidos() }}" onkeypress="return false">
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="width: 50pt">Código</th>
                                    <th scope="col">Plato</th>
                                    <th scope="col">Tipo Plato</th>
                                    <th scope="col" class="text-right">P. Compra</th>
                                    <th scope="col" class="text-right">P. Venta</th>
                                    <th scope="col" class="text-right">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody >
                                @foreach ($detalles as $item)
                                    <tr>
                                        <td>{{ $item->plato->id }}</td>
                                        <td>{{ $item->plato->nombre }}</td>
                                        <td>{{ $item->plato->tipoplato->descripcion }}</td>
                                        <td class="text-right">{{ $item->plato->p_costo }}</td>
                                        <td class="text-right">{{ $item->plato->p_venta }}</td>
                                        <td class="text-right">{{ $item->stock }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $detalles->links() }}
                    </div>
                </div>
            </div>
            <a href="{{ route('programacion.index') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i>
                Volver</a>
        </div>
    </div>
@endsection
