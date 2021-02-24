@extends('layout.plantilla_admin')
@section('contenido')
    <div class="card">
        <div class="card-header">
            <h4><strong>BEBIDAS</strong></h4>
        </div>
        <div class="card-body">
            <h5 class="card-title"><u>.::Nueva Bebida</u></h5>
            <p class="card-text">
            <form action="{{ route('producto.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <label>Nombre:</label>
                        <input class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre"
                            type="text" placeholder="Ingrese nombre" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-md-6">
                        <label>Categoría:</label>
                        <select name="idcategoria" id="idcategoria" class="form-control">
                            @foreach ($categorias as $row)
                                <option value="{{ $row['idcategoria'] }}">{{ $row['descripcion'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-md-6">
                        <label>P. Costo:</label>
                        <input class="form-control @error('p_costo') is-invalid @enderror" id="p_costo" name="p_costo"
                            type="number" min=".1" step=".1" placeholder="Ingrese precio costo" value="{{ old('p_costo') }}"
                            required>
                        @error('p_costo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-md-6">
                        <label>P. Venta:</label>
                        <input class="form-control @error('p_venta') is-invalid @enderror" id="p_venta" name="p_venta"
                            type="number" min=".1" step=".1" placeholder="Ingrese precio venta" value="{{ old('p_venta') }}"
                            required>
                        @error('p_venta')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-md-6">
                        <label>Stock:</label>
                        <input class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock"
                            type="number" min="0" step="1" placeholder="Ingrese stock" value="{{ old('stock') }}" required>
                        @error('stock')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <a href="{{ route('producto.index') }}" class="btn btn-danger btn-block"><i
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
