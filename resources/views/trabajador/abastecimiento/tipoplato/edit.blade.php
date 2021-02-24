@extends('layout.plantilla_admin')
@section('contenido')
<link rel="stylesheet" href="/css/preview-image.css">
<br>
<div class="card">
    <div class="card-header">
        <h4><strong>TIPO DE PLATO</strong></h4>
    </div>
    <div class="card-body">
        <h5 class="card-title"><u>.::Modificar Tipo de Plato</u></h5>
        <p class="card-text">
            <form action="{{route('tipoplato.update', $tipoplato->id)}}" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <img src="{{asset($tipoplato->getRutaFoto())}}" width="400" class="img-fluid"
                                alt="Imagen Tipo de Plato">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label>Descripción</label>
                        <input class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                            name="descripcion" type="text" placeholder="Ingrese descripción"
                            value="{{ $tipoplato->descripcion }}" required>
                        @error('descripcion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label>¿Cambiar Imagen?</label>
                        <input class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto"
                            type="file" style="padding: 3px">
                        @error('foto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="image-preview" id="imagePreview">
                            <img src="" alt="Image preview" class="image-preview__image" id="immm">
                            <span class="image-preview__default-text">Vista Previa</span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <a href="{{route('tipoplato.index')}}" class="btn btn-danger btn-block"><i
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