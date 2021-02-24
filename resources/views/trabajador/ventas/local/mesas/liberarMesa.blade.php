@extends('layout.plantilla_trabajador')
@section('contenido')
<br>
<div class="card">
    <div class="card-header">
        <h4>¡Liberar mesa: M-{{$mesa->nromesa}}!</h4>
    </div>
    <div class="card-body">
        <p class="card-text">
            <h5>Reserva actual</h5>
            <div class="row">
                <div class="col-sm-2" style="padding-top: 5px">
                    <label>Nº Reserva:</label>
                </div>
                <div class="col-sm-2">
                    <input disabled class="form-control" type="text" value="{{$reserva->formato($reserva->reserva_id)}}"
                        style="text-align: center">
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-2" style="padding-top: 5px">
                    <label>Hora:</label>
                </div>
                <div class="col-sm-2">
                    <input disabled class="form-control" type="text" value="{{$reserva->fecha->format('h:i a')}}"
                        style="text-align: center">
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-2" style="padding-top: 5px">
                    <label>Cliente: </label>
                </div>
                <div class="col-sm-5">
                    <input disabled class="form-control" type="text"
                        value="{{$reserva->Cliente->Persona->nombres.' '.$reserva->Cliente->Persona->apellidos}}">
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-2" style="padding-top: 5px">
                    <label>Dirección: </label>
                </div>
                <div class="col-sm-5">
                    <input disabled class="form-control" type="text" value="{{$reserva->Cliente->Persona->direccion}}">
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-2" style="padding-top: 5px">
                    <label>Estado: </label>
                </div>
                <div class="col-sm-2">
                    <input disabled class="form-control" type="text" value="{{$reserva->estado}}">
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-2">
                    <a href="{{route('home')}}" class='form-control btn btn-danger'>
                        <i class='fas fa-arrow-left'></i>
                        Cancelar</a>
                </div>
                <div class="col-sm-2">
                    <form method="POST" action="{{route('mesas.liberarMesa', $reserva->reserva_id)}}">
                        @csrf
                        <button type="submit" class="form-control btn btn-primary">
                            <i class='fas fa-undo-alt'></i> Liberar Mesa</button>
                    </form>
                </div>
            </div>
        </p>
    </div>
</div>
@endsection