@extends('layout.plantilla_cliente')
@section('contenido')
<br>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (session('good'))
                <div class="alert alert-success alert-dissmissible fade show mt-3" role="alert">
                    {{session('good')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger alert-dissmissible fade show mt-3" role="alert">
                    {{session('error')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Información:</h5>
                    Bienvenido. Usted ha accedido como cliente de la empresa, acontinuación se detallan sus
                    datos.
                </div>

                <div class="invoice p-3 mb-3">
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-user"></i> Datos del usuario
                                <small class="float-right">Fecha: {{ date("d/m/y") }}</small>
                            </h4>
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            Datos Personales
                            <address>
                                <strong>Nombres: </strong> {{auth()->user()->Persona->nombres}}<br>
                                <strong>Apellidos: </strong>{{auth()->user()->Persona->apellidos}}<br>
                                <strong>Dirección: </strong>{{auth()->user()->Persona->direccion}}<br>
                                <strong>Celular: </strong>{{auth()->user()->Persona->celular}}<br>
                            </address>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            Datos de Acceso
                            <address>
                                <strong>Usuario: </strong>{{auth()->user()->name}}<br>
                                <strong>Clave: </strong>********<br>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>
                            Platos:
                            @if(isset($prog->DProgramacion))
                            {{$prog->DProgramacion->count()}}
                            @else
                            0
                            @endif
                        </h3>

                        <p>Cartilla</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <a href="{{ route('home.hoy') }}" class="small-box-footer">
                        Programación de hoy <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection