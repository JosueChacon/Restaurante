@extends('layout.plantilla_trabajador')
@section('contenido')
    <i class="fas fa-file-signature text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Mostrador</font>
    @if (session('good'))
        <div class="alert alert-success alert-dissmissible fade show mt-3" role="alert">
            {{ session('good') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dissmissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card">
        <div class="card-header border shadow">
            <span class="text-bold">Haga click en imagen de una mesa para registrar pedido.</span>
        </div>
        <div class="card-body border shadow">
            <div class="row">
                @foreach ($mesas as $item)
                    <div class="col-md-2 col-6 text-center pb-3">
                        <a href="{{ route('tpedidos.crearPedido', $item->mesa_id) }}">
                            <abbr title="Click para reservar mesa" style="text-decoration: none; cursor: pointer">
                                <img src="/img/{{ $item->compruebaEstadoMesa($item->mesa_id) == 'LIBRE' ? 'mesa' : 'mesa-ocupada' }}.jpg"
                                    alt="Mesa" class="rounded-circle img-thumbnail"
                                    style="width: 120px; height: 120px;"><br>
                            </abbr>
                        </a>
                        MESA {{ $item->nromesa }} <br>
                        @if ($item->compruebaEstadoMesa($item->mesa_id) == 'OCUPADA')
                            {{ session(['fuente' => 'HOME']) }}
                            <abbr title="Editar Pedido" style="text-decoration: none; cursor: pointer">
                                <a href="{{ route('ModificarPedido', $item->PedidoActivo()) }}"><i
                                        class="fas fa-edit text-danger"></i></a>
                            </abbr>
                            <abbr title="Imprimir Cocina" style="text-decoration: none; cursor: pointer">
                                <a href="{{ route('imprimirTPedidoEstado', $item->PedidoActivo()) }}" target="_Blank"><i
                                        class="fas fa-print text-success"></i></a>
                            </abbr>
                            <abbr title="Imprimir Pre-Cuenta" style="text-decoration: none; cursor: pointer">
                                <a href="{{ route('imprimirTPedido', $item->PedidoActivo()) }}" target="_Blank"><i
                                        class="fas fa-print text-primary"></i></a>
                            </abbr>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
