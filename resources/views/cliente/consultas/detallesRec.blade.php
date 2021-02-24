@extends('layout.plantilla_cliente')
@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection
@section('contenido')
<br>
<div class="card">
    <div class="card-header">
        <font style="font-family: times new roman; font-size: 18pt">Recibo Nº
            {{$recibo->nrorecibo}}</font>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-1" style="padding-top: 5pt">
                <label>Nº Recibo</label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="fechita" id="fechita" value="{{ $recibo->nrorecibo }}"
                    style="text-align:center;" readonly="readonly">
            </div>
            <div class="col-sm-1" style="padding-top: 5pt">
                <label>Fecha</label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="fechita" id="fechita"
                    value="{{ $recibo->fecha->format('d/m/Y  h:i a') }}" readonly="readonly">
            </div>
            <div class="col-sm-1" style="padding-top: 5pt">
                <label>Cliente</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="fechita" id="fechita"
                    value="{{ $recibo->Cliente->nombrecompleto($recibo->Cliente) }}" readonly="readonly">
            </div>
        </div>
        <div class="row pt-2">
            <div class="col-sm-1" style="padding-top: 5pt">
                <label>Celular</label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="fechita" id="fechita"
                    value="{{ $recibo->Cliente->Persona->celular }}" readonly="readonly">
            </div>
            <div class="col-sm-1" style="padding-top: 5pt">
                <label>Dirección</label>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="fechita" id="fechita"
                    value="{{ $recibo->Cliente->Persona->direccion }}" readonly="readonly">
            </div>
            <div class="col-sm-1" style="padding-top: 5pt">
                <label>Tipo Doc.</label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="fechita" id="fechita"
                    value="{{ $recibo->Tipo->descripcion }}" style="text-align:center;" readonly="readonly">
            </div>
        </div>
        <font style="font-family: times new roman; font-size: 14pt"><em>Detalles de recibo</em> </font>
        <div class="table-responsive">
            <table id="detalles" class="table" style='background-color: white'>
                <thead class="thead-default" style="background-color: blue; color: white;">
                    <th width="110px" class="text-center">¿Detalles?</th>
                    <th>#</th>
                    <th>Nº Pedido</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Cliente</th>
                    <th>Celular</th>
                    <th class="text-right">Monto</th>
                </thead>
                <tbody>
                    @foreach ($recibo->DRecibo as $key=>$item)
                    <tr>
                        <td class="text-center">
                            <button type="button" style="margin-top: -7px" class="btn btn-sm btn-info" id="detalles"
                                onclick="eval('{{$item->idpedido}}')"><i class="fas fa-list-alt"></i> Detalles</button>
                        </td>
                        <td>{{$key+1}}</td>
                        <td>{{$item->Pedido->formato($item->Pedido->idpedido)}}</td>
                        <td>{{$item->Pedido->fecha->format('d-m-Y')}}</td>
                        <td>{{$item->Pedido->fecha->format('h:i a')}}</td>
                        <td>{{$item->Pedido->Cliente->nombrecompleto($item->Pedido->Cliente)}}</td>
                        <td>{{$item->Pedido->Cliente->Persona->celular}}</td>
                        <td class="text-right">S/. {{$item->Pedido->Total($item->Pedido->DPedido)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-1" style="padding-top: 5pt">
                <label for="">Total : </label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control text-right" value="S/.  {{$recibo->total}}" readonly="readonly">
            </div>
        </div>
        <a href="{{URL::to('consultas/recibosCliente')}}" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
            Volver</a>
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
                                    <th scope="col">Plato</th>
                                    <th scope="col">Tipo de Plato</th>
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