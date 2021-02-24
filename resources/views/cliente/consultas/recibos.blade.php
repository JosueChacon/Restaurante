@extends('layout.plantilla_cliente')
@section('contenido')
<br>
<div class="card">
    <div class="card-header">
        <u>
            <font style="font-family: times new roman; font-size: 18pt"><em>Mis Recibos</em></font>
        </u>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nº Recibo</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Tipo Doc.</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Usuario</th>                        
                        <th scope="col">Total</th>
                        <th scope="col" class="text-center">¿Detalles?</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recibos as $key=>$item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->nrorecibo}}</td>
                        <td>{{$item->fecha->format('d-m-Y')}}</td>
                        <td>{{$item->fecha->format('h:i a')}}</td>
                        <td>{{$item->Tipo->descripcion}}</td>
                        <td>{{$item->Cliente->Persona->nombres.' '.$item->Cliente->Persona->apellidos}}</td>
                        <td>{{$item->Cliente->Persona->celular}}</td>
                        <td>{{$item->Trabajador->Persona->apellidos}}</td>                        
                        <td>S/. {{$item->total}}</td>
                        <td class="text-center">
                            <a href="{{route('recibosCliente.detallesRec',$item->idrecibo)}}"
                                class="btn btn-sm btn-success"><i class="fas fa-list-alt"></i> Detalles</a>
                            <a target="_blank" href="{{route('imprimirRecibo',$item->idrecibo)}}" class="btn btn-sm btn-primary"><i
                                    class="fas fa-print"></i> Imprimir PDF</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$recibos->links()}}
        </div>
    </div>
</div>
@endsection