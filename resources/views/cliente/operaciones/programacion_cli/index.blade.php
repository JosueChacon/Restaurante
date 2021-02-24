@extends('layout.plantilla_cliente')
@section('contenido')
<br>
<div class="card">
    <div class="card-header">
        @if(isset($detalles))
        <font style="font-family: times new roman; font-size: 16pt">Programación del día</font>
        @else
        <font style="font-family: times new roman; font-size: 16pt">
            Para hoy no hay platos programados. A continuación, se le muestra toda la cartilla.
        </font>
        @endif
    </div>
    <div class="card-body">
        @if(isset($detalles))
        <form>
            <div class="row">
                <div class="col-sm-4 col-8">
                    <input style="font-family: times new roman" name="buscarpor" class="form-control" type="search" placeholder="Buscar por nombre de plato"
                        value="{{$buscarpor}}">
                </div>
                <div class="col-sm-1 col-4">
                    <button class="btn btn-success form-control" type="submit">Buscar</button>
                </div>
            </div>
        </form>
        <div class="row pt-2">
            <div class="col-sm-12">
                <font style="font-family: times new roman; font-size: 14pt">
                    Resultados: "<strong><u>{{$detalles->count()}}</u></strong>"
                </font>
            </div>
        </div>
        <div class="row pt-2">
            @foreach ($detalles as $f)
            <div class="col-sm-4">
                <img src="{{asset($f->plato->getRutaFoto())}}" width="400" class="img-fluid" alt="Responsive image">
                <font style="font-family: times new roman">
                    <strong>Tipo Plato : </strong> {{$f->plato->tipoplato->descripcion}} <br>
                </font>
                <font style="font-family: times new roman">
                    <strong>Nombre : </strong>{{$f->plato->nombre}}<br>
                </font>
                <font style="font-family: times new roman">
                    <strong>Precio : </strong>S/. {{$f->plato->p_venta}}<br>
                </font>
                <font style="font-family: times new roman">
                    <strong>Stock Aprox: </strong><u>{{$f->stock}}</u>
                </font>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="row">
        <div class="form-group">
            <div class="row">
                @foreach ($platos as $f)
                <div class="col-sm-4">
                    <div class="form-group">
                        <img src="{{asset($f->getRutaFoto())}}" width="400" class="img-fluid" alt="Responsive image">
                        <font style="font-family: times new roman">
                            <strong>Nombre : </strong>{{$f->nombre}}<br>
                        </font>
                        <font style="font-family: times new roman">
                            <strong>Tipo Plato : </strong> {{$f->tipoplato->descripcion}} <br>
                        </font>
                        <font style="font-family: times new roman">
                            <strong>Precio : </strong>S/. &nbsp;{{$f->p_venta}}<br>
                        </font>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
</div>
@endsection