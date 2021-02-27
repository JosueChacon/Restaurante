@extends('layout.plantilla_trabajador')
@section('estilos')
    <link rel="stylesheet" href="/js/datatables/jquery.dataTables.min.css">
@endsection
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h4>¡Registre su pedido!</h4>
        </div>
        <div class="card-body">
            <form id="frmPedido" action="{{ route('pedidos.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-1" style="padding-top: 5px">
                        <label>Nº Pedido</label>
                    </div>
                    <div class="col-sm-2">
                        <input disabled class="form-control" type="text" value="{{ $nropedido }}"
                            style="text-align: center">
                    </div>
                    <div class="col-sm-1" style="padding-top: 5px">
                        <label>Fecha</label>
                    </div>
                    <div class="col-sm-2">
                        <input disabled class="form-control" type="text" value="{{ date('d M Y') }}"
                            style="text-align: center">
                    </div>
                    <div class="col-sm-1" style="padding-top: 5px">
                        <label>Trabajador</label>
                    </div>
                    <div class="col-sm-5">
                        <input disabled class="form-control" type="text" {{-- value="{{ auth()->user()->Persona->nombres . ' ' . auth()->user()->Persona->apellidos }}" --}} value="- - - - - -">
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-sm-1" style="padding-top: 5px">
                        <label>Cliente</label>
                    </div>
                    <div class="col-sm-5">
                        <select name="idcliente" id="idcliente" class="form-control">
                            @foreach ($clientes as $item)
                                <option value="{{ $item->idcliente }}">
                                    {{ $item->Persona->nombres . ' ' . $item->Persona->apellidos }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-1" style="padding-top: 5px">
                        <label>Nº Mesa</label>
                    </div>
                    <div class="col-sm-5">
                        <input disabled class="form-control" type="text" value="MESA {{ $mesa->nromesa }}"
                            style="text-align: center">
                        <input hidden type="text" id="mesa_id" name="mesa_id" value="{{ $mesa->mesa_id }}">
                    </div>
                </div>
                <div class="row pt-2"> </div>

                <div class="card border shadow">
                    <div class="card-header" style="background-color: #22bb33">
                        <font style="color: white;">Detalle pedido</font>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-1" style="padding-top: 5px">
                                <label>Nombre: </label>
                            </div>
                            <div class="col-sm-5">
                                <input hidden type="text" id="idplato" name="idplato">
                                <input disabled class="form-control" type="text" id="nombre" name="nombre"
                                    value="{{ old('nombre') }}">
                            </div>
                            <div class="col-sm-1" style="padding-top: 5px">
                                <label>Tipo: </label>
                            </div>
                            <div class="col-sm-5">
                                <input disabled class="form-control" type="text" id="tipo" name="tipo"
                                    value="{{ old('tipo') }}">
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-sm-1" style="padding-top: 5px">
                                <label>Stock: </label>
                            </div>
                            <div class="col-sm-1">
                                <input disabled class="form-control" type="text" id="stock" name="stock"
                                    value="{{ old('stock') }}">
                            </div>
                            <div class="col-sm-1" style="padding-top: 5px">
                                <label>P. venta: </label>
                            </div>
                            <div class="col-sm-1">
                                <input disabled class="form-control" type="text" id="p_venta" name="p_venta"
                                    value="{{ old('p_venta') }}">
                            </div>
                            <div class="col-sm-1" style="padding-top: 5px">
                                <label>Cantidad: </label>
                            </div>
                            <div class="col-sm-1">
                                <input class="form-control" type="number" min="1" step="1" id="cantidad" name="cantidad"
                                    value="1" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="form-control btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal" onclick="btnplatos()">
                                    <i class="fas fa-search"></i> Platos
                                </button>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="form-control btn btn-primary" data-toggle="modal"
                                    data-target="#modalProductos" onclick="btnproductos()">
                                    <i class="fas fa-search"></i> Bebidas
                                </button>
                            </div>
                            <div class="col-sm-2">
                                <button id="btnagregar" type="button" class="form-control btn btn-success">
                                    <i class="fas fa-arrow-down"></i> Agregar</button>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table id="detalles" class="table table-bordered" style='background-color: white'>
                                        <thead class="thead-default" style="background-color: blue; color: white;">
                                            <th width="115px" class="text-center">¿Quitar?</th>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th class="text-right">P. venta</th>
                                            <th class="text-right">Cantidad</th>
                                            <th class="text-right">Importe</th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                    </div>
                                    <div class="col-md-1" style="padding-top: 5px">
                                        <label for="">Total: </label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control text-right" name="total" id="total"
                                            readonly="readonly">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-md-12">
                        <label for="obs">Observaciones: </label>
                        <textarea name="obs" id="obs" rows="3" class="form-control">

                        </textarea>
                    </div>                    
                </div>
                <div class="row pt-2">
                    <div class="col-sm-2">
                        <a href="{{ route('home') }}" class='form-control btn btn-danger'><i
                                class='fas fa-arrow-left'></i>
                            Cancelar</a>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" id="btnRegistrar" class="form-control btn btn-primary"
                            data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando">
                            <i class='fas fa-save'></i> Registrar</button>
                        <input type="text" name="idtrabajador" id="idtrabajador" hidden>
                    </div>
                    <input type="text" name="lugar" value="LOCAL" hidden>
                </div>
            </form>
        </div>
    </div>
    @include('trabajador.ventas.local.tpedidos.confirmar')
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Platos programados</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tablaPlatos">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Foto</th>
                                            <th>Nombre</th>
                                            <th>Tipo plato</th>
                                            <th class="text-right">P. Venta</th>
                                            <th class="text-right">Stock</th>
                                            <th class="text-center">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($prog->DProgramacion as $f)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset($f->Plato->getRutaFoto()) }}" width="50"
                                                        class="img-fluid" alt="Responsive image">
                                                </td>
                                                <td>{{ $f->Plato->nombre }}</td>
                                                <td>{{ $f->Plato->tipoplato->descripcion }}</td>
                                                <td>S/. {{ $f->Plato->p_venta }}</td>
                                                <td>{{ $f->stock }}</td>
                                                <td>
                                                    <button type="button" id="btnpasar" class="btn btn-sm btn-warning"
                                                        onclick="pasar('{{ $f->Plato->id }}', '{{ $f->Plato->nombre }}','{{ $f->Plato->tipoplato->descripcion }}','{{ $f->stock }}','{{ $f->Plato->p_venta }}')"
                                                        data-dismiss="modal"><i class="fas fa-check"></i>
                                                        Seleccionar</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalProductos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fas fa-search text-primary"></i>
                        Eligiendo bebida...
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tablaProductos">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>P. Venta</th>
                                            <th>Stock</th>
                                            <th class="text-center">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productos as $f)
                                            <tr>
                                                <td>{{ $f->nombre }}</td>
                                                <td>{{ $f->Categoria->descripcion }}</td>
                                                <td>S/. {{ $f->p_venta }}</td>
                                                <td>{{ $f->stock }}</td>
                                                <td class="text-center">
                                                    <button type="button" id="btnpasar" class="btn btn-sm btn-warning"
                                                        onclick="pasar('{{ $f->id }}', '{{ $f->nombre }}','{{ $f->Categoria->descripcion }}','{{ $f->stock }}','{{ $f->p_venta }}')"
                                                        data-dismiss="modal"><i class="fas fa-check"></i>
                                                        Seleccionar</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="/js/pedido-local.js?v=2"></script>
    <script src="/js/datatables/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablaPlatos').DataTable({
                language: {
                    "url": "/js/datatables/Spanish.json",
                },
                columnDefs: [{
                        "className": "text-right",
                        "targets": [3, 4]
                    },
                    {
                        "className": "text-center",
                        "targets": 5
                    }
                ]
            })
            $('#tablaProductos').DataTable({
                language: {
                    "url": "/js/datatables/Spanish.json",
                },
            });
        });

    </script>
@endsection
