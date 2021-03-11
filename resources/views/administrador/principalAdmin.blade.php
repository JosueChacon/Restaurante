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
                    <span>Ventas del día</span>
                    <h3>
                        <span style="font-size: 18pt">
                            S/. &nbsp; {{ number_format($total, 2) }}
                        </span>
                    </h3>                    
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="{{ URL::to('consultas/MontoEnCaja') }}" class="small-box-footer">
                    Ver más... <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <span>Recibos Emitidos</span>
                    <h3>
                        <span style="font-size: 18pt">
                            # &nbsp; {{ $cant_recibos }}
                        </span>
                    </h3>
                </div>
                <div class="icon">
                    <i class="fas fa-file-signature"></i>
                </div>
                <a href="{{ URL::to('consultas/MontoEnCaja') }}" class="small-box-footer">
                    Ver más... <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <span>Trabajadores</span>
                    <h3>
                        <span style="font-size: 18pt">
                            # &nbsp; {{ $cant_trabajadores }}
                        </span>                        
                    </h3>
                </div>
                <div class="icon">
                    <i class="fas fa-people-carry"></i>
                </div>
                <a href="{{ URL::to('consultas/MiGente') }}" class="small-box-footer">
                    Ver más... <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <span>Clientes</span>
                    <h3>
                        <span style="font-size: 18pt">
                            # &nbsp; {{ $cant_clientes }}
                        </span>                          
                    </h3>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ URL::to('consultas/MisClientes') }}" class="small-box-footer">
                    Ver más... <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-12 pt-2">
            <a href="{{ route('stockProductos') }}" target="_Blank" class="btn btn-outline-primary form-control"><i
                    class="fas fa-file-signature"></i> Reportar stock de bebidas</a>
        </div>
        <div class="col-md-4 col-12 pt-2">
            <a href="{{ route('stockPlatos') }}" target="_Blank" class="btn btn-outline-primary form-control"><i
                    class="fas fa-file-signature"></i> Reportar stock de platos</a>
        </div>
    </div>
@endsection
