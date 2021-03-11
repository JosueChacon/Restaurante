@extends($plantilla)
@section('contenido')
    <i class="fas fa-question text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Consulta de pedidos, {{ date('d-m-Y') }}
    </font>
    <div class="card">
        <div class="card-body border shadow">
            <form action="">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Mesero:</label>
                        <select name="idtrabajador" id="idtrabajador" class="form-control">
                            <option value="0">---- TODOS LOS MESEROS ----</option>
                            @foreach ($meseros as $item)
                                <option value="{{ $item['idtrabajador'] }}"
                                    {{ $item['idtrabajador'] == $idtrabajador ? 'selected' : '' }}>
                                    MESERO: {{ $item->Persona->nombres_apellidos() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="">Estado pedido:</label>
                        <select name="cbxtipo" class="form-control mr-sm-2" id="cbxtipo">
                            <option value="Confirmado" {{ 'Confirmado' == $cbxtipo ? 'selected' : '' }}>Confirmado
                            </option>
                            <option value="Atendido" {{ 'Atendido' == $cbxtipo ? 'selected' : '' }}>Atendido</option>
                            <option value="Pagado" {{ 'Pagado' == $cbxtipo ? 'selected' : '' }}>Pagado</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-success form-control" type="submit"><i
                                class="fas fa-search"></i>Buscar</button>
                    </div>
                </div>
            </form>
            <div class="row pt-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Mesa</th>
                                    <th scope="col">Nº pedido</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Mesero</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col" class="text-right">Total</th>
                                    <th scope="col" class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pedidos as $item)
                                    <tr>
                                        <td>MESA {{ $item->Reserva->Mesa['nromesa'] }}</td>
                                        <td>{{ $item->formato($item->idpedido) }}</td>
                                        <td>{{ $item->fecha->format('h:i a') }}</td>
                                        <td>{{ $item->Trabajador->Persona->nombres_apellidos() }}
                                        <td>{{ $item->Cliente->Persona->nombres_apellidos() }}
                                        </td>
                                        <td>{{ $item->estado }}</td>
                                        <td class="text-right">S/. {{ $item->Total($item->DPedido) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('consultas.pedidos.detalles', $item->idpedido) }}"
                                                style="margin-top: -7px" class="btn btn-sm btn-success"><i
                                                    class="fas fa-list-alt"></i>
                                                Detalles</a>
                                            <a target="_blank" href="{{ route('imprimirTPedido', $item->idpedido) }}"
                                                style="margin-top: -7px" class="btn btn-sm btn-primary"><i
                                                    class="fas fa-print"></i>
                                                Imprimir</a>
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
@endsection
