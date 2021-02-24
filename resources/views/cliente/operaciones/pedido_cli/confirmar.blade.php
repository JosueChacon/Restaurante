@extends('layout.plantilla_cliente')
@section('contenido')
<br>
<div class="card">
    <div class="card-header">
        <h4>" Pedidos de {{auth()->user()->Persona->nombres}} "</h4>
    </div>
    <div class="card-body">
        <h5 class="card-title"><u>.::Anular Pedido</u></h5>
        <p class="card-text">
            <h3><label for="">Información</label></h3>
            <label for="">Código: </label> {{$pedido->idpedido}}<br>
            <label for="">Fecha: </label> {{$pedido->fecha->format('d M Y')}}<br>
            <label for="">Hora: </label> {{$pedido->fecha->format('h:i a')}}<br>     
            ¿Desea eliminar?
            <form action="{{route('pedidosCliente.destroy', $pedido->idpedido)}}" method="POST">
                @method('DELETE')
                @csrf
                <div class="mx-auto">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-check-square"></i>
                        Si
                    </button>
                    <a href="{{route('pedidosCliente.index')}}" class="btn btn-sm btn-primary">
                        <i class="fas fa-times-circle"></i>
                        NO
                    </a>
                </div>
            </form>
        </p>
    </div>
</div>
@endsection