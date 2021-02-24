@extends('layout.plantilla_trabajador')
@section('contenido')
<link rel="stylesheet" href="/css/preview-image.css">
<br>
<div class="card">
    <div class="card-header">
        <h4><strong>MESA</strong></h4>
    </div>
    <div class="card-body">
        <h5 class="card-title"><u>.::Nueva Mesa</u></h5>
        <p class="card-text">
            <form action="{{route('mesas.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-1" style="padding-top: 5px">
                        <label>Nº Mesa</label>
                    </div>
                    <div class="col-sm-1">
                        <input required type="text" maxlength="4" value="{{old('nromesa')}}" id="nromesa" name="nromesa"
                            class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-sm-2">
                        <a href="{{route('mesas.index')}}" class="form-control btn btn-danger"><i
                                class="fas fa-arrow-left"></i>
                            Cancelar</a>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="form-control btn btn-primary"><i class="fas fa-save"></i>
                            Guardar</button>
                    </div>
                </div>
            </form>
        </p>
    </div>
</div>
@endsection