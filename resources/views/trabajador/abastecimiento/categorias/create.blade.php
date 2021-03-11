@extends($plantilla)
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h4><strong>CATEGORÍAS</strong></h4>
        </div>
        <div class="card-body">
            <h5 class="card-title"><u>.::Nueva Categoría</u></h5>
            <p class="card-text">
            <form action="{{ route('categoria.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-sm-6">
                        <label>Descripción</label>
                        <input class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                            name="descripcion" type="text" placeholder="Ingrese descripción"
                            value="{{ old('descripcion') }}" required>
                        @error('descripcion')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <a href="{{ route('categoria.index') }}" class="btn btn-danger btn-block"><i
                                    class="fas fa-arrow-left">
                                </i> Volver</a>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"> </i> Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            </p>
        </div>
    </div>
@endsection
