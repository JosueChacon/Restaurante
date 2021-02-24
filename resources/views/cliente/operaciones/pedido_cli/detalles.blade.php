@extends('layout.plantilla_cliente')
@section('contenido')
<br>
<div class="card">
    <div class="card-header">
        <font style="font-family: times new roman; font-size: 18pt">Datos de pedido </font>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-1" style="padding-top: 7px">
                <label>Nº Pedido</label>
            </div>
            <div class="col-sm-2">
                <input disabled class="form-control" type="text" value="{{$pedido->formato($pedido->idpedido)}}"
                    style="text-align: center">
            </div>
            <div class="col-sm-1" style="padding-top: 7px">
                <label>Fecha</label>
            </div>
            <div class="col-sm-3">
                <input disabled class="form-control" type="text" value="{{$pedido->fecha->format('d-m-Y  h:i a')}}">
            </div>
            <div class="col-sm-1" style="padding-top: 7px">
                <label>Cliente</label>
            </div>
            <div class="col-sm-4">
                <input disabled class="form-control" type="text"
                    value="{{$pedido->Cliente->Persona->nombres.' '.$pedido->Cliente->Persona->apellidos}}">
            </div>
        </div>
        <div class="row pt-2">
            <div class="col-sm-1" style="padding-top: 7px">
                <label>Dirección</label>
            </div>
            <div class="col-sm-3">
                <input disabled class="form-control" type="text" value="{{$pedido->Cliente->Persona->direccion}}">
            </div>
            <div class="col-sm-1" style="padding-top: 7px">
                <label>Celular</label>
            </div>
            <div class="col-sm-2">
                <input disabled class="form-control" type="text" value="{{$pedido->Cliente->Persona->celular}}">
            </div>
        </div>
        <div class="row pt-2">
            <div class="col-sm-12">
                <font style="font-family: times new roman; font-size: 14pt"><em>Detalles de pedido</em> </font>
            </div>
        </div>
        <div class="row pt-1">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table" id="tabla">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Plato</th>
                                <th scope="col">Tipo Plato</th>
                                <th scope="col" class="text-right">P. Venta</th>
                                <th scope="col" class="text-right">Cantidad</th>
                                <th scope="col" class="text-right">SubTotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedido->DPedido as $key=>$item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->Plato->nombre}}</td>
                                <td>{{$item->Plato->TipoPlato->descripcion}}</td>
                                <td class="text-right">S/. {{$item->p_venta}}</td>
                                <td class="text-right">{{$item->cantidad}}</td>
                                <td class="text-right">S/. {{$item->cantidad*$item->p_venta}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row pt-2">
            <div class="col-sm-9"></div>
            <div class="col-sm-1" style="padding-top: 7px">
                <label>Total</label>
            </div>
            <div class="col-sm-2">
                <input disabled class="form-control text-right" type="text"
                    value="S/. {{$pedido->Total($pedido->DPedido)}}">
            </div>
        </div>
        <br>
        <a href="{{route('pedidosCliente.inicio')}}" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
            Volver</a>
    </div>
</div>
@endsection