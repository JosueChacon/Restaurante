@extends('layout.plantilla_admin')
@section('contenido')
<link rel="stylesheet" href="/css/preview-image.css">
<div class="card">
    <div class="card-header">
        <h4><strong>PLATOS</strong></h4>
    </div>
    <div class="card-body">
        <h5 class="card-title"><u>.::Nuevo Plato</u></h5>
        <p class="card-text">
            <form action="{{route('plato.store')}}" id="frmPlato" method="POST" enctype="multipart/form-data"
                onsubmit="return validar_plato()">
                @csrf
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nombre</label>
                            <input class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre"
                                type="text" maxlength="50" placeholder="Ingrese nombre" value="{{ old('nombre') }}"
                                required>
                            @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Tipo de Plato</label>
                            <select name="idtipoplato" id="idtipoplato" class="form-control">
                                @foreach ($tipos as $f)
                                <option value="{{$f->id}}">{{$f->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>P. Costo</label>
                            <input class="form-control @error('p_costo') is-invalid @enderror" id="p_costo"
                                name="p_costo" type="text" value="{{old('p_costo')}}" required
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode==46"
                                maxlength="10">
                            @error('p_costo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label>P. Venta</label>
                            <input class="form-control @error('p_venta') is-invalid @enderror" id="p_venta"
                                name="p_venta" type="text" value="{{old('p_venta')}}"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode==46"
                                maxlength="10">
                            @error('p_venta')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Seleccione Imagen</label>
                            <input class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto"
                                type="file" accept="image/*" style="padding: 3px" value="{{ old('foto') }}">
                            @error('foto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="image-preview" id="imagePreview">
                                <img src="" alt="Image preview" class="image-preview__image">
                                <span class="image-preview__default-text">Vista Previa</span>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{route('plato.index')}}" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
                    Cancelar</a>
                <button type="button" id="grabar" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </form>
        </p>
    </div>
</div>
@endsection
@section('script')
<script src="/js/validaciones.js"></script>
<script src="/js/plato-create.js"></script>
<script>
    const foto = document.getElementById("foto");
    const previewContainer = document.getElementById("imagePreview");
    const previewImage = previewContainer.querySelector(".image-preview__image");
    const previewDefaultText = previewContainer.querySelector(".image-preview__default-text");

    foto.addEventListener("change", function(){
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            previewDefaultText.style.display = "none";
            previewImage.style.display = "block";
            reader.addEventListener("load", function(){
                previewImage.setAttribute("src", this.result);
            });
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection