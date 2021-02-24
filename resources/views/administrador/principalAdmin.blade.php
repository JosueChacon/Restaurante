@extends('layout.plantilla_admin')
@section('contenido')
    <div class="row">
        <div class="col-12">
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
            <div class="callout callout-info">
                <h5><i class="fas fa-info"></i> Información:</h5>
                Bienvenido estimado Administrador.
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>
                        S/. &nbsp;
                        @if (isset($montoencaja))
                            {{ number_format($montoencaja, 2) }}
                        @else
                            0.00
                        @endif
                    </h3>

                    <p>Ventas del día</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="{{ URL::to('consultas/MontoEnCaja') }}" class="small-box-footer">
                    Más detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>
                        # &nbsp;
                        @if (isset($cant_recibos))
                            {{ $cant_recibos }}
                        @else
                            0
                        @endif
                    </h3>

                    <p>Cantidad de Recibos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list-alt"></i>
                </div>
                <a href="{{ URL::to('consultas/MontoEnCaja') }}" class="small-box-footer">
                    Más detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>
                        # &nbsp;
                        @if (isset($trabajadores))
                            {{ count($trabajadores) }}
                        @else
                            0
                        @endif
                    </h3>

                    <p>Trabajadores</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <a href="{{ URL::to('consultas/MiGente') }}" class="small-box-footer">
                    Más detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>
                        # &nbsp;
                        @if (isset($clientes))
                            {{ count($clientes) }}
                        @else
                            0
                        @endif
                    </h3>

                    <p>Clientes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ URL::to('consultas/MisClientes') }}" class="small-box-footer">
                    Más detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('stockProductos') }}" target="_Blank" class="btn btn-primary form-control"><i
                    class="fas fa-file-signature"></i> Reporte Stock Bebidas</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('stockPlatos') }}" target="_Blank" class="btn btn-primary form-control"><i
                class="fas fa-file-signature"></i> Reporte Stock Platos</a>
        </div>
    </div>
@endsection
