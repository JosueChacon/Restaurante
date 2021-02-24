@extends('layout.plantilla_admin')
@section('estilos')
    <link rel="stylesheet" href="/js/datatables/jquery.dataTables.min.css">
@endsection
@section('contenido')
    <i class="fas fa-plus-square text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Registro de Notas de Ingreso
    </font>
    <form action="{{ route('NotaIngreso.store') }}" method="POST" id="frmNota">
        @csrf
        <div class="card">
            <div class="card-body border shadow">
                <div class="row">
                    <div class="col-md-2">
                        <label>Código:</label>
                        <input disabled class="form-control" type="text" placeholder="Ingrese costo" value="Autogenerado"
                            style="text-align: center">
                    </div>
                    <div class="col-md-2">
                        <label>Fecha:</label>
                        <input disabled class="form-control" type="text" placeholder="Ingrese costo"
                            value="{{ date('d/m/y') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Responsable:</label>
                        <input disabled class="form-control" type="text" placeholder="Ingrese costo"
                            value="{{ auth()->user()->Persona->nombres_apellidos() }}">
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
                                    <div class="col-sm-6">
                                        <label>Bebida</label>
                                        <input disabled class="form-control" type="text" id="producto" name="producto">
                                        <input hidden class="form-control" type="text" id="idproducto" name="idproducto">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>P. Costo</label>
                                        <input disabled class="form-control" type="text" id="p_costo" name="p_costo">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>P. Venta</label>
                                        <input disabled class="form-control" type="text" id="p_venta" name="p_venta">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Stock</label>
                                        <input disabled class="form-control" type="text" id="stock" name="stock">
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-sm-2">
                                        <label>P. Costo nuevo</label>
                                        <input class="form-control" type="number" id="p_costo_nuevo" name="p_costo_nuevo">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Cantidad</label>
                                        <input class="form-control" type="number" min="1" step="1" id="cantidad"
                                            name="cantidad" value="1"
                                            onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="">&nbsp;</label><br>
                                        <button type="button" class="form-control btn btn-success" onclick="agregar()">
                                            <i class="fas fa-arrow-down"></i>
                                            Agregar
                                        </button>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="">&nbsp;</label><br>
                                        <button type="button" class="form-control btn btn-primary" data-toggle="modal"
                                            data-target="#modalProductos">
                                            <i class="fas fa-search"></i>
                                            Buscar Bebidas
                                        </button>
                                    </div>

                                </div>
                                <div class="row pt-2">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="detallenota">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col" style="width: 50pt">Acción</th>
                                                        <th scope="col" style="width: 80pt">Cantidad</th>
                                                        <th scope="col">Bebida</th>
                                                        <th scope="col" class="text-right">Precio</th>
                                                        <th scope="col" class="text-right">Importe</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                                                    
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
                                        <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly"
                                            value="0.00">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <a href="{{ route('NotaIngreso.index') }}" class="btn btn-danger form-control"><i
                                class="fas fa-arrow-left"></i>
                            Cancelar</a>
                    </div>
                    <div class="col-md-3">
                        <button type="button" onclick="grabar()" class="btn btn-primary form-control"><i class="fas fa-save"></i> Grabar
                        </button>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </form>
    @include('administrador.notas.modalProductos')
@endsection
@section('script')
    <script src="/js/datatables/jquery.dataTables.min.js"></script>
    <script src="/js/notaingreso-create.js"></script>
@endsection
