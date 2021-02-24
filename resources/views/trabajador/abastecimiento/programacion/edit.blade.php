@extends('layout.plantilla_admin')
@section('contenido')
    <i class="fas fa-plus-square text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Editar programación
    </font>
    <form action="{{ route('programacion.update', $programacion->idprogramacion) }}" method="POST" id="frmProgramacion">
        @method('put')
        @csrf
        <div class="card">
            <div class="card-body border shadow">
                <div class="row">
                    <div class="col-md-2">
                        <label>Código:</label>
                        <input disabled class="form-control" type="text" placeholder="Ingrese costo"
                            value="{{ $programacion->idprogramacion }}" style="text-align: center">
                    </div>
                    <div class="col-md-2">
                        <label>Fecha:</label>
                        <input disabled class="form-control" type="text" placeholder="Ingrese costo"
                            value="{{ $programacion->fecha->format('d/m/Y') }}">
                    </div>
                    <div class="col-md-2">
                        <label>Hora:</label>
                        <input disabled class="form-control" type="text" placeholder="Ingrese costo"
                            value="{{ $programacion->fecha->format('h:i a') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Responsable:</label>
                        <input disabled class="form-control" type="text" placeholder="Ingrese costo"
                            value="{{ auth()->user()->Persona->nombres_apellidos() }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mt-4">
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
                                        <button type="button" class="form-control btn btn-success" onclick="agregar()">
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
                                                        <th style="width: 50pt">Código</th>
                                                        <th>Plato</th>
                                                        <th>Tipo Plato</th>
                                                        <th class="text-right">P. Compra</th>
                                                        <th class="text-right">P. Venta</th>
                                                        <th class="text-right" style="width: 70pt">Cantidad</th>
                                                        <th class="text-center">¿Quitar?</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($programacion->DProgramacion as $item)
                                                        <tr>
                                                            <td hidden><input type="text" name="idplato[]" id=""
                                                                    value="{{ $item->Plato->id }}"></td>
                                                            <td>{{ $item->Plato->id }}</td>
                                                            <td>{{ $item->Plato->nombre }}</td>
                                                            <td>{{ $item->Plato->TipoPlato->descripcion }}</td>
                                                            <td class="text-right">{{ $item->Plato->p_costo }}</td>
                                                            <td class="text-right">{{ $item->Plato->p_venta }}</td>
                                                            <td class="text-right">
                                                                <input type="number" name="cantidad[]" id="" min="1"
                                                                    step="1" class="form-control"
                                                                    value="{{ $item->stock }}">
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="deleteRow(this)"> <i class="fas fa-trash"></i>
                                                                </button>
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
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <a href="{{ route('programacion.index') }}" class="btn btn-danger form-control">
                            <i class="fas fa-arrow-left"></i>
                            Cancelar
                        </a>
                    </div>
                    <div class="col-md-3">
                        <button type="button" id="grabar" class="btn btn-primary form-control"><i class="fas fa-save"></i>
                            Grabar
                        </button>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </form>
    @include('trabajador.abastecimiento.programacion.bPlatos')
    @include('utilitarios.modalMensaje')
@endsection
@section('script')
    <script src="/js/programacion-edit.js"></script>
    <script type="text/javascript">
        function pasar(idplato, nombre, descripcion, p_venta, p_compra) {
            $('#idplato').val(idplato)
            $('#nombre').val(nombre)
            $('#descripcion').val(descripcion)
            $('#p_venta').val(p_venta)
            $('#p_compra').val(p_compra)
        }

        function agregar() {
            var idplato = $('#idplato').val();
            if (idplato == '') {
                $('#modalContenido').html('Seleccione un plato, porfavor.')
                $('#modalError').modal('show')
                return
            }

            if (buscar(idplato)) {
                $('#modalContenido').html('El plato seleccionado ya se añadió a los detalles.')
                $('#modalError').modal('show')
                return
            }

            var cant = $('#cantidad').val();
            let cantidad = parseFloat($('#cantidad').val());

            var msj = ''
            if (cant == '') msj = 'Ingrese cantidad, Porfavor'
            if (cantidad == 0) msj = 'La cantidad debe ser mayor a 0'
            if (msj != '') {
                $('#modalContenido').html(msj)
                $('#modalError').modal('show')
                return
            }
            agregar_item()
        }

        function buscar(idplato) {
            var table = document.getElementById('tabla');
            for (i = 0; i < table.rows.length; i++) {
                if (idplato == table.rows[i].cells[1].innerText) {
                    return true
                }
            }
            return false
        }

        function agregar_item() {
            var id = $('#idplato').val();
            var nombre = $('#nombre').val();
            var tipoplato = $('#descripcion').val();
            var p_compra = $('#p_compra').val();
            var p_venta = $('#p_venta').val();
            var cantidad = $('#cantidad').val();

            var fila = '<tr>' +
                '<td hidden><input type="text" name="idplato[]" id="" value="' + id + '"></td>' +
                '<td>' + id + '</td>' +
                '<td>' + nombre + '</td>' +
                '<td>' + tipoplato + '</td>' +
                '<td class="text-right">' + p_compra + '</td>' +
                '<td class="text-right">' + p_venta + '</td>' +
                '<td class="text-right">' +
                '<input type="number" name="cantidad[]" id="" min="1" step="1" class="form-control" value="' + cantidad +
                '">' +
                '</td>' +
                '<td class="text-center">' +
                '<button type="button" class="btn btn-sm btn-danger" onclick="deleteRow(this)"> <i class="fas fa-trash"></i></button>' +
                '</td>' +
                '</tr>';
            $('#tabla').append(fila);

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
        }

    </script>
@endsection
