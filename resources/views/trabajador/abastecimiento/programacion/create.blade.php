@extends('layout.plantilla_admin')
@section('contenido')
    <i class="fas fa-plus-square text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Registro de programación
    </font>
    <form action="{{ route('programacion.store') }}" method="POST" id="frmProgramacion">
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
                                <span>.::Detalle de programación</span>
                            </div>
                            <div class="card-body border shadow">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Plato</label>
                                        <input disabled class="form-control" type="text" id="nombre" name="nombre"
                                            value="{{ old('nombre') }}">
                                        <input hidden disabled class="form-control" type="text" id="idplato" name="idplato"
                                            value="{{ old('idplato') }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Tipo</label>
                                        <input disabled class="form-control" type="text" id="descripcion" name="descripcion"
                                            value="{{ old('descripcion') }}">
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-sm-2">
                                        <label>P. Compra</label>
                                        <input disabled class="form-control" type="text" id="p_compra" name="p_compra"
                                            value="{{ old('p_compra') }}">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>P. Venta</label>
                                        <input disabled class="form-control" type="text" id="p_venta" name="p_venta"
                                            value="{{ old('p_venta') }}">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Cantidad</label>
                                        <input class="form-control" type="number" min="1" step="1" id="cantidad"
                                            name="cantidad" value="1"
                                            onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="">&nbsp;</label><br>
                                        <button type="button" class="form-control btn btn-primary" data-toggle="modal"
                                            data-target="#exampleModal">
                                            <i class="fas fa-search"></i>
                                            Buscar Platos
                                        </button>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="">&nbsp;</label><br>
                                        <button type="button" class="form-control btn btn-success" onclick="buscar()">
                                            <i class="fas fa-arrow-down"></i>
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="tabla">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">Código</th>
                                                        <th scope="col">Plato</th>
                                                        <th scope="col">Tipo Plato</th>
                                                        <th scope="col">P. Compra</th>
                                                        <th scope="col">P. Venta</th>
                                                        <th scope="col">Cantidad</th>
                                                        <th scope="col" class="text-center">¿Quitar?</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('programacion.index') }}" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
                    Cancelar</a>
                <button type="button" id="grabar" class="btn btn-primary"><i class="fas fa-save"></i> Grabar </button>
            </div>
        </div>
        <br>
        <table hidden class="table" id="data-table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">idplato</th>
                    <th scope="col">cantidad</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </form>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Platos Disponibles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            @foreach ($platos as $f)
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <img src="{{ asset($f->getRutaFoto()) }}" width="300" class="img-fluid"
                                            alt="Responsive image"><br>
                                        <strong>Nombre : </strong>{{ $f->nombre }}<br>
                                        <strong>Tipo Plato : </strong> {{ $f->tipoplato->descripcion }} <br>
                                        <strong>P. Compra : </strong>S/. {{ $f->p_costo }}<br>
                                        <strong>P. Venta : </strong>S/. {{ $f->p_venta }}<br>
                                        <button type="button" class="btn btn-warning"
                                            onclick="return pasar('{{ $f->id }}', '{{ $f->nombre }}','{{ $f->tipoplato->descripcion }}','{{ $f->p_venta }}','{{ $f->p_costo }}')"
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
    <script src="/js/programacion-create.js"></script>
    <script type="text/javascript">
        function pasar(a, x, y, z, b) {
            document.getElementById("idplato").value = a;
            document.getElementById("nombre").value = x;
            document.getElementById("descripcion").value = y;
            document.getElementById("p_venta").value = z;
            document.getElementById("p_compra").value = b;
            return true;
        }

    </script>
    <script type="text/javascript">
        function agregar() {
            var id = $('#idplato').val();
            var nombre = $('#nombre').val();
            var tipoplato = $('#descripcion').val();
            var p_compra = $('#p_compra').val();
            var p_venta = $('#p_venta').val();
            var cantidad = $('#cantidad').val();
            var fila = '<tr>' +
                '<td>' + id + '</td>' +
                '<td>' + nombre + '</td>' +
                '<td>' + tipoplato + '</td>' +
                '<td>' + p_compra + '</td>' +
                '<td>' + p_venta + '</td>' +
                '<td>' + cantidad + '</td>' +
                '<td class="text-center"><a href="#" onclick="deleteRow(this); return false;" class="btn-sm btn btn-danger"><i class="fas fa-trash"></i> Quitar</a></td>' +
                '</tr>';
            $('#tabla').append(fila);

            var f = '<tr>' +
                '<td><input class="form-control" type="text" name="idplato[]" value="' + id + '" readonly></td>' +
                '<td><input class="form-control" type="text" name="cantidad[]" value="' + cantidad + '" readonly></td>' +
                '</tr>';
            $('#data-table').append(f);

            document.getElementById("idplato").value = "";
            document.getElementById("nombre").value = "";
            document.getElementById("descripcion").value = "";
            document.getElementById("p_venta").value = "";
            document.getElementById("p_compra").value = "";
            document.getElementById("cantidad").value = "1";
        }

        function deleteRow(t) {
            var pos = t.parentNode.parentNode.rowIndex;
            document.getElementById('tabla').deleteRow(pos);
            document.getElementById('data-table').deleteRow(pos);
        }

        function buscar() {
            var idplato = $('#idplato').val();
            if (idplato == '') {
                alert('Seleccione un plato, Porfavor');
                return;
            }
            var cant = $('#cantidad').val();
            if (cant == '') {
                alert('Ingrese cantidad, Porfavor');
                return;
            }
            let cantidad = parseFloat($('#cantidad').val());
            if (cantidad == 0) {
                alert('La cantidad debe ser mayor a 0');
                return;
            }

            var table = document.getElementById('tabla');
            var encontrado = false;

            for (i = 0; i < table.rows.length; i++) {
                if (idplato == table.rows[i].cells[0].innerText) {
                    encontrado = true;
                    break;
                }
            }
            if (encontrado == false) {
                agregar();
            } else
                alert('El plato ya está en lista');
        }

    </script>
@endsection
