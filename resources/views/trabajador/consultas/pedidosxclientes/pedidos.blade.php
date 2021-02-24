@extends('layout.plantilla_trabajador')
@section('contenido')
<br>
<div class="card">
    <div class="card-header">
        <font style="font-family: Times New Roman; font-size: 16pt">Pedidos de: </font>
        <font style="font-family: Times New Roman; font-size: 18pt;">
            <strong><em>{{$cliente->Persona->nombres.' '.$cliente->Persona->apellidos}}</em></strong></font>
    </div>
    <div class="card-body">
        <p class="card-text">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nº Pedido</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Total</th>
                        <th scope="col">¿Detalles?</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cliente->Pedidos as $key=>$item)
                    <tr>
                        <td>{{$item->formato($item->idpedido)}}</td>
                        <td>{{$item->fecha->format('d-m-Y')}}</td>
                        <td>{{$item->fecha->format('h:i a')}}</td>
                        <td>{{$item->Cliente->Persona->nombres.' '.$item->Cliente->Persona->apellidos}}</td>
                        <td>{{$item->Cliente->Persona->celular}}</td>
                        <td>{{$item->estado}}</td>
                        <td>S/. {{$item->Total($item->DPedido)}}</td>
                        <td>
                            <button type="button" style="margin-top: -7px" class="btn btn-sm btn-success" id="detalles"
                                onclick="eval('{{$item->idpedido}}')"><i class="fas fa-list-alt"></i> Detalles</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-2">
                    <a href="{{URL::to('consultas/clientes')}}" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
                        Volver</a>
                </div>
            </div>
        </p>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <font style="font-family: times new roman; font-size: 14pt"><em>Detalles de pedido</em> </font>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <table class="table" id="detalles_tabla">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col" class="text-right">P. venta</th>
                                    <th scope="col" class="text-right">Cantidad</th>
                                    <th scope="col" class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="tblbody">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="/js/detallesPedido.js"></script>
@endsection