@extends('layout.plantilla_admin')
@section('contenido')
    <i class="fas fa-list text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Mesas
    </font>
    <div class="card">
        <div class="card-header border shadow">
            <div class="row">
                <div class="col-md-12">
                    <a class="form-control btn btn-primary" href="{{ route('mesas.create') }}"><i
                            class="fas fa-plus-square"></i> Registrar Mesa</a>
                </div>
            </div>
        </div>
        <div class="card-body border shadow">
            @if (session('good'))
                <div class="alert alert-success alert-dissmissible fade show mt-3" role="alert">
                    {{ session('good') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
                            aria-hidden="true">&times;</span>
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
            <span style="color: red; font-size: 11pt">*</span>
            <span style="font-size: 11pt">Haga click en una imagen para editar mesa.</span>
            <div class="row">
                @foreach ($mesas as $item)
                    <div class="col-md-2 col-6 text-center">
                        <a href="{{ route('mesas.edit', $item->mesa_id) }}">
                            <abbr title="Click para editar" style="text-decoration: none; cursor: pointer">
                                <img src="/img/mesa.jpg" alt="Mesa" class="rounded-circle img-thumbnail"
                                    style="width: 120px; height: 120px;"><br>
                            </abbr>
                        </a>
                        <a href="{{ route('mesas.show', $item->mesa_id) }}">
                            <span>
                                <abbr title="Click para eliminar" style="text-decoration: none; cursor: pointer">
                                    MESA {{ $item->nromesa }}
                                </abbr>
                            </span><br>
                        </a><br>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
