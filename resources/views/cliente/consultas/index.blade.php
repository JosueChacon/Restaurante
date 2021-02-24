@extends('layout.plantilla_cliente')
@section('contenido')
<br>
<div class="card">
    <div class="card-header">
        <font style="font-family: times new roman; font-size: 16pt">Mis Pedidos</font>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                @if (session('good'))
                <div class="alert alert-success alert-dissmissible fade show mt-3" role="alert">
                    {{session('good')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger alert-dissmissible fade show mt-3" role="alert">
                    {{session('error')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <a href="{{route('pedidosCliente.create')}}" class="btn btn-primary">
                    <i class="fas fa-check-circle"></i> Registrar Pedido</a><br>
            </div>
        </div>
        <div class="row pt-2">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Nº Pedido</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Hora</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Estado</th>
                                <th scope="col" class="text-right">Total</th>
                                <th scope="col" class="text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $item)
                            <tr>
                                <td>{{$item->formato($item->idpedido)}}</td>
                                <td>{{$item->fecha->format('d/m/Y')}}</td>
                                <td>{{$item->fecha->format('h:i a')}}</td>
                                <td>{{auth()->user()->Persona->nombres.' '.auth()->user()->Persona->apellidos}}</td>
                                <td>{{$item->estado}}</td>
                                <td class="text-right">S/. &nbsp;{{$item->Total($item->DPedido)}}</td>
                                <td class="text-center">
                                    <a href="{{route('pedidosCliente.confirmar',$item->idpedido)}}"
                                        class="btn btn-sm btn-danger"><i class="fas fa-times-circle"></i> Anular</a>
                                    <a href="{{route('pedidosCliente.detalles',$item->idpedido)}}"
                                        class="btn btn-sm btn-info"><i class="fas fa-list"></i> Detalles</a>
                                    <a target="_blank" href="{{route('imprimirPedido',$item->idpedido)}}"
                                        class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Imprimir</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$pedidos->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection