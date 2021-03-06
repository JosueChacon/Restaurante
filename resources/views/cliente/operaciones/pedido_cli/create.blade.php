@extends('layout.plantilla_cliente')
@section('contenido')
<br>
<div class="card">
    <div class="card-header">
        <h4>¡Registre su pedido!</h4>
    </div>
    <div class="card-body">
        <form action="{{route('pedidosCliente.store')}}" method="POST" id="frmPedido">
            @csrf
            <div class="row">
                <div class="col-sm-1" style="padding-top: 5px">
                    <label>Nº Pedido</label>
                </div>
                <div class="col-sm-2">
                    <input disabled class="form-control" type="text" value="{{$nropedido}}" style="text-align: center">
                </div>
                <div class="col-sm-1" style="padding-top: 5px">
                    <label>Fecha</label>
                </div>
                <div class="col-sm-2">
                    <input disabled class="form-control" type="text" value="{{date('d M Y')}}"
                        style="text-align: center">
                </div>
                <div class="col-sm-1" style="padding-top: 5px">
                    <label>Cliente</label>
                </div>
                <div class="col-sm-5">
                    <input disabled class="form-control" type="text"
                        value="{{auth()->user()->Persona->nombres.' '.auth()->user()->Persona->apellidos}}">
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-1" style="padding-top: 5pt">
                    <label>Dirección</label>
                </div>
                <div class="col-sm-5">
                    <input disabled class="form-control" type="text" value="{{auth()->user()->Persona->direccion}}">
                </div>
                <div class="col-sm-1" style="padding-top: 5pt">
                    <label>Celular</label>
                </div>
                <div class="col-sm-2">
                    <input disabled class="form-control" type="text" value="{{auth()->user()->Persona->celular}}">
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header" style="background-color: green">
                            <font style="color: white">Detalle pedido</font>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-1" style="padding-top: 5px">
                                    <label>Plato: </label>
                                </div>
                                <div class="col-sm-5">
                                    <input hidden type="text" id="idplato" name="idplato">
                                    <input disabled class="form-control" type="text" id="nombre" name="nombre"
                                        value="{{old('nombre')}}">
                                </div>
                                <div class="col-sm-1" style="padding-top: 5px">
                                    <label>Tipo: </label>
                                </div>
                                <div class="col-sm-5">
                                    <input disabled class="form-control" type="text" id="tipo" name="tipo"
                                        value="{{old('tipo')}}">
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-sm-1" style="padding-top: 5px">
                                    <label>Stock: </label>
                                </div>
                                <div class="col-sm-2">
                                    <input disabled class="form-control" type="text" id="stock" name="stock"
                                        value="{{old('stock')}}">
                                </div>
                                <div class="col-sm-1" style="padding-top: 5px">
                                    <label>P. venta: </label>
                                </div>
                                <div class="col-sm-2">
                                    <input disabled class="form-control" type="text" id="p_venta" name="p_venta"
                                        value="{{old('p_venta')}}">
                                </div>
                                <div class="col-sm-1" style="padding-top: 5px">
                                    <label>Cantidad: </label>
                                </div>
                                <div class="col-sm-1">
                                    <input class="form-control" type="number" min="1" step="1" id="cantidad"
                                        name="cantidad" value="1"
                                        onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="form-control btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">
                                        <i class="fas fa-search"></i> Ver Platos
                                    </button>
                                </div>
                                <div class="col-sm-2">
                                    <button id="btnagregar" type="button" class="form-control btn btn-primary"
                                        onclick="agregar()">
                                        <i class="fas fa-shopping-cart"></i> Agregar</button>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table id="detalles" class="table" style='background-color: white'>
                                            <thead class="thead-default"
                                                style="background-color: dodgerblue; color: white;">
                                                <th width="115px" class="text-center">¿Quitar?</th>
                                                <th>#</th>
                                                <th>Plato</th>
                                                <th>Tipo plato</th>
                                                <th class="text-right">P. venta</th>
                                                <th class="text-right">Cantidad</th>
                                                <th class="text-right">Importe</th>
                                            </thead>
                                            <tfoot>

                                            </tfoot>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-sm-9"></div>
                                <div class="col-sm-1" style="padding-top: 5pt">
                                    <label>Total:</label>
                                </div>
                                <div class="col-sm-2">
                                    <input disabled class="form-control text-right" type="text" id="total" name="total"
                                        value="{{old('total')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-2">
                    <a href="{{route('pedidosCliente.index')}}" class="form-control btn btn-danger"><i
                            class="fas fa-arrow-left"></i> Cancelar</a>
                </div>
                <div class="col-sm-2">
                    <button type="button" id="grabar" class="form-control btn btn-primary"><i class="fas fa-cloud"></i>
                        Enviar Pedido </button>
                </div>
            </div>

            <table hidden class="table" id="data-table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">idplat</th>
                        <th scope="col">idplato</th>
                        <th scope="col">cantidad</th>
                        <th scope="col">p_venta</th>
                        <th scope="col">subtot</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </form>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <font style="font-family: times new roman; font-size: 14pt"><em>Platos Disponibles</em></font>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        @foreach ($prog->DProgramacion as $f)
                        <div class="col-sm-4">
                            <div class="form-group">
                                <img src="{{asset($f->Plato->getRutaFoto())}}" width="300" class="img-fluid"
                                    alt="Responsive image"><br>
                                <strong>Nombre : </strong>{{$f->Plato->nombre}}<br>
                                <strong>Tipo Plato : </strong> {{$f->Plato->tipoplato->descripcion}} <br>
                                <strong>P. Venta : </strong>S/. {{$f->Plato->p_venta}}<br>
                                <strong>Stock Aprox. : </strong><u>{{$f->stock}}</u><br>
                                <button type="button" class="btn btn-sm btn-warning"
                                    onclick="pasar('{{$f->Plato->id}}', '{{$f->Plato->nombre}}','{{$f->Plato->tipoplato->descripcion}}','{{$f->stock}}','{{$f->Plato->p_venta}}')"
                                    data-dismiss="modal"><i class="fas fa-check"></i>
                                    Seleccionar</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="/js/pedido-create.js"></script>
@endsection